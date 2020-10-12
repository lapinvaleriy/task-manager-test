docker-compose down;
docker-compose build --no-cache ;
docker-compose up -d;

docker exec php /bin/bash -c "cd /usr/src/app && composer install"
#ADD MIGRATION THERE



#docker exec -it php /bin/bash -c "php -d memory_limit=4g /usr/local/bin/composer require symfony/messenger"
#docker exec -it toplyvo_transporter_php php bin/console doctrine:database:create --if-not-exists;
