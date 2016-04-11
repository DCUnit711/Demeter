#!/bin/bash -x


# 1 container-id, 2 rootPassword, 3 user 4 password
  


CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
SOURCE="'%'"
USER="'$3'"
PASSWORD="'$4'"



#update user password

docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "ALTER USER ${USER}@${SOURCE} IDENTIFIED WITH mysql_native_password BY  ${PASSWORD};"
