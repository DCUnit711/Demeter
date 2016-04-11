#!/bin/bash
  
EXPECTED_ARGS=5
E_BADARGS=65


# this file creates docker container then waits 1 minute and creates DB and user, set user password and privilages


CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
# database name doesnt need single quotes
DATABASE="$3"
SOURCE="'%'"
USER="'$4'"
PASSWORD="'$5'"



 
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE, ROOT_PASSWORD, DATABASE_NAME, USER_NAME, USER_PASSWORD"
  exit $E_BADARGS
fi

docker run --name $CONTAINER_INSTANCE_id -e MYSQL_ROOT_PASSWORD=$ROOT_PASSWORD -d mysql:5.7.11

sleep 1m

docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "CREATE DATABASE $DATABASE;"

#creates user with no privileges 
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT USAGE ON *.* TO ${USER}@${SOURCE} IDENTIFIED BY ${PASSWORD};"

# grants privileges to new user on specific database
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT CREATE, SELECT, UPDATE, INSERT, DELETE, DROP ON ${DATABASE}.* TO ${USER}@${SOURCE};"



