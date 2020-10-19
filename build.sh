docker-compose down;
docker-compose build --no-cache ;
docker-compose up -d;

docker exec php /bin/bash -c "cd /usr/src/app && composer install"
docker exec php /bin/bash -c "php bin/console doctrine:migration:migrate"
docker exec php /bin/bash -c "php bin/console doctrine:fixtures:load -n --env=dev"
