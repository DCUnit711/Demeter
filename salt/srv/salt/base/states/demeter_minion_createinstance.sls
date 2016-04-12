create_instance:
  cmd.run:
    {% if salt['pillar.get']('type') == 'mysql' %}
    - name: python /root/demeter-instance-creator-mysql.py
    {% endif %}
    {% if salt['pillar.get']('type') == 'mongo' %}
    - name: date > /tmp/salt-run-mongo
    {% endif %}
    - env:
      - INSTANCEID: '{{ salt['pillar.get']('instanceId') }}'
      - DBNAME: '{{ salt['pillar.get']('instanceName') }}' 
      - DBTYPE: '{{ salt['pillar.get']('type') }}' 
      - DBMAXSIZE: '{{ salt['pillar.get']('maxSize') }}'
      - DBUSERNAME: '{{ salt['pillar.get']('username') }}'
      - DBPASSWORD: '{{ salt['pillar.get']('password') }}'
      - APIUSER: '{{ salt['pillar.get']('netId') }}'
      - SALT_EVENT_SOURCE_ID: '{{ salt['pillar.get']('salt_event_source_id') }}'
      - SALT_VMUUID: '{{ salt['pillar.get']('vm') }}'
      {% if salt['pillar.get']('type') == 'mysql' %}
      - MYSQL_ROOT_PASSWORD: '{{ salt['pillar.get']('mysql_root_password') }}'
      {% endif %} 
      {% if salt['pillar.get']('type') == 'mongo' %}
      - MONGO_ROOT_PASSWORD: '{{ salt['pillar.get']('mysql_root_password') }}'
      {% endif %}

#event_after_createinstance:
#  event.send:
#    - name: demeter/frontapi/replies
#    - require: 
#      - cmd: create_mysql_instance
#    - kwarg:
#        tag: demeter/frontapi/replies
#        data:
#          salt_event_source_id: {{ salt['pillar.get']('salt_event_source_id:') }} 
#          command: {{ salt['pillar.get']('command') }}
