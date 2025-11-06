# Pobierz oficjalny obraz PHP z Apache
FROM php:8.0-apache

# Zainstaluj rozszerzenie PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Skopiuj pliki aplikacji do katalogu Apache
COPY . /var/www/html/

# Otwórz port 80 (serwer HTTP)
EXPOSE 80
