import redis
import signal
import json
import sys
import time
import os


def verify_environment():
  env_variables = ['MYSQL_ROOT_PASSWORD', 'INSTANCEID', 'DBNAME', 'DBTYPE', 'DBMAXSIZE', 'DBUSERNAME', 'DBPASSWORD', 'SALT_EVENT_SOURCE_ID', 'SALT_VMUUID', 'APIUSER' ]
  for variable in env_variables:
    if not variable in os.environ:
      print('Expected variable '+variable+' not found!')
      return False
  return True

#verify_environment()

result = {}
result['instanceId'] = os.environ.get('INSTANCEID')
result['command'] = 'deleteInstance'

r = redis.StrictRedis(host='localhost', port=6379, db=0)

r.publish('demeterMiddle', json.dumps(result))

