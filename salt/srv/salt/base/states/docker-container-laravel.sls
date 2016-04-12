demeter/demimage:test:
  dockerng.image_present:
#    - name: 'php:5'
    - build: /root/dockerfiles/laravel/Dockerfile
    - require:
      - pip: docker-python-bindings

/root/dockerfiles/laravel:
  file.directory:
    - makedirs: True

/root/dockerfiles/laravel/Dockerfile:
  file.managed:
    - source: salt://files/laravel-dockerfile

laravel-container1-laravel:
  dockerng.image_present:
    - name: LaravelContainer
    - image: 
    - hostname: laravel1
    - tty: True
    - interactive: True
    - ports:
      - 8000/tcp
#    - binds:
#      - /demo/web/site1:/usr/share/nginx/html:ro
    - port_bindings:
      - 8000:8000/tcp
    - dns:
      - 8.8.8.8
      - 8.8.4.4
#hell should freeze over before we leave variables in state file. get them from pillar, current is just for testing
    - environment:
      - MYSQL_ROOT_PASSWORD: 'laravel8test'
      - MYSQL_DATABASE: 'homestead'
      - MYSQL_USER: 'homestead'
      - MYSQL_PASSWORD: 'salt5pass3'
    - require:
      - dockerng: -container
