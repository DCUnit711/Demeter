demeter-laravel-connector:
  local.state.apply:
    - tgt: 'dem-dock-laravel'
    {% if data['data']['command'] == 'createInstance' %}
    - arg:
      - demeter_minion_createinstance_reply
    - kwarg:
        pillar:
#           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'deleteInstance' %}
    - arg:
      - demeter_minion_deleteinstance_reply
    - kwarg:
        pillar:
#           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'createInstanceUser' %}
    - arg:
      - demeter_minion_createinstanceuser_reply
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'deleteInstanceUser' %}
    - arg:
      - demeter_minion_deleteinstanceuser_reply
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
