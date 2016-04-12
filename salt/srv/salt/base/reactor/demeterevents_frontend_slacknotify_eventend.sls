demeter-apicommand-slacknotification:
  local.slack.post_message:
    - tgt: 'master1.demeter.byu.edu'
    - kwarg:
        channel: '#event-log'
        message: |
                  Finished {{ data['data']['command'] }} event on behalf of *{{ data['data']['netId'] }}*.
                  {% if data['data']['command'] == 'createInstance' %}
                  Finished creating {{ data['data']['type'] }} database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }}) with user *{{ data['data']['username'] }}* at *{{ data['data']['ipAddr'] }}* port *{{ data['data']['port'] }}*
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'deleteInstance' %}
                  Finished deletion of database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }}) 
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'createInstanceUser' %}
                  Finished creating user *{{ data['data']['username'] }}* for database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }}) 
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'deleteInstanceUser' %}
                  Finished creating user *{{ data['data']['username'] }}* in database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }})
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'resetPassword' %}
                  Finished resetting password for *{{ data['data']['username'] }}* in database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }})
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'backupInstance' %}
                  Finished taking snapshot for *{{ data['data']['instanceId'] }}* from database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }})
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
                  {% if data['data']['command'] == 'updateInstance' %}
                  Finished changing *{{ data['data']['oldInstanceName'] }}* (({{ data['data']['instanceId'] }}). New: *{{ data['data']['instanceName'] }}* size: {{ data['data']['maxSize'] }}
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}
        api_key: < .. you slack admin api key here .. >
        from_name: "{{ data['id'] }}"
