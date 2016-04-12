#Docker-MongoDB:

Docker-MongoDB Image scripts: This scripts will use the information sent by the end-user from the front end in order
to create a MongoDB Image and perform all the required operations such as create a docker container for the specific type of DB, create users with specific privileges, set and reset passwords, delete users, delete databases.

##MongoDB_Create_Container_DB_USER.bash:

#####!/bin/bash -x
```
EXPECTED_ARGS=4
E_BADARGS=65
```

##### Databases = collections - collections (user dbs) are inside the test db users are stored inside the admin db --> system. Users

```
CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
PASSWORD="'$3'"
DB="$4"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME, USER_PASSWORD, DATABASE_NAME"
  exit $E_BADARGS
fi
```

##### Creates a new Mongo DB Docker Container
```
docker run --name $CONTAINER_INSTANCE_id -d mongo
sleep 10s
```

##### Creates new Mongo Db user for specific container, sets user password and role
```
docker exec -it $CONTAINER_INSTANCE_id mongo --eval  "db.createUser({ user: $USER, pwd: $PASSWORD,
roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"
```

##### Creates a new Collection in the specified Docker container and inside test db
```
docker exec -it $CONTAINER_INSTANCE_id mongo --eval "db.createCollection('$DB')"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

##File name: Mongo_Create_newUSer.bash:

#####!/bin/bash -x
```
EXPECTED_ARGS=3
E_BADARGS=65
```

##### databases = collections; and collections (user dbs) are inside the test db. Users are stored inside the admin db --> system. Users
```
CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
PASSWORD="'$3'"
```

##### print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME, USER_PASSWORD, DATABASE_NAME"
  exit $E_BADARGS
fi
```

##### Creates new mongo user and sets password and user role
```
docker exec -it $CONTAINER_INSTANCE_id mongo --eval  "db.createUser({ user: $USER, pwd: $PASSWORD,
roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

##File name: Mongo_changeUserPassword.bash:

#####!/bin/bash -x
```
EXPECTED_ARGS=3
E_BADARGS=65
```

##### Databases = collections; and collections (user dbs) are inside the test db. Users are stored inside the admin db --> system.users
```
CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
PASSWORD="'$3'"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME, USER_NAME, NEW_PASS"
  exit $E_BADARGS
fi
```

#####Change user password
```
docker exec -it $CONTAINER_INSTANCE_id mongo --eval "db.updateUser($USER,  { pwd: $PASSWORD})"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

##File name: delete_mongodb_user:

#####!/bin/bash -x
```
EXPECTED_ARGS=2
E_BADARGS=65
```

##### databases = collections – and collections (user dbs) are inside the test db. Users are stored inside the admin db --> system.users
```
CONTAINER_INSTANCE_id="$1"
#ROOT_PASSWORD=""
USER="'$2'"
```

#####Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE,USER_NAME"
  exit $E_BADARGS
fi
```

##### Removes mongo db user
```
docker exec -it $CONTAINER_INSTANCE_id mongo --eval "db.dropUser($USER)"
```
