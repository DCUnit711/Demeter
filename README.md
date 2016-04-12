This system was developed by: David Christofferson, Wesley Haws, Robert Jackson, Andres Martenson, and Mario Valencia.

The purpose of this system is to remove the burden of database upkeep from end users. It is designed so the system is hosted by those in your organization that are database experts. They retain root access to databases and are responsible for keeping databases backed up and running correctly. Users of the system access it through the Web Interface. From there they can perform CRUD operations on both databases that belong to them and database users. The system also provides for easy password resetting, should it be needed. This ensures end users are never locked out of their database.

The system works with remote or local database VMs. It is designed to also work with Docker containers or databases sitting directly on VMs.

Currently this repository contains all of the information that you would need to deploy this onto your middleware machine. This machine will be in charge of serving requests to its web interface and storing those request in it's MySQL database. It also has a communication channel setup to communicate with VMs (Where the actual databases will be stored), which is installed locally on each database VM. The VM code makes use of SALT, ZMQ, and Docker when needed.

##Documentation Paths
[Front End Code and Documentation](/laravel/public)

[Middleware Controllers](/laravel/app/Http/Controllers)

[Routing For Controllers](/laravel/app/Http/routes.php)

[Middleware Models](/laravel/app/)

[Middleware Listener](/laravel/app/Console/Commands/redisListener.php)

[Middleware Queue Handler](/laravel/app/Jobs/handleVmRequest.php)

[Simple Logger](/laravel/app/Http/Middleware/RequestLogger.php)

[Error Page](/laravel/resources/views/errors/500.blade.php)
