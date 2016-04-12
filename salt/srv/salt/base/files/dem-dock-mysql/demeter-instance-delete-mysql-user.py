import os
import sys
import time
import json
import shlex
import subprocess

def send_event(message):
  '''
  Emits an event to Salt event bus.

  Reactor on the Salt master needs to take care of this event.
  '''
  import salt.client
  caller = salt.client.Caller()
  caller.cmd('event.send', 'demeter/frontapi/replies', message )
  print('Salt event sent.')

def verify_environment():
  '''
  Double checks if all environment variables in the list have been set.
  '''
  env_variables = ['MYSQL_ROOT_PASSWORD', 'INSTANCEID', 'DBNAME', 'DBUSERNAME', 'SALT_EVENT_SOURCE_ID', 'SALT_VMUUID', 'APIUSER' ]
  for variable in env_variables:
    if not variable in os.environ:
      print('Expected variable '+variable+' not found!')
      return False
  return True

def delete_instance_user():
  '''
  Deletes a single database user. No tables are dropped.
  The database may be left without any user, apart from root.

  This function expects certain environmental values to be present in order to function.
  '''
  if not verify_environment():
    sys.exit(1)

  docker_mysql_user_delete = "docker exec "+os.environ.get('INSTANCEID')+" mysql -p"+os.environ.get('MYSQL_ROOT_PASSWORD')+" -e \"DROP USER "+os.environ.get('DBUSERNAME')+"@\'%\';\""

  try:
    p = subprocess.check_output(shlex.split(docker_mysql_user_delete), shell=False)
  except subprocess.CalledProcessError as e:
    output = e.output
  result = {}
  result["instanceId"] = os.environ.get('INSTANCEID')
  result["instanceName"] = os.environ.get('DBNAME')
  result["username"] = os.environ.get('DBUSERNAME')
  return result

json_message = delete_instance_user()
json_message["command"] = "deleteInstanceUser"
json_message["salt_event_source_id"] = os.environ.get('SALT_EVENT_SOURCE_ID')
json_message["netId"] = os.environ.get('APIUSER')
json_message["vm"] = os.environ.get('SALT_VMUUID')
send_event(json_message)
