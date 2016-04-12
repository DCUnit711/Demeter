nginx-container:
  dockerng.image_present:
    - name: 'nginx'
    - require:
      - pip: docker-python-bindings

startup-container1-nginx:
  dockerng.running:
    - name: NgixContainer
    - image: nginx
    - hostname: www1
    - tty: True
    - interactive: True
    - ports:
      - 80/tcp
#    - binds:
#      - /demo/web/site1:/usr/share/nginx/html:ro
    - port_bindings:
      - 80:80/tcp
    - dns:
      - 8.8.8.8
      - 8.8.4.4
    - require:
      - dockerng: nginx-container
