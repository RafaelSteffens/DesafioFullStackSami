# Desafio Técnico – Cadastro de Pessoas (PHP/Laravel)
Implementação do desafio técnico solicitado pela Sami Sistemas, utilizando Laravel 12, Livewire 3, MySQL, API REST, Tailwind e ambiente totalmente automatizado via Docker. Você pode subir com o Herd ou o Docker de forma automatizada.

## Visão Geral

O sistema implementa um CRUD completo de Pessoas contendo os campos:
- nome
- cpf (validação + unicidade)
- data_nascimento
- email (validado + único)
- telefone

### Principais Tecnologias
- Laravel 12
- Livewire 3
- Tailwind CSS (via Vite)
- API RESTful em `/api/people`
- Service Layer para regras de negócio
- Form Requests para validações
- Docker (backend + MySQL + phpMyAdmin)
- Execução automatizada: composer, npm, build, key:generate, migrate --seed

---

## Clone o repositório

```bash
git clone https://github.com/RafaelSteffens/DesafioFullStackSami.git
```

## Como Rodar com Laravel Herd 

Siga os passos abaixo para executar o projeto usando o Laravel Herd, conforme solicitado no desafio.

1. Abra o projeto no Herd

2. Clique em “Add Project”

3. Selecione a pasta clonada deste repositório

O Herd irá gerar automaticamente um domínio no formato:

https://desafiosami.test


Em seguida, abra o terminal dentro do projeto e execute:
```bash
docker up -d --build
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Acesse a aplicação pelo domínio configurado no Herd:

https://desafiosami.test


---

## Como Rodar com Docker (Recomendado)

Todo o ambiente é iniciado automaticamente com um único comando:

```bash
docker-compose up --build

```

Esse comando realiza automaticamente:

  -composer install

  -npm install

  -npm run build

  -php artisan key:generate

  -php artisan migrate --seed

  -inicia o servidor Laravel

## Serviços Disponíveis

  -Backend Laravel: http://localhost:8000

  -phpMyAdmin: http://localhost:8081

  -MySQL: localhost:3306






## Variáveis de Ambiente

Para fins do desafio eu subi o .env no repositorio git. Mas sabemos que em aplicações reais ele seria removido e seria feito apartir do .env.example

## Rotas Principais

### Web

| Método | Rota | Descrição |
| --- | --- | --- |
| GET | `/` | Redireciona para `/pessoas`. |
| GET | `/pessoas` | Lista paginada com busca. |
| GET | `/pessoas/criar` | Formulário de criação. |
| GET | `/pessoas/{id}/editar` | Formulário de edição. |

### API

| Método | Rota | Descrição |
| --- | --- | --- |
| GET | `/api/people` | Lista paginada com filtro `q`. |
| POST | `/api/people` | Cria uma pessoa. |
| PUT | `/api/people/{person}` | Atualiza uma pessoa. |
| DELETE | `/api/people/{person}` | Remove uma pessoa. |


Fiquei muito feliz com a oportunidade e espero avançar nas próximas etapas e ser contratado, estou tão animado pois percebi que posso ajudar muito a  Sami Sistemas
