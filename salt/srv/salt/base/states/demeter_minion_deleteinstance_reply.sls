create_instance_finish:
  cmd.run:
    - name: python /root/demeter-salt-redis-laravel-reply-destroy.py
    - env:
      - INSTANCEID: '{{ salt['pillar.get']('instanceId') }}'
#      - DBNAME: '{{ salt['pillar.get']('instanceName') }}'
#      - DBTYPE: '{{ salt['pillar.get']('type') }}'
#      - DBCURRENTSIZE: '{{ salt['pillar.get']('currentSize') }}'
#      - DBUSERNAME: '{{ salt['pillar.get']('username') }}'
#      - DBPASSWORD: '{{ salt['pillar.get']('password') }}'
      - APIUSER: '{{ salt['pillar.get']('netId') }}'
      - SALT_EVENT_SOURCE_ID: '{{ salt['pillar.get']('salt_event_source_id') }}'
      - SALT_VMUUID: '{{ salt['pillar.get']('vm') }}'
#      - DBIP: '{{ salt['pillar.get']('ipAddr') }}'
#      - DBPORT: '{{ salt['pillar.get']('port') }}'
