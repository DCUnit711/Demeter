# Demeter
Database as a Service

This is a system that was developed by: Wesley Haws, David Christofferson, Mario Valencia, Andres Martenson, and Robert Jackson.

This is a service that will provide a web interface for database managers to easily go in and create a database with a few clicks. The middleware will receive this managers information he input and send that information further on to VMs where they will make the database. No intrecate knowledge of database creation needed, this takes care of it all! This also supports database management such as User and Manager creation and deletion, changing DB name, size, organization, description, etc. This is a simple all in one package that is meant to be deployed on a secure server. It currently uses a CAS system to authenticate with it but can be easily changed to fit the users needs.

Currently this repository contains all of the information that you would need to deploy this onto your middleware machine. This machine will be in charge of serving requests to its web interface and storing those request in it's MySQL database. It also has a communication channel setup to communicate with VMs (Where the actual databases will be stored) however, the code that will be placed on each of those VMs is not currently stored here. The VM code will make use of SALT, ZMQ, and Docker.

##Folder Paths
Front End Code: ./laravel/public/demeter

Middleware Controllers: ./laravel/app/Http/Controllers

Routing For Controllers: ./laravel/app/Http/routes.php

Middleware Listener: ./laravel/app/Console/Commands/redisListener.php

Middleware Queue Handler: ./laravel/app/Jobs/handleVmRequest.php
