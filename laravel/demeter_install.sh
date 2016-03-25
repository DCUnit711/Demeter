#4.) run "php artisan migrate"
#5.)run "php artisan serve" which will serve it on port 8000 (we can add a script that would serve it on another port, etc.)

. demeter.config #load config

if [ $DB_CONNECTION != "mysql" -a $DB_CONNECTION != "oracle" -a $DB_CONNECTION != "mongo" ]
then
	echo "CONFIG ERROR: DB_CONNECTION must be mysql, oracle, or mongo"
	exit
fi

if [ $DB_CONNECTION = "mysql" ]
then
	if  ! mysql -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASSWORD -e ";"
	then
		echo "CONFIG ERROR: DB_USER and DB_PASSWORD cannot log in"
		exit
	else
		RESULT=$(mysql -u $DB_USER -p$DB_PASSWORD -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$DB_DATABASE'" | grep -o $DB_DATABASE)
		echo $RESULT
		if ! [ "$RESULT" == "$DB_DATABASE" ];
		then
			echo "CONFIG ERROR: DB_DATABASE not found"
		fi
	fi
fi

if [ $DB_CONNECTION = "mongo" ]
then
	if mongo -u $DB_USER -p$DB_PASSWORD -e ";"
	then
		echo "CONFIG ERROR: DB_USER and DB_PASSWORD cannot log in"
		exit
	else
		mongo --eval "db.stats()"  # do a simple harmless command of some sort

		RESULT=$?   # returns 0 if mongo eval succeeds

		if [ $RESULT -ne 0 ]; then
			echo "CONFIG ERROR: DB_DATABASE not found"
			exit
		fi
	fi
fi

if [ $DB_CONNECTION = "oracle" ]
then
	echo "exit" | sqlplus -L $DB_USER/$DB_PASSWORD@DB_DATABASE | grep Connected > /dev/null
	if ![ $? -eq 0 ] 
	then
		echo "CONFIG ERROR: DB_USER and DB_PASSWORD cannot log into DB_DATABASE"
		exit
	fi
fi

sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/g" config/database.php
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/g" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/g" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/g" .env

#install composer packages
composer update
#generate keys
php artisan key:generate
php artisan config:clear
#create Middleware
php artisan migrate
#start the Middleware Server
nohup php artisan serve --port=$MIDDLEWARE_PORT > /dev/null 2>&1 &
#start queue listener
nohup php artisan queue:listen > /dev/null 2>&1 &
#start redis listener
nohup php artisan redis:subscribe > /dev/null 2>&1 &
