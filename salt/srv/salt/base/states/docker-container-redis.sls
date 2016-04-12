redis-container:
  dockerng.image_present:
    - name: 'redis'
    - require:
      - pip: docker-python-bindings

