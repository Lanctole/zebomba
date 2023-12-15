Клонируем репозиторий.
По шаблону .env.example задаём своё окружение. SECRET_KEY - секретный ключ приложения.
Внутри есть docker-compose.yml
docker-compose up -d --build
docker exec -it zebomba_app bash 
composer install
php artisan key:generate
php artisan migrate

Время: ~8 часов
