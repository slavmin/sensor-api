# Sensor API

Simple API for receiving and providing data.

## Installation

1. Clone the repository.
2. Run `docker-compose up -d` to start the containers.
3. Run `docker-compose exec -it php-fpm composer install` to install dependencies.
4. Run `docker-compose exec -it php-fpm php artisan migrate` to run migrations.

## API Endpoints

- **POST /api**: Save sensor data.
- **GET /api/history**: Get historical data for a sensor.

## Usage

### Save Sensor Data

Send a POST request to `/api?sensor=1&T=20`

### Get Sensor History Data

Send a GET request to `/api/history?sensor=1&start_date=2025-03-01&end_date=2025-03-31`

Example:

```bash
POST /api?sensor=1&T=20