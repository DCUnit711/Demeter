{%- set fqdn = grains['id'] %}

fix-step1:
  file.replace:
    - name: /etc/hosts
    - repl: "" 
    - pattern: '^127.*'
    - unless: test "{{ fqdn }}" = "$(hostname)"

fix-step2:
  host.present:
    - ip: 127.0.0.1
    - names:
      - {{ fqdn }}
      - localhost
    - onchanges:
      - file: fix-step1

{%- if grains['os_family'] == 'RedHat' %}
etc-sysconfig-network:
  cmd.run:
    - name: echo -e "NETWORKING=yes\nHOSTNAME={{ fqdn }}\n" > /etc/sysconfig/network
    - unless: test -f /etc/sysconfig/network
  file.replace:
    - name: /etc/sysconfig/network
    - pattern: HOSTNAME=localhost.localdomain
    - repl: HOSTNAME={{ fqdn }}
{% endif %}

{%- if grains['os_family'] == 'Suse' %}
/etc/HOSTNAME:
  file.managed:
    - contents: {{ fqdn }}
    - backup: false
{% else %}
/etc/hostname:
  file.managed:
    - contents: {{ fqdn }}
    - backup: false
{% endif %}

set-fqdn:
  cmd.run:
    {% if grains["init"] == "systemd" %}
    - name: hostnamectl set-hostname {{ fqdn }}
    {% else %}
    - name: hostname {{ fqdn }}
    {% endif %}
    - unless: test "{{ fqdn }}" = "$(hostname)"

