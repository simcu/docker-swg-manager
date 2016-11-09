#!/bin/sh
echo "APP_ENV=prod" > /home/.env
echo "APP_DEBUG=false" >> /home/.env
echo "APP_KEY=" >> /home/.env
echo "DB_HOST=$DB_HOST" >> /home/.env
echo "DB_PORT=$DB_PORT" >> /home/.env
echo "DB_DATABASE=$DB_DATABASE" >> /home/.env
echo "DB_USERNAME=$DB_USERNAME" >> /home/.env
echo "DB_PASSWORD=$DB_PASSWORD" >> /home/.env
echo "REDIS_HOST=$REDIS_HOST" >> /home/.env
echo "REDIS_PORT=$REDIS_PORT" >> /home/.env

php /home/artisan key:generate
chmod -R 777 /home