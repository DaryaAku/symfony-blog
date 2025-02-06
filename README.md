# Symfony Docker
Project Description

Symfony Blog API is a RESTful API built with Symfony that provides functionality for managing blog posts and comments. The API supports creating, editing, deleting, and viewing posts, as well as handling comments.

Technology Stack

Backend: Symfony (PHP)

Database: PostgreSQL

ORM: Doctrine

Authentication: JWT 

Templating: Twig 

Containerization: Docker 

Test: Postman
Build fresh images: Run docker compose build --no-cache  
To set up and start a fresh Symfony project: un docker compose up --pull always -d --wait 
 Installation and Setup
 Clone the Repository:git clone <REPOSITORY_URL>
                      cd <PROJECT_NAME>
  Install Dependencies: composer install
  Configure Environment Variables: Create a .env.local file and specify database connection parameters:
  DATABASE_URL="postgresql://user:password@127.0.0.1:5432/db_name"
  JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
  JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
  JWT_PASSPHRASE=your_passphrase  
  Set Up the Database:php bin/console doctrine:database:create
                       php bin/console doctrine:migrations:migrate    
  Generate JWT Keys: php bin/console lexik:jwt:generate-keypair

  API Endpoints
  Posts:
  GET /posts – Retrieve all posts 
  GET /posts/{id} – Retrieve a post by ID
  POST /posts – Create a post
  PUT /posts/{id} – Update a post
  DELETE /posts/{id} – Delete a post    

  Comments:
  GET /posts/{id}/comments – Retrieve comments for a post
  POST /posts/{id}/comments – Add a comment
  DELETE /comments/{id} – Delete a comment

  ClassNotFoundError" for TwigBundle
  Error: Attempted to load class "TwigBundle" from namespace "Symfony\Bundle\TwigBundle".  
  Solution: composer require symfony/twig-bundle  




A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Production, development and CI ready
* Just 1 service by default
* Blazing-fast performance thanks to [the worker mode of FrankenPHP](https://github.com/dunglas/frankenphp/blob/main/docs/worker.md) (automatically enabled in prod mode)
* [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
* Automatic HTTPS (in dev and prod)
* HTTP/3 and [Early Hints](https://symfony.com/blog/new-in-symfony-6-3-early-hints) support
* Real-time messaging thanks to a built-in [Mercure hub](https://symfony.com/doc/current/mercure.html)
* [Vulcain](https://vulcain.rocks) support
* Native [XDebug](docs/xdebug.md) integration
* Super-readable configuration

**Enjoy!**

## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
