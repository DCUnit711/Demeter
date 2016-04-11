# Demeter
Database as a Service
This is not yet an active project

##Middleware to Backend Communication
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

##File Structure
This will give a quick explanation of where you can find files for this project.

####Middleware Files
Controllers: .\laravel\app\Http\Controllers

Routing (When a certain controller will be called): .\laravel\app\Http

####Front End Files
Polymer Web Page Files: .\laravel\public\demeter\elements

Google Polymer Elements: .\laravel\public\demeter\bower_components

CAS System: .\laravel\public\demeter\CASLogic.php

##Front End Code Explanation

This system uses the "Polymer" 1.0+ Language which is a Javascript framework made by Google focused on a single webpage design.
Everything is accessed through the "index.html" file:
(It is highly recommened to look at the starter project for Polymer if you are not familure with the language. This project can be found here: )
'''
<html>
	<head>
		<title> Demeter </title>
		<script src="bower_components/webcomponentsjs/webcomponents.js"></script>
		<link rel="import" href="include.html"/>
	</head>
	<body>
		<dem-all-pages></dem-all-pages> //All elements are encapsulated within this element here
	</body>
</html>
'''

This uses a series of elements called "iron-ajax" to make ajax calls but also Javascript XHttp Requests are formatted within JS files as well. For a more in-depth explanation look at the "Front-End-Explaned.txt" file. This file will go into a little more detail how the front end communicates with the middleware. - Wes
