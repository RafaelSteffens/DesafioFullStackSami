# DesafioSami – Cadastro de Pessoas

Aplicação Laravel 12 com Livewire 3 para gerenciamento de pessoas, preparada para rodar com [Laravel Herd](https://herd.laravel.com/). O projeto expõe uma API REST para operações de CRUD e uma interface Livewire utilizando Tailwind via Vite.

## Visão Geral

- **Backend:** Laravel 12 + API REST (`/api/people`).
- **Frontend:** Livewire 3 com Tailwind CSS, páginas `/pessoas`, `/pessoas/criar` e `/pessoas/{id}/editar`.
- **Regras de negócio:** validação de CPF brasileiro, normalização de dados e buscas paginadas por nome, e-mail ou CPF.
- **Qualidade:** Laravel Pint (lint), Pest para testes e Larastan para análise estática.

## Preparando o Ambiente com Laravel Herd

1. Clone o repositório e configure o domínio `desafiosami.test` no Herd apontando para a pasta do projeto.
2. Copie o arquivo `.env.example` para `.env` (ou deixe o Herd gerar automaticamente) e ajuste as variáveis se necessário.
3. Execute os comandos abaixo no terminal do projeto:

```bash
docker-compose up -d --build


composer install
npm install
npm run dev # ou npm run build para compilar os assets
php artisan key:generate
php artisan migrate --seed
```

Com o domínio configurado, acesse `https://desafiosami.test/` no navegador.

## Variáveis de Ambiente

O arquivo `.env.example` contém as variáveis mínimas para iniciar o projeto, basta remover o example, fiz assim para facilitar aos recrutadores mas sei que não se sobe o .env.

## Rotas Principais

### Web

| Método | Rota | Descrição |
| --- | --- | --- |
| GET | `/` | Redireciona para `/pessoas`. |
| GET | `/pessoas` | Lista paginada com busca. |
| GET | `/pessoas/criar` | Formulário de criação. |
| GET | `/pessoas/{person}/editar` | Formulário de edição. |

### API

| Método | Rota | Descrição |
| --- | --- | --- |
| GET | `/api/people` | Lista paginada com filtro `q`. |
| POST | `/api/people` | Cria uma pessoa. |
| PUT | `/api/people/{person}` | Atualiza uma pessoa. |
| DELETE | `/api/people/{person}` | Remove uma pessoa. |

## Exemplos de Uso da API

```bash
# Listar pessoas (busca opcional)
curl "https://desafiosami.test/api/people?q=maria"

# Criar uma nova pessoa
curl -X POST "https://desafiosami.test/api/people" \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Maria da Silva",
    "cpf": "11144477735",
    "data_nascimento": "1990-05-10",
    "email": "maria@example.com",
    "telefone": "(11) 99999-1234"
  }'

# Atualizar pessoa existente
curl -X PUT "https://desafiosami.test/api/people/1" \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Maria da Silva",
    "cpf": "11144477735",
    "data_nascimento": "1990-05-10",
    "email": "maria@exemplo.com",
    "telefone": "(11) 98888-8888"
  }'

# Remover pessoa
curl -X DELETE "https://desafiosami.test/api/people/1"
```

## Scripts Úteis

- `composer test` – executa os testes Pest.
- `composer lint` – roda o Laravel Pint (PSR-12).
- `composer stan` – executa Larastan (nível 5).


## Estrutura Principal

- `app/Services/PersonService.php` – regras de negócio e normalização.
- `app/Http/Controllers/Api/PersonController.php` – controlador REST.
- `app/Http/Requests/PersonStoreRequest.php` e `PersonUpdateRequest.php` – validação.
- `app/Rules/CpfBr.php` – validação de CPF.
- `app/Livewire/People/*` – componentes de listagem e formulário.
- `database/migrations/*create_people_table.php` – schema da tabela `people`.
- `database/factories/PersonFactory.php` e `database/seeders/PersonSeeder.php` – geração de dados.

Fiquei muito feliz com a oportunidade e espero avançar nas próximas etapas e ser contratado, estou tão animado pois percebi que posso ajudar muito a  Sami Sistemas
