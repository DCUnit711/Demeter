# Demeter SaltStack Configuration

This directory hierarchy represents file layout for necessary files to control and run Demeter through Salt master.
Basic Salt operation and primitives are not covered here as they are outside the scope of this document and are much better explained in SaltStack documentation that can be found at https://docs.saltstack.com/en/getstarted/ .

A working Salt master install is required to use the files included configuration.

The files are in separate directory trees - etc/ and srv/. On Salt master the files in etc/ should go to /etc/salt while the files in srv/ belong to /srv/salt.

## Necessary configuration

Certain files need to be changed in order to use Salt to have a functional Demeter. 

### srv/salt/base/pillar/aws_cloud.sls
This file includes the configuration options necessary to access AWS. If Salt-cloud access to AWS is not desired, a different cloud provider configuraiton should be substituted. Detailed information on Salt Cloud configuration can be found at https://docs.saltstack.com/en/latest/topics/cloud/index.html.

### srv/salt/base/pillar/demeter_admindata_mysql.sls
Root password for Demeter MySql containers. This is shared with the scripts in the VM only for the duration of their execution through environment variables.

### srv/salt/base/pillar/docker-hub-account.sls
Credentials for Docker Hub. Current Salt Docker state implementation requires a valid Hub account. In order to automatically pull official images for different databases, this file must be populated with correct Docker Hub account information.

## Operation

Demeter Backend communicates via Salt event system with the VMs where the user databases are stored.
1. When the API server sends a command, demeter-redis-salt-connector.py picks it up and forwards the event to the Salt master. 

2. On Salt master, a reactor configured to listen for these events reacts to it and starts a state change in one of the Salt minions, depending on the attibutes sent from the API server. 

3. When the minion finishes its job, an event is fired for Salt master which again reacts, and runs a script on the API server instructing it to push a reply message through redis back Laravel.

