cloud:
  log_level: debug
  providers:
    aws-demeter-provider:
      id: < .. replace with yours .. >
      key: < .. replace with yours .. >
      keyname: < .. replace with yours .. >
      private_key: < .. replace with yours .. >
      securitygroup: < .. replace with yours .. >
      driver: ec2
      location: us-west-2
      ssh_interface: private_ips

  profiles:
    aws-demeter-profile1:
      provider: aws-demeter-provider
      image: ami-d440a6e7 < .. you need to set one up .. >
      size: t2.micro
      ssh_username: centos
      del_root_vol_on_destroy: True
      rename_on_destroy: True
#      script_args: -U 
      file_map:
        /srv/salt/base/states/hostname.sls: /srv/salt/base/states/hostname.sls
        /srv/salt/base/states/top.sls: /srv/salt/base/states/top.sls
      minion:
        master: {{ salt['cmd.run']('curl -s http://instance-data/latest/meta-data/local-ipv4') }}
        local_master: True
        hash_type: sha256
        startup_states: highstate
        mine_interval: 5
        mine_functions:
          network.ip_addrs: [eth0]
