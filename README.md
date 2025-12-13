# Reserva de Hotel API

**API RESTful completa para sistema de reserva de hotel**  
Desenvolvida com Laravel 12 + Doctrine ORM (sem Eloquent) + Docker (Nginx + PHP-FPM + MySQL)

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-blue.svg)](https://php.net)
[![Doctrine](https://img.shields.io/badge/Doctrine-ORM-green.svg)](https://www.doctrine-project.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://www.mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)](https://www.docker.com)

## 🚀 Funcionalidades

- CRUD completo: Quartos, Hóspedes, Temporadas/feriados e Reservas
- Cálculo automático de preço total com **Strategy Pattern** (alta/baixa temporada, feriados)
- Verificação de disponibilidade: não permite reserva em quarto ocupado
- **Policy Pattern** Política de cancelamento: até 24h antes do check-in
- **Repository Pattern** Consultar disponibilidade de quartos.
- Seeders com dados realistas (Natal, Réveillon, Black Friday)
- Dockerizado (Nginx + PHP-FPM + MySQL)


## 🛠️ Tecnologias e Padrões

- Laravel 12
- Doctrine ORM 3.1 (em vez de Eloquent)
- Strategy Pattern para cálculo de preço
- Repository Pattern com métodos customizados
- SOLID aplicado
- Docker com Nginx, PHP 8.3-FPM e MySQL 8.0

## 📦 Como Rodar (Docker)

### 1. Clone o repositório

git clone https://github.com/cliffbaptista/Reserva-de-Hotel.git
cd Reserva-de-Hotel

### 2. Suba a aplicação
- Tornar o arquivo start.sh em executavel no terminal

chmod +x start.sh

### 2.1
- Iniciar aplicação pelo terminal.

./start.sh

### 3. Testar API pelo browser

http://localhost:8000/api/reservations

### 4. Rotas da API.

| Método       | Endpoint                             | Nome da Rota            | Controller / Action                          |
|--------------|--------------------------------------|-------------------------|----------------------------------------------|
| GET \| HEAD  | api/guests                           | guests.index            | Api\GuestController@index                   |
| POST         | api/guests                           | guests.store            | Api\GuestController@store                   |
| GET \| HEAD  | api/guests/{guest}                   | guests.show             | Api\GuestController@show                    |
| PUT \| PATCH | api/guests/{guest}                   | guests.update           | Api\GuestController@update                  |
| DELETE       | api/guests/{guest}                   | guests.destroy          | Api\GuestController@destroy                 |
| GET \| HEAD  | api/reservations                     | reservations.index      | Api\ReservationController@index             |
| POST         | api/reservations                     | reservations.store      | Api\ReservationController@store             |
| POST         | api/reservations/{id}/cancel         | —                       | Api\ReservationController@cancel            |
| GET \| HEAD  | api/reservations/{reservation}       | reservations.show       | Api\ReservationController@show              |
| PUT \| PATCH | api/reservations/{reservation}       | reservations.update     | Api\ReservationController@update            |
| DELETE       | api/reservations/{reservation}       | reservations.destroy    | Api\ReservationController@destroy           |
| GET \| HEAD  | api/rooms                            | rooms.index             | Api\RoomController@index                    |
| POST         | api/rooms                            | rooms.store             | Api\RoomController@store                    |
| GET \| HEAD  | api/rooms/{room}                     | rooms.show              | Api\RoomController@show                     |
| PUT \| PATCH | api/rooms/{room}                     | rooms.update            | Api\RoomController@update                   |
| DELETE       | api/rooms/{room}                     | rooms.destroy           | Api\RoomController@destroy                  |
| GET \| HEAD  | api/seasons                          | seasons.index           | Api\SeasonController@index                  |
| POST         | api/seasons                          | seasons.store           | Api\SeasonController@store                  |
| GET \| HEAD  | api/seasons/{season}                 | seasons.show            | Api\SeasonController@show                   |
| PUT \| PATCH | api/seasons/{season}                 | seasons.update           | Api\SeasonController@update                 |
| DELETE       | api/seasons/{season}                 | seasons.destroy         | Api\SeasonController@destroy                |


## Estrutura da arquiteruta de Software

##### FLUXO DETALHADO DE UMA REQUISIÇÃO (EXEMPLO: POST /api/reservations)

1. Cliente envia JSON → POST http://localhost:8000/api/reservations
2. Nginx recebe na porta 8000 e encaminha para PHP-FPM
3. Laravel Routing → routes/api.php → ReservationController@store
4. Controller:
* Valida dados com Request::validate()
* Busca Room e Guest via EntityManager->find()
* Verifica conflito (QueryBuilder no Repository)
* Chama PriceCalculationService->calculateTotalPrice()

5. PriceCalculationService:
* Injeta EntityManager
* Usa SeasonRepository->findApplicableSeasons() por data
* Aplica Strategy Pattern (Holiday > High > Low > Default)
* Calcula preço diário × número de noites

6. Cria Reservation Entity → setters
7. Persist → EntityManager->persist() + flush()
8. Retorna JSON → $reservation->toArray() (com room e guest aninhados)

##### PADRÕES DE DESIGN APLICADOS
1. Utilizado SOLID
2. Strategy Pattern: Cálculo de preço (HolidayStrategy, HighSeasonStrategy, etc)
3. Repository Pattern: Abstração do Doctrine (RoomRepository, SeasonRepository com métodos customizados)


##### INFRAESTRUTURA
Nginx + PHP + Laravel + MySQL

##### FLUXO ARQUITETURAL.

graph TD
    A[Cliente] -->|HTTP JSON| B(Nginx)
    B --> C[Laravel]
    C --> D[Controllers]
    D --> E[PriceCalculationService<br/>+ Strategy Pattern]
    D --> F[EntityManager]
    F --> G[Repositories]
    G --> H[Entities]
    H --> I[MySQL]
    E --> F

### Envolvidos no Projeto
1. CLiff Baptista 
2. Francisco Davi
3. Daniel Carmo