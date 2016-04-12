
##Middleware to Backend Communication
This is the format of how the middleware will communicates with the backend code stored on VMs. This uses "Redis" for guaranteed message delivery.

####Redis Channel: demeter

#####format:
```
[
	'command' => 'createInstance',
	'vm' => [Id of the VM],
	'instanceId' => [Id of the instance],
	'instanceName' => [Name of the instance],
	'type' => [Instance type (mysql, mongo, oracle)],
	'maxSize' => [Maximum size of instance],
	'username' => [Instance user username],
	'password' => [Instance user password],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'updateInstance',
	'instanceId' => [Id of the instance],
	'vm' => [Id of the VM],
	'oldInstanceName' => [Previous name of instance],
	'instanceName' => [Name of the instance],
	'maxSize' => [Maximum size of instance],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'deleteInstance',
	'instanceId' => [Id of the instance],
	'vm' => [Id of the VM],
	'instanceName' => [Name of the instance],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'backupInstance',
	'instanceId' => [Id of the instance],
	'vm' => [Id of the VM],
	'type' => [Instance type (mysql, mongo, oracle)],
	'netId' => [NetId of logged in user],
]


[
	'command' => 'createInstanceUser',
	'vm' => [Id of the VM],
	'instanceId' => [Id of the instance],
	'instanceName' => [Name of the instance],
	'username' => [Instance user username],
	'password' => [Instance user password],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'resetPassword',
	'vm' => [Id of the VM],
	'instanceId' => [Id of the instance],
	'instanceName' => [Name of the instance],
	'username' => [Instance user username],
	'password' => [Instance user password],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'deleteInstanceUser',
	'vm' => [Id of the VM],
	'instanceId' => [Id of the instance],
	'instanceName' => [Name of the instance],
	'username' => [Instance user username],
	'netId' => [NetId of logged in user],
]


[	'command' => 'init',
	'vm' => [Id of the VM],
	'type' => [VM type (mysql, mongo, oracle)],
	'netId' => [NetId of logged in user],
]

[
	'command' => 'updateVm',
	'vm' => [Id of the VM],
	'type' => [VM type (mysql, mongo, oracle)],
	'netId' => [NetId of logged in user],
]

[
	'command' =>  'deleteVm',
	'vm' => [Id of the VM],
	'netId' => [NetId of logged in user],
]
```

##Backend to Middleware Communication
This is the format of how the backend will communicates with the middleware. This uses 'Redis' for guaranteed message delivery.

####Redis Channel: demeterMiddle

#####format:
```
[
        'command' => 'createInstance'
	'instanceId' => [Id of the instance],
	'currentSize' => [actual size of the instance],
	'ipAddr' => [IP address of the instance],
	'port' => [port of the instance],
]

[
	'command' => 'deleteInstance'
	'instanceId' => [Id of the instance],
]

[
	'command' => 'createVm'
	'id' => [Id of the VM],
        'ipAddr' => [IP address of the VM],
        'type' => [types of databases supported by VM],
	'spaceAvailabe' => [Space available on VM]
]

[
	'command' => 'updateVmSpace',
	'id' => [Id of the VM],
	'spaceAvailabe' => [Space available on VM]
]

[
	'command' => 'updateInstanceSize',
        'id' => [Id of the instance],
        'currentSize' => [actual size of the instance]
]
```
