base:
  '*':
    - hostname
    - up2date

  'dem-dock-mysql':
    - pip
    - docker-install
    - salt-mysql-container-host-files
    - docker-container-mysql

  'dem-dock-laravel':
    - pip
    - docker-install
    - docker-container-redis
    - git-package
    - salt-laravel-api-host-files

