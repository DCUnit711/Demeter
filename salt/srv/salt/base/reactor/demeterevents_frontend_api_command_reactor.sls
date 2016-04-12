demeter-apicommandreactor:
  local.state.apply:
    - tgt: 'uuid:{{ data['data']['vm'] }}'
    - expr_form: grain
    {% if data['data']['command'] == 'createInstance' %}
    - arg:
      - demeter_minion_createinstance
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'deleteInstance' %}
    - arg:
      - demeter_minion_deleteinstance
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'createInstanceUser' %}
    - arg:
      - demeter_minion_createinstanceuser
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'deleteInstanceUser' %}
    - arg:
      - demeter_minion_deleteinstanceuser
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
    {% if data['data']['command'] == 'resetPassword' %}
    - arg:
      - demeter_minion_resetpassword
    - kwarg:
        pillar:
           salt_event_source_id: {{ data['id'] }}
           {% for item, value in data['data'].iteritems() %}
           {{ item }}: {{ value }}
           {% endfor %}
    {% endif %}
