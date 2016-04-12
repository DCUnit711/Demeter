docker-prereq:
  dockerng.image_present:
    - name: 'mysql'
    - require:
      - pip: docker-python-bindings
