@echo off
echo.
echo ==============================================
echo   INICIANDO HOTEL RESERVATION API (DOCKER)
echo ==============================================
echo.

docker-compose down -v
docker volume prune -f

echo.
echo Subindo containers...
docker-compose up -d --build

echo.
echo Aguardando MySQL (60s)...
timeout /t 60 >nul

echo.
echo Executando comandos...
docker exec -it hotel-app bash -c "composer install --no-scripts --no-interaction && php artisan key:generate && rm -rf database/migrations/* && php artisan doctrine:migrations:diff && php artisan doctrine:migrations:migrate --no-interaction && php artisan doctrine:generate:proxies && php artisan db:seed && echo TUDO PRONTO! Acesse: http://localhost:8000/api/reservations"

echo.
echo ==============================================
echo   SUCESSO TOTAL!
echo ==============================================
pause