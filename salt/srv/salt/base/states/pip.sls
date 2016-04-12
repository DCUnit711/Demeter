install-python-pip:
  pkg.installed:
    - name: python-pip

update-python-pip:
  cmd.run:
    - name: 'easy_install -U pip'
    - require:
      - pkg: install-python-pip
