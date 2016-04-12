create_instance_user:
  cmd.run:
    - name: python /root/demeter-instance-creator-mysql-user.py
    - env:
      - INSTANCEID: '{{ salt['pillar.get']('instanceId') }}'
      - DBNAME: '{{ salt['pillar.get']('instanceName') }}' 
#      - DBTYPE: '{{ salt['pillar.get']('type') }}' 
      - DBUSERNAME: '{{ salt['pillar.get']('username') }}'
      - DBPASSWORD: '{{ salt['pillar.get']('password') }}'
      - APIUSER: '{{ salt['pillar.get']('netId') }}'
      - SALT_EVENT_SOURCE_ID: '{{ salt['pillar.get']('salt_event_source_id') }}'
      - SALT_VMUUID: '{{ salt['pillar.get']('vm') }}'
      - MYSQL_ROOT_PASSWORD: '{{ salt['pillar.get']('mysql_root_password') }}'

