demeter-laravel-connector:
  local.cmd.run:
    - tgt: '{{ data['data']['salt_event_source_id'] }}'
#    {% if data['data']['command'] == 'createInstance' %}
#    - arg:
#      - demeter_minion_createinstance_reply
    - kwarg:
       salt_event_source_id: {{ data['id'] }}
         {% for item, value in data['data'].iteritems() %}
         {{ item }}: {{ value }}
         {% endfor %}
#    {% endif %}
#    {% if data['data']['command'] == 'deleteInstance' %}
#    - arg:
#      - demeter_minion_deleteinstance_reply
#    - kwarg:
#        pillar:
#           salt_event_source_id: {{ data['id'] }}
#           {% for item, value in data['data'].iteritems() %}
#           {{ item }}: {{ value }}
#           {% endfor %}
#    {% endif %}
#    {% if data['data']['command'] == 'updateInstanceSize' %}
    - arg:
      - demeter_minion_updateinstance_reply
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'updateVmSpace' %}
    - arg:
      - demeter_minion_updatevmspace_reply
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}

  cmd.run:
    - name: python /root/demeter-salt-redis-laravel-reply.py
    - env:
      - salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
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

  local.state.apply:
    - tgt: '{{ data['kwarg']['salt_event_source_id'] }}'
    - arg:
      - demeter_minion_laravel_connector
    - kwarg:
        pillar:
          salt_event_source_id: {{ data['id'] }}
          command: {{ data['data']['command'] }}
          instanceId: {{ data['data']['instanceId'] }}
          name: {{ data['data']['name'] }}
          username: {{ data['data']['username'] }}
          password: {{ data['data']['password'] }}
