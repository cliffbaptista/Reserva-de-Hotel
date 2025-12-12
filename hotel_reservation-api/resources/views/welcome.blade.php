<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Hotel Reserva</title>
</head>
<body>
    <h1>Projeto com as rotas de API</h1>

    <p>
        Por favor consultar route list para visualizar rotas
        php artisan route:list --path=api 
    </p>

    <hr>

    <p>
        GET|HEAD        api/guests ........................................................................................ guests.index › Api\GuestController@index
  POST            api/guests ........................................................................................ guests.store › Api\GuestController@store
  GET|HEAD        api/guests/{guest} .................................................................................. guests.show › Api\GuestController@show
  PUT|PATCH       api/guests/{guest} .............................................................................. guests.update › Api\GuestController@update
  DELETE          api/guests/{guest} ............................................................................ guests.destroy › Api\GuestController@destroy
  GET|HEAD        api/reservations ...................................................................... reservations.index › Api\ReservationController@index
  POST            api/reservations ...................................................................... reservations.store › Api\ReservationController@store
  POST            api/reservations/{id}/cancel .............................................................................. Api\ReservationController@cancel
  GET|HEAD        api/reservations/{reservation} .......................................................... reservations.show › Api\ReservationController@show
  PUT|PATCH       api/reservations/{reservation} ...................................................... reservations.update › Api\ReservationController@update
  DELETE          api/reservations/{reservation} .................................................... reservations.destroy › Api\ReservationController@destroy
  GET|HEAD        api/rooms ........................................................................................... rooms.index › Api\RoomController@index
  POST            api/rooms ........................................................................................... rooms.store › Api\RoomController@store
  GET|HEAD        api/rooms/{room} ...................................................................................... rooms.show › Api\RoomController@show
  PUT|PATCH       api/rooms/{room} .................................................................................. rooms.update › Api\RoomController@update
  DELETE          api/rooms/{room} ................................................................................ rooms.destroy › Api\RoomController@destroy
  GET|HEAD        api/seasons ..................................................................................... seasons.index › Api\SeasonController@index  
  POST            api/seasons ..................................................................................... seasons.store › Api\SeasonController@store  
  GET|HEAD        api/seasons/{season} .............................................................................. seasons.show › Api\SeasonController@show
  PUT|PATCH       api/seasons/{season} .......................................................................... seasons.update › Api\SeasonController@update
  DELETE          api/seasons/{season} ........................................................................ seasons.destroy › Api\SeasonController@destroy  
    
    </p>
</body>
</html>