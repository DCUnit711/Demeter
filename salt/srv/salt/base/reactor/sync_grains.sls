{% if data['fun_args'] is defined %}
{% set fun_args = data.fun_args %}
{% if 'hostname' in fun_args %}
sync_grains:
  local.saltutil.sync_grains:
    - tgt: {{ data['id'] }}
{% endif %}
{% endif %}
