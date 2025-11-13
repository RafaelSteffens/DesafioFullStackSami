#!/bin/sh

set -e

echo "Aguardando MySQL ficar disponível..."

# Loop até o MySQL responder
until php -r "
try {
    new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo 'MySQL conectado com sucesso.' . PHP_EOL;
} catch (Exception \$e) {
    echo 'Aguardando MySQL...' . PHP_EOL;
    exit(1);
}
"; do
  sleep 3
done

# Gerar APP_KEY se ainda não tiver
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
  echo "Gerando APP_KEY..."
  php artisan key:generate --force || true
fi

echo "Rodando migrations + seed..."
php artisan migrate --seed --force || true

echo "Iniciando servidor Laravel em http://0.0.0.0:8000"
php artisan serve --host=0.0.0.0 --port=8000
