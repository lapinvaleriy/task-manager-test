docker-compose down;
docker-compose build --no-cache ;
docker-compose up -d;

docker exec php /bin/bash -c "cd /usr/src/app && composer install"

#docker exec -it php /bin/bash -c "php -d memory_limit=4g /usr/local/bin/composer require annotations"
#docker exec -it toplyvo_transporter_php php bin/console doctrine:database:create --if-not-exists;
