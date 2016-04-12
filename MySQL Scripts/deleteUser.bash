#!/bin/bash
  
EXPECTED_ARGS=3
E_BADARGS=65

CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
SOURCE="'%'"
USER="'$3'"
  
  
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 userName"
  exit $E_BADARGS
fi

#DROP/DELETE USER

docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "DROP USER ${USER}@${SOURCE};"

