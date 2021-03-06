# microblog
A simple markdown php command line blog system for enthusiastic and nerd people ( usually developers )

[![Build Status](https://travis-ci.org/klederson/microblog.svg?branch=master)](https://travis-ci.org/klederson/microblog)
[![codecov.io](https://codecov.io/github/klederson/microblog/coverage.svg?branch=master)](https://codecov.io/github/klederson/microblog?branch=master)

<!--
[![Latest Stable Version](https://poser.pugx.org/klederson/microblog/v/stable)](https://packagist.org/packages/klederson/microblog)
[![Total Downloads](https://poser.pugx.org/klederson/microblog/downloads)](https://packagist.org/packages/klederson/microblog)
[![License](https://poser.pugx.org/klederson/microblog/license)](https://packagist.org/packages/klederson/microblog)
[![Monthly Downloads](https://poser.pugx.org/klederson/microblog/d/monthly)](https://packagist.org/packages/klederson/microblog)
-->

# Quick Installation

> You must have installed `npdejs` with `npm`, `gulp` and `bower`

```bash
# development mode
./build.sh dev

# or in production
./build.sh

# If you want to reinitialize project required repositories and asstes run next command:

# development
./build.sh dev -r

# production
./buidl.sh -r
```

> Run `php -S localhost:8000 -t web` to run internal php server and then go to [http://localhost:8000](http://localhost:8000)

# Manual Installation

```bash
# copy .env file
cp .env.dist .env

# install aditional packages
composer install

# install symfony assets
php app/console assets:install

# install nodejs dependencies
npm install
```

> If you want to add bundle specific assets, create directory `Resources/public` in your bundle and add there `css`, `images`, `js` directories, etc.

Debug settings are enabled by default. For production environment update `.env` file as follows:

```bash
SYMFONY_ENV = prod
SYMFONY_DEBUG = 0
```

Alternatively you may use our [Symfony Vagrant VM](https://github.com/kisphp/symfony-vagrant) to run the blog on local environment.

# commands

```bash
# display registered routes
php app/console debug:router
```