<h1 align="center">Интернет-магазин</h1>
  <p> Этот проект реализован с помощью PHP 8.1 , фреймворка Laravel, PostgreSql, Php-fpm, Nginx и RabbitMq.
 <h2>Описание:</h2>
  <p>В проекте реализована регистрация, аутентификация, отображение товаров и их категорий, добавление и удаление товаров из корзины через Ajax запросы. После регистрации пользователя отправляется письмо на почту для его подтверждения.</p>

<h2> Чтобы запустить проект, выполните следующие шаги: </h2>
<ul>

- Создайте контейнеры: <b>docker-compose build</b>

- Запустите их: <b>docker-compose up -d</b>

- Проверьте созданные docker-контейнеры: <b>docker-compose ps -a</b>

- Зайдите в контейнер php-fpm: <b>docker-compose exec php-fpm bash</b>

- Установите необходимые библиотеки: <b>composer install </b>

- Создать таблицы users, categories, products, carts, cart_products и jobs: <b>php artisan migrate</b>

- Запустить "Consumer": <b>php artisan queue:work</b>

Готово
</ul>

