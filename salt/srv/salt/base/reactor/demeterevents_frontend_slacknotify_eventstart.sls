demeter-apicommand-slacknotification:
  local.slack.post_message:
    - tgt: 'master1.demeter.byu.edu'
    - kwarg:
        channel: '#event-log'
        message: |
                  {{ data['data']['command'] }} event started on behalf of *{{ data['data']['netId'] }}*.
                  {% if data['data']['command'] == 'createInstance' %}Starting to create {{ data['data']['type'] }} database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }} with user *{{ data['data']['username'] }}*
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'deleteInstance' %}Starting deletion of database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }}) 
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'createInstanceUser' %}Starting to create user *{{ data['data']['username'] }}* for database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }}) 
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'deleteInstanceUser' %}Starting to delete user *{{ data['data']['username'] }}* in database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }})
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'resetPassword' %}
                  Starting to reset password for *{{ data['data']['username'] }}* in database *{{ data['data']['instanceName'] }}* ({{ data['data']['instanceId'] }})
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'backupInstance' %}Starting to take a snapshot for *{{ data['data']['instanceId'] }}* 
                  VMid: {{ data['data']['vm'] }}
                  {% endif %}{% if data['data']['command'] == 'updateInstance' %}Starting to change *{{ data['data']['oldInstanceName'] }}* ({{ data['data']['instanceId'] }}). New: *{{ data['data']['instanceName'] }}* size: {{ data['data']['maxSize'] }}
                  VMid: {{ data['data']['vm'] }}{% endif %}
        api_key: < .. your slack admin api .. >
        from_name: "{{ data['id'] }}"
