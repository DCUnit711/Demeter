#Docker-MySQL:

Docker-MySQL Image scripts: This scripts will use the information sent by the end-user from the front end in order
to create a new MySQL Image and perform all the required operations such as create a docker container for the specific type of DB, create users with specific privileges, set and reset passwords, delete users, delete databases.

##File name: MySQL_Create_Container_DB_USER.bash:
!/bin/bash
```
EXPECTED_ARGS=5
E_BADARGS=65
```

##### This file will create a new Docker container then waits 1 minute and creates DB and User, set User password and privileges
```
CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
```

##### database name doesn’t need single quotes around
```
DATABASE="$3"
SOURCE="'%'"
USER="'$4'"
PASSWORD="'$5'"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE, ROOT_PASSWORD, DATABASE_NAME, USER_NAME, USER_PASSWORD"
  exit $E_BADARGS
fi
```

##### Creates a new MySQL Docker Container
```
docker run --name $CONTAINER_INSTANCE_id -e MYSQL_ROOT_PASSWORD=$ROOT_PASSWORD -d mysql:5.7.11

sleep 1m
```

##### Creates a new DB in the specified Docker container
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "CREATE DATABASE $DATABASE;"
```


##### Creates user with no privileges
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT USAGE ON *.* TO
${USER}@${SOURCE} IDENTIFIED BY ${PASSWORD};"
```

##### Grants privileges to new user on specific database
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT CREATE, SELECT, UPDATE,
INSERT, DELETE, DROP ON ${DATABASE}.* TO ${USER}@${SOURCE};"
```

---------------------------------------------------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------------------------------------------------

#### The following script is different from the previous one in the sense that it is used to create a new DB user but not a new Docker container

#####File name: MySQL_Create_new_USER.bash:

!/bin/bash
```
EXPECTED_ARGS=5
E_BADARGS=65
```
##### This file creates a new DB if doesn’t exist, it also creates a new User and sets his password and privileges
```
CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
# database name doesn’t need single quotes
DATABASE="$3"
SOURCE="'%'"
USER="'$4'"
PASSWORD="'$5'"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters.
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE, ROOT_PASSWORD, DATABASE_NAME, USER_NAME, USER_PASSWORD"
  exit $E_BADARGS
fi
```

##### Creates a new if doesn’t exist  in the specified Docker container
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $DATABASE;"
```

#####Creates user with no privileges
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT USAGE ON *.*
TO ${USER}@${SOURCE} IDENTIFIED BY ${PASSWORD};"
```

#####Grants privileges to new user on specific database
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "GRANT CREATE,
SELECT, UPDATE, INSERT, DELETE, DROP ON ${DATABASE}.* TO ${USER}@${SOURCE};"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

###The following script is used to reset the user’s password

####File Name: Change_password.bash:

!/bin/bash -x
```
EXPECTED_ARGS=4
E_BADARGS=65
CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
SOURCE="'%'"
USER="'$3'"
PASSWORD="'$4'"
```

#####Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE, ROOT_PASSWORD, DATABASE_NAME, USER_NAME, USER_PASSWORD"
  exit $E_BADARGS
fi
```

##### This uses root to Update user password
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "ALTER USER ${USER}@${SOURCE}
IDENTIFIED WITH mysql_native_password BY  ${PASSWORD};"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

###The following code will delete a dB user
#####File Name: Mysql_delete_user.bash:

!/bin/bash
```
EXPECTED_ARGS=3
E_BADARGS=65

CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
SOURCE="'%'"
USER="'$3'"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 userName"
  exit $E_BADARGS
fi
```

##### DROP/DELETE USER
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "DROP USER ${USER}@${SOURCE};"
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


##The following script will drop the specified data base
#####File name: MySQL_drop_Db.bash

!/bin/bash -x
```
EXPECTED_ARGS=3
E_BADARGS=65
CONTAINER_INSTANCE_id="$1"
ROOT_PASSWORD="$2"
DATABASE="$3"
```

##### Print error message showing the necessary parameters if script has not received required number of parameters
```
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 CONTAINER_INSTANCE, ROOT_PASSWORD, DATABASE_NAME, USER_NAME, USER_PASSWORD"
  exit $E_BADARGS
fi
```

##### Delete database
```
docker exec -it $CONTAINER_INSTANCE_id /usr/bin/mysql -h 127.0.0.1 -uroot -p$ROOT_PASSWORD -e "DROP DATABASE IF EXISTS $DATABASE;"
```
