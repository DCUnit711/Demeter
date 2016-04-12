import os
import sys
import time
import json
import shlex
import random
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

def get_my_ip():
  '''
  Finds a current EC2 VM public ip.

  This is AWS deployment specific function and should change if end users can reach
  databases directly over aws vpc private address space.
  '''
  import requests
  r = requests.get("http://instance-data/latest/meta-data/public-ipv4")
  return r.content

def verify_environment():
  '''
  Double checks if all environment variables in the list have been set.
  '''
  env_variables = ['MYSQL_ROOT_PASSWORD', 'INSTANCEID', 'DBNAME', 'DBUSERNAME', 'DBPASSWORD', 'SALT_EVENT_SOURCE_ID', 'SALT_VMUUID', 'APIUSER' ]
  for variable in env_variables:
    if not variable in os.environ:
      print('Expected variable '+variable+' not found!')
      return False
  return True

def get_next_open_port():

  command1 = ["docker", "ps", "-q"]
  command2 = ["xargs", "-L1", "docker", "port"]
  command3 = ["cut", "-d:", "-f2"]
  if subprocess.check_output(command1, shell=False) == '':
    return 3306
  p1 = subprocess.Popen(command1, stdout=subprocess.PIPE, shell=False)
  p2 = subprocess.Popen(command2, stdin=p1.stdout, stdout=subprocess.PIPE, shell=False)
  p1.stdout.close()
  output = subprocess.check_output(command3, stdin=p2.stdout, shell=False)
  p2.stdout.close()
  list_of_ports = output.splitlines()
  list_of_ports.sort()
  if len(list_of_ports) == 0:
    port = 3306
  else:
    port = int(list_of_ports.pop())
  return random.randint(port, port+100) 

def create_new_instance():
  '''
  
  '''
  if not verify_environment():
    sys.exit(1)
  port_export = get_next_open_port()
  port_export_argument = str(port_export)+":3306"
  volume_hostpath = "/etc/demeter/dockermysqlconf.d"
  volume_containerpath = "/etc/mysql/conf.d"
  volume_argument = volume_hostpath+":"+volume_containerpath
  docker_image_name = "mysql"

  docker_mysql_run = ["docker", "run", "--name", os.environ.get('INSTANCEID'), "-e", "MYSQL_ROOT_PASSWORD", "-p", port_export_argument, "-v", volume_argument, "-d", docker_image_name]
#  docker_mysql_database_create = ["docker", "exec", "-it", os.environ.get('INSTANCEID'), "mysql", "-p"+os.environ.get('MYSQL_ROOT_PASSWORD'), "-e", "\"CREATE DATABASE "+os.environ.get('DBNAME')+";\""]
  docker_mysql_database_create = "docker exec "+os.environ.get('INSTANCEID')+" mysql -p"+os.environ.get('MYSQL_ROOT_PASSWORD')+" -e \"CREATE DATABASE "+os.environ.get('DBNAME')+";\""
  subprocess.check_output(docker_mysql_run, shell=False, env={"MYSQL_ROOT_PASSWORD": os.environ.get('MYSQL_ROOT_PASSWORD') } )
  available = False
  while not available:
    availability_check = [ "docker", "exec", os.environ.get('INSTANCEID'), "mysql", "-p"+os.environ.get('MYSQL_ROOT_PASSWORD'), "-e", "STATUS;"]
    p = subprocess.Popen(availability_check, shell=False, stdout=subprocess.PIPE, stderr=subprocess.PIPE )
    output = p.communicate()[0]
    if p.returncode == 0:
      available = True
    time.sleep(2)

  p.stdout.close()
  p.stderr.close()
  print "available!"
  try:
    p = subprocess.check_output(shlex.split(docker_mysql_database_create), shell=False)
  except subprocess.CalledProcessError as e:
    output = e.output
  create_instance_user()
  result = {}
  result["ipAddr"] = get_my_ip()
  result["port"] = str(port_export)
  result["instanceId"] = os.environ.get('INSTANCEID')
  result["instanceName"] = os.environ.get('DBNAME')
  result["username"] = os.environ.get('DBUSERNAME')
  result["currentSize"] = "20"
  result["type"] = "mysql"
  return result


def create_instance_user():
  if not verify_environment():
    sys.exit(1)

  docker_mysql_user_create = "docker exec "+os.environ.get('INSTANCEID')+" mysql -p"+os.environ.get('MYSQL_ROOT_PASSWORD')+" -e \"GRANT USAGE ON *.* TO "+os.environ.get('DBUSERNAME')+"@\'%\' IDENTIFIED BY \'"+os.environ.get('DBPASSWORD')+"\';\""

  docker_mysql_user_grant = "docker exec "+os.environ.get('INSTANCEID')+" mysql -p"+os.environ.get('MYSQL_ROOT_PASSWORD')+" -e \"GRANT CREATE, SELECT, UPDATE, INSERT, DELETE, DROP ON "+os.environ.get('DBNAME')+".* TO "+os.environ.get('DBUSERNAME')+"@\'%\';\""
  try:
    p = subprocess.check_output(shlex.split(docker_mysql_user_create), shell=False)
  except subprocess.CalledProcessError as e:
    output = e.output
  try:
    p = subprocess.check_output(shlex.split(docker_mysql_user_grant), shell=False)
  except subprocess.CalledProcessError as e:
    output = e.output

def create_instance_userwrapper():
  '''
  Wrapper function for creating database users.
  '''
  create_instance_user()
  result = {}
  result["instanceId"] = os.environ.get('INSTANCEID')
  result["instanceName"] = os.environ.get('DBNAME')
  result["username"] = os.environ.get('DBUSERNAME')
  result["currentSize"] = "20"
  result["type"] = "mysql"
  return result


json_message = create_instance_userwrapper()
json_message["command"] = "createInstanceUser"
json_message["salt_event_source_id"] = os.environ.get('SALT_EVENT_SOURCE_ID')
json_message["netId"] = os.environ.get('APIUSER')
json_message["vm"] = os.environ.get('SALT_VMUUID')
send_event(json_message)
