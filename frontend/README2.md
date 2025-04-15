# Desafio Técnico - Adriano Cobuccio

Este projeto foi desenvolvido como parte de um desafio técnico e segue boas práticas de desenvolvimento em Laravel, incluindo uma arquitetura em camadas, autenticação via JWT, observabilidade com Telescope, testes unitários e documentação completa com Swagger.

## 🔧 Arquitetura Utilizada

O projeto segue o padrão de arquitetura **Service-Repository Pattern**, que organiza o código em camadas para garantir melhor manutenibilidade, testabilidade e escalabilidade. As principais camadas são:

- **Controllers**: Responsáveis por receber as requisições, acionar os serviços e retornar as respostas apropriadas.
- **Services**: Contêm a lógica de negócio da aplicação. Essa camada orquestra as chamadas para os repositórios e outros serviços.
- **Repositories**: Responsáveis por interagir diretamente com os modelos e o banco de dados, encapsulando a lógica de acesso a dados.
- **Models**: Representam as entidades e tabelas do banco de dados no Laravel (Eloquent ORM).

## 🔐 Autenticação e Segurança

A segurança da aplicação é garantida com **JWT (JSON Web Token)**, utilizando a biblioteca `tymon/jwt-auth`, que oferece:

- Login e geração de tokens.
- Middleware para proteger rotas autenticadas.
- Facilidade para revogar tokens.

## 🛡️ Middleware

O projeto utiliza **middlewares personalizados e nativos do Laravel** para:

- Proteger rotas com autenticação JWT.
- Aplicar verificações de permissão e autenticação.
- Tratar requisições de forma centralizada.

## 👀 Observabilidade com Laravel Telescope

Para facilitar a inspeção e depuração da aplicação em tempo real, foi integrada a ferramenta **Laravel Telescope**, que permite:

- Monitorar requisições HTTP.
- Visualizar logs de exceções e erros.
- Acompanhar queries no banco de dados.
- Observar eventos, jobs, e-mails e muito mais.

## 🧪 Testes

A aplicação conta com **testes unitários**, garantindo que a lógica das camadas de serviço e regras de negócio funcionem corretamente, permitindo segurança nas alterações e refatorações futuras.

Os testes são organizados na pasta `tests/Unit` e podem ser executados com:

```bash
php artisan test
```

## 📚 Documentação da API

Toda a API está documentada utilizando Swagger (OpenAPI), permitindo que desenvolvedores entendam e testem facilmente os endpoints.
A documentação pode ser acessada através da rota:

```bash
http://localhost:8000/api/documentation
```
