# Aplicació PHP amb Memcached

Aplicació senzilla en PHP per gestionar una base de dades de cotxes (marca, model, combustible) utilitzant **Memcached** com a sistema d'emmagatzematge en memòria.

## Contingut

- `Dockerfile` – Imatge basada en PHP 8.2 amb Apache i extensió de Memcached activada.
- `index.php` – Interfície web per afegir, llistar i eliminar cotxes.
- `php.ini` – Configuració de PHP per mostrar errors.
- `docker-compose.yml` – Defineix dos serveis: `web` (PHP + Apache) i `memcached`.

## Posada en marxa

### Requisits

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Instruccions

   ```bash
   # En PWD
   akp add git
   git clone https://github.com/iesbillenguatges/memcached-php.git
   cd memcached-php
   docker-compose up --build
   ```
I ja està, a provar la app en localhost:8080
