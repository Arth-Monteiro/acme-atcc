<!-- https://medium.com/@vhsilva.ap/configurando-laravel-6-nginx-e-postgresql-com-docker-9ad29c53d5 -->

sudo chmod o+w ./storage/ -R

docker-compose exec web-laravel sh

[comment]: <> (php artisan migrate)

 docker-compose exec web-laravel php artisan migrate 

composer update

[comment]: <> (https://laravel.com/docs/9.x/structure#introduction)

[comment]: <> (composer require laravel/ui)

[comment]: <> (php artisan ui vue --auth)

[comment]: <> (php artisan migrate)

[comment]: <> (npm install)

[comment]: <> (npm run dev)

# Files to Develop
authentication.php
dbcontroller.php
edit.php
form_associate.php
form_pessoas.php
form_tag.php
painel.php
pessoas.php
query.php
tag.php

~header.php~
~footer.php~
index.php - AboutUs
login.php -- mas necessario editar um pouco


