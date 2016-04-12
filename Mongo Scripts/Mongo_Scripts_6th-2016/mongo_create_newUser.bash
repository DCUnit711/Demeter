#!/bin/bash -x



EXPECTED_ARGS=3
E_BADARGS=65

# dabases = collections  - collections(user dbs) are inside the test db
# users are stored inside the admin db --> system.users



CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
PASSWORD="'$3'"




if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME, USER_PASSWORD, DATABASE_NAME"
  exit $E_BADARGS
fi


#creare user
docker exec -it $CONTAINER_INSTANCE_id mongo --eval  "db.createUser({ user: $USER, pwd: $PASSWORD, roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"





