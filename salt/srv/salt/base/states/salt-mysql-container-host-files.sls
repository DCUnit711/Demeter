/root/demeter-instance-creator-mysql.py:
  file.managed:
    - source: salt://files/laravel-dockerfile/demeter-instance-creator-mysql.py

/root/demeter-instance-creator-mysql-user.py:
  file.managed:
    - source: salt://files/dem-dock-mysql/demeter-instance-creator-mysql-user.py

/root/demeter-instance-delete-mysql.py:
  file.managed:
    - source: salt://files/dem-dock-mysql/demeter-instance-delete-mysql.py

/root/demeter-instance-delete-mysql-user.py:
  file.managed:
    - source: salt://files/dem-dock-mysql/demeter-instance-delete-mysql-user.py

/root/demeter-instance-resetpassword-mysql.py:
  file.managed:
    - source: salt://files/dem-dock-mysql/demeter-instance-resetpassword-mysql.py

