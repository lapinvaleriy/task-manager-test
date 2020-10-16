docker-compose down;
docker-compose build --no-cache ;
docker-compose up -d;

docker exec php /bin/bash -c "cd /usr/src/app && composer install"
docker exec php /bin/bash -c "php bin/console doctrine:migration:migrate"
docker exec php /bin/bash -c "php bin/console doctrine:fixtures:load -n --env=dev"

#docker exec -it php /bin/bash -c "php -d memory_limit=4g /usr/local/bin/composer require doctrine/doctrine-fixtures-bundle --dev"
#docker exec -it toplyvo_transporter_php php bin/console doctrine:database:create --if-not-exists;
