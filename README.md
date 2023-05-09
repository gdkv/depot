# Приложение Депо

Состоит из трех частей

- Репозиторий (go + symfony)
- База клиентов
- Трекер и учет проектов

### Запуск
```bash
cp .env.test .env
composer install
bin/console doctrine:schema:update --force
bin/console --no-interaction assets:install
bin/console --no-interaction cache:clear
npm install
npm run build
```

### Тесты
```bash 
bin/phpunit
``` 