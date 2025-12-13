#!/bin/bash

echo ""
echo "=============================================="
echo "   INICIANDO HOTEL RESERVATION API [DOCKER]"
echo "=============================================="
echo ""


docker-compose down -v
docker volume prune -f

echo ""
echo "Subindo containers..."
docker-compose up -d --build

echo ""

echo "Aguardando estabilização do MySQL [30s...]"
sleep 30

echo ""
echo "Forçando criação do arquivo .env CORRETO..."

docker exec -it --user root hotel-app bash -c "
    mkdir -p /var/www/vendor /var/www/.composer /var/www/bootstrap/cache && \
    
 
    echo 'APP_NAME=HotelAPI' > /var/www/.env && \
    echo 'APP_ENV=local' >> /var/www/.env && \
    echo 'APP_KEY=' >> /var/www/.env && \
    echo 'APP_DEBUG=true' >> /var/www/.env && \
    echo 'APP_URL=http://localhost:8000' >> /var/www/.env && \
    echo '' >> /var/www/.env && \
    echo 'DB_CONNECTION=mysql' >> /var/www/.env && \
    echo 'DB_HOST=mysql' >> /var/www/.env && \
    echo 'DB_PORT=3306' >> /var/www/.env && \
    echo 'DB_DATABASE=hotel_db' >> /var/www/.env && \
    echo 'DB_USERNAME=root' >> /var/www/.env && \
    echo 'DB_PASSWORD=root' >> /var/www/.env && \
    
  
    rm -rf /var/www/database/migrations/* && \
    chmod -R 777 /var/www/storage /var/www/vendor /var/www/.composer /var/www/bootstrap/cache /var/www/.env /var/www/database/migrations
"

echo ""
echo "Instalando dependências e rodando migrações..."


docker exec -it hotel-app bash -c "
    composer config --global process-timeout 2000 && \
    composer config --global disable-tls true && \
    composer config --global secure-http false && \
    composer install --no-scripts --no-interaction --ignore-platform-reqs && \
    php artisan key:generate && \
    php artisan config:clear && \
    php artisan doctrine:migrations:diff && \
    php artisan doctrine:migrations:migrate --no-interaction && \
    php artisan doctrine:generate:proxies && \
    php artisan db:seed && \
    echo '--------------------------------------------------' && \
    echo 'TUDO PRONTO! Acesse: http://localhost:8000/api/reservations'
"

echo ""
echo "=============================================="
echo "   FIM DO SCRIPT"
echo "=============================================="

read -p "Pressione [Enter] para sair..."