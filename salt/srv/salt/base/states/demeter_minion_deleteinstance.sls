create_instance:
  cmd.run:
    - name: python /root/demeter-instance-delete-mysql.py
    - env:
      - INSTANCEID: '{{ salt['pillar.get']('instanceId') }}'
      - DBNAME: '{{ salt['pillar.get']('instanceName') }}' 
#      - DBTYPE: '{{ salt['pillar.get']('type') }}' 
#      - DBMAXSIZE: '{{ salt['pillar.get']('maxSize') }}'
#      - DBUSERNAME: '{{ salt['pillar.get']('username') }}'
#      - DBPASSWORD: '{{ salt['pillar.get']('password') }}'
      - APIUSER: '{{ salt['pillar.get']('netId') }}'
      - SALT_EVENT_SOURCE_ID: '{{ salt['pillar.get']('salt_event_source_id') }}'
      - SALT_VMUUID: '{{ salt['pillar.get']('vm') }}'
      - MYSQL_ROOT_PASSWORD: '{{ salt['pillar.get']('mysql_root_password') }}'

