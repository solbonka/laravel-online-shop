<h1 align="center">Интернет-магазин</h1>
  <p> Этот проект реализован с помощью PHP 8.1 , фреймворка Laravel, PostgreSql, Php-fpm, Nginx и RabbitMq.
 <h2>Описание:</h2>
  <p>В проекте реализована регистрация, аутентификация, добавление и удаление товаров из корзины через Ajax запросы. После регистрации пользователя отправляется письмо на почту для его подтверждения.</p>

<h2> Чтобы запустить проект, выполните следующие шаги: </h2>
<ul>

- Создайте контейнеры: docker-compose build

- Запустите их: docker-compose up -d

- Проверьте созданные docker-контейнеры: docker-compose ps -a

- Зайдите в контейнер php-fpm: docker-compose exec php-fpm bash

- создать таблицы users, categories, products, carts, cart_products и jobs: php artisan migrate

- запустить обработчик событий: php artisan queue:work

Готово
</ul>

