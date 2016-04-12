#!/bin/bash -x



EXPECTED_ARGS=4
E_BADARGS=65

# dabases = collections  - collections(user dbs) are inside the test db
# users are stored inside the admin db --> system.users



CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
PASSWORD="'$3'"
DB="$4"



if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME, USER_PASSWORD, DATABASE_NAME"
  exit $E_BADARGS
fi

#create new mongo instance

docker run --name $CONTAINER_INSTANCE_id -d mongo

sleep 10s

#creare user
docker exec -it $CONTAINER_INSTANCE_id mongo --eval  "db.createUser({ user: $USER, pwd: $PASSWORD, roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"


#creates collection inside test db

docker exec -it $CONTAINER_INSTANCE_id mongo --eval "db.createCollection('$DB')"





