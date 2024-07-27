# Banking App

[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

## Tech Pre-Rquirements
- [PHP] - 8.2
- [Laravel] - 11.17.0
- [NodeJs] - Latest LTS or 20
- [Vite] - 5.3.4

Banking App itself is open source with a [public repository][dill]
on GitHub.

## Installation

Banking App requires [Node.js](https://nodejs.org/) v20+ to run.

Install the dependencies and devDependencies and start the server.

```sh
cd banking-app
npm install && npm run dev // This will install all dependency and also runs Vite
```
Once Vite has been started move to another terminal and run below given command.
```sh
composer install
```

As soon as all the dependencies are installed run command to add database migrations.

```sh
php artisan migrate
```

At last we are ready to start

```sh
php artisan serve
```
