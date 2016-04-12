{% if grains['os_family'] == 'RedHat' %}
{% set repo = 'main' %}
{% set lsb_dist = salt['grains.get']('os', '')|lower %}
{% set dist_version = salt['grains.get']('osmajorrelease', '') %}


#If it's RedHat/CentOS 7 make sure firewalld is disabled.
# Docker will not start
disable-firewalld:
   service.dead:
     - name: firewalld

yum-docker-repo:
  pkgrepo.managed:
    - name: "Docker-{{ repo }}-Repository"
    - humanname: "docker-{{ repo }}-repo"
    - file: "/etc/yum.repos.d/docker-{{ repo }}.repo"
    - baseurl: "https://yum.dockerproject.org/repo/{{ repo }}/{{ lsb_dist }}/{{ dist_version}}"
    - enabled: True
    - gpgkey: https://yum.dockerproject.org/gpg
    - require:
      - service: disable-firewalld


{% elif grains['os_family'] == 'Debian' %}

{% set repo = 'main' %}
{% set lsb_dist = salt['grains.get']('lsb_distrib_id', '')|lower %}
{% set dist_version = salt['grains.get']('lsb_distrib_codename', '') %}
{% set kernel_release = salt['grains.get']('kernelrelease', '') %}

"Add APT Docker repo":
  pkgrepo.managed:
    - name: "deb https://apt.dockerproject.org/repo {{ lsb_dist }}-{{ dist_version }} {{ repo }}"
    - file: /etc/apt/sources.list.d/docker-main.list
    - keyid: 58118E89F3A912897C070ADBF76221572C52609D
    - keyserver: hkp://p80.pool.sks-keyservers.net:80

# Install kernel extras
"Install kernel extras":
  pkg.installed:
    - pkgs:
      - linux-image-extra-{{ kernel_release }}
      - linux-image-extra-virtual
      - apparmor
      - apt-transport-https
      - ca-certificates
      - docker-engine
    - upgrade: True

{% endif %}


install-docker:
  pkg.installed:
    - name: docker-engine
    - refresh: True
    - pkg: docker-engine

start-docker-service:
  service.running:
    - name: docker
    - reload: True
    - init_delay: 10
    - enable: True
    - require:
      - pkg: install-docker

docker-python-bindings:
  pip.installed:
    - name: docker-py
    - upgrade: True
    - require:
      - service: start-docker-service
      - cmd: update-python-pip
