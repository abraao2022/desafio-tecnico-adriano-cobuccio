# Instruções para rodar o projeto
1. Suba os containers com o Docker:

```bash
docker-compose up --build
```

2. Acesse o container da aplicação:
```bash
docker-compose exec app bash
```

3. Execute as migrations e os seeders:
```bash
php artisan migrate --seed
```
