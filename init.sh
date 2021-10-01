#!/bin/bash
composer i
docker-compose build app
docker-compose up -d
docker-compose exec app composer install
#Need if sql dump doesn't import
#cat docker-compose/mysql/init_db.sql | docker exec -i kitchen-db /usr/bin/mysql -u kitchen_user --password=password kitchen
