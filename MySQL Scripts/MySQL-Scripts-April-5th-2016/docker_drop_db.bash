#!/bin/bash -x
  
EXPECTED_ARGS=3
E_BADARGS=65

CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
DATABASE="$3"


#Delete database

docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "DROP DATABASE IF EXISTS $DATABASE;"
