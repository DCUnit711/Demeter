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
(It is highly recommened to look at the starter project for Polymer if you are not familure with the language. This project can be found here: https://developers.google.com/web/tools/polymer-starter-kit/)
```
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
```
####include.html
```
<link rel="import" href="bower_components/paper-toolbar/paper-toolbar.html"/>
<link rel="import" href="bower_components/paper-material/paper-material.html"/>
...
...
<!-- Custome Elements -->
<link rel="import" href="elements/dem-edit/dem-edit.html"/>
<link rel="import" href="elements/dem-db-info/dem-db-info.html"/>
```

This is simply a file that is used to include all of Googles elements (Listed from the top of the doc) and our custom made elements(Listed under "Custom Elements"). The file is referenced and used in the index.html file.

####Elements Folder Explanation
Everything inside of this folder are the custom demeter elements made for this project. This is broken down by page. The name of the folder will contain the HTML, JS, and CSS files related to the custom element. All elements are encapsulated within the "dem-all-pages" element. You will find this file in the list here as well. So if I wanted to look at the home page I would look under the "dem-home" folder to find the homepage element. I tried to name things that make sense so you can easily find them.

######dem-all-pages Element
This is the page turner for the web page. This holds all elements within itself. This is the element that decides whether or not to turn to a page. That is decided by this section of HTML code:
```
<!-- ALL PAGES -->
	<neon-animated-pages id="pages" selected="[[selected]]">
		<!-- 0 --><dem-login></dem-login>
		<!-- 1 --><dem-home id="demHome"edit-database="{{database}}"></dem-home>
		<!-- 2 --><dem-help></dem-help>
		<!-- 3 --><dem-create database="{{database}}"></dem-create>
		<!-- 4 --><dem-edit database="{{database}}"></dem-edit>
		<!-- 5 --><dem-db-info database="{{database}}"></dem-db-info>
	</neon-animated-pages>
```

It also contains the toolbar for the webpage view with this section of code:
```
<!-- HEADER TOOLBAR -->
	<paper-toolbar id="titleToolbar" class="toolbar" hidden="{{hideToolbar}}">
		<div class="toolbar-title-top" on-click="goToHome">Demeter</div>
		<div class="toolbar-title-bottom" on-click="goToHome">Database Creation and Managment System</div>
		<!-- <paper-button class="toolbar-button-4">Administrator</paper-button> -->
		<paper-button class="toolbar-button-3" on-click="goToCreate" raised>Create</paper-button>
		<paper-button class="toolbar-button-2" on-click="goToHelp" raised>Help</paper-button>
		<paper-button class="toolbar-button" on-click="casLogout" raised>Logout</paper-button>
	</paper-toolbar>
```

######dem-create Element
This page is shown when you click on "Create" in the web view. This is just a simple form that the user will fill out and its data will be transfered to the middleware for storage and creation of their desired database.

######dem-db-info Element
This page is shown when a user clicks on a database. It shows all information that the middleware has on that selected database. It will show things like the IP address, Port, Status, etc. It also has a series of other buttons that will display pop-ups for users to fill out. All of these pop-ups are used to edit the selected database. This page has the functionality to add users, add managers, delete users or managers, backup database calls, edit DB info like name, size etc.

######dem-edit Element
This is a page that shows a form like dem-create but it is used to edit the selected database. You will get to this page by clicking on "Edit Database" button found within the "dem-db-info" element. It will send these requested changes to the middleware which will store those changes within its MySQL database.

######dem-help Element
This is just a series of links that can be searched through to help beginning developers to gain some knowledge about their selected database. It will bring them to documentation about a desired topic. 

######dem-home Element
This is the default element that is shown right after the user logs in using CAS (Central Authentication System). It will make a call to the middleware to gather information related to the logged in user. It will then display all databases that they have the right to manage. Otherwise the page will appear to be blank.

######dem-login Element
If the user is not already authenticated when they access the demeter system this element will display. This element makes use of the "CASLogic.php" file. It will simply link them to this file that will redirect them to the CAS login that allows them to be authenticated through the CAS system. When they are authenticated it simply checks the middleware for the correct variable being set. If it is set then they will be redirected to the "dem-home" element.

------------------- Quick Note ----------------------------

All of the above element use a combination of Polymers "iron-ajax" elements and custom Javascript XHttp Requests. While Polymer's "iron-ajax" elements are powerful they seem to change things in their requests just enough to make it not fully mesh correctly with the Laravel middleware code. So to get around this we have crafted our own XHttp Requests within the JS of each element. This is to ensure that correct headers are being sent and nothing is being added or subtracted from these that we don't know about. This has proven to work while the ajax requests made with "iron-ajax" seem to be intermitent. That's why you will see the iron-ajax element in the HTML sometimes and fired within the JS. While other times this element will be absent the a new request crafted within the JS only.
