Polymer({
	is:"dem-db-info",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		database:{ observer:"receivedDatabaseInfo" },
		animationConfig: {
      		value: function() {
        		return {
        			'entry':[
	                {
	                	name:'fade-in-animation',
	                	node:this
	                },
	                {
	                	name:'hero-animation',
          				id:'hero',
          				toPage:this
		            }],
          			'exit':[
          			{
          				name:'hero-animation',
          				id:'hero',
          				fromPage:this
          			},
	                {
	                  name:'fade-out-animation',
	                  node:this
	                }]
        		}
      		}
    	},
    	sharedElements: {
            value: function() {
                return {
                    'hero': this.$.infoButtonContainer
                }
            }
        }
	},
	//-----------------------------------------------------
	receivedDatabaseInfo:function(){
		if(this.database.USERS == null || this.database.USERS.length < 1) {
			this.push("database.USERS",{'name':'No Users'});
		}
		// document.getElementById("dataInstanceInfo").innerHTML = "<b>Instance IP:</b> "+this.database.INSTANCEIP+"<br/><b>Instance Port:</b> "+this.database.INSTANCEPORT+"<br/>";
	},
	//-----------------------------------------------------
	goToEdit:function() {
		this.fire("goToPage", 4); 	//opens the edit database page.
	},
	//-----------------------------------------------------
	goToList:function(){
		this.fire("goToPage", 1);	//go back to database list
	},
	//-----------------------------------------------------
	showAddDialog:function(){
		this.$.addUserDialog.opened = true;
	},
	showDeleteDialog:function(){
		this.$.deleteUserDialog.opened = true;
	},
	//-----------------------------------------------------
	deleteUserAjax:function(e){
		this.hideSpinner = true;
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 1) {
			 	this.hideSpinner = false;
			}
		    if (xhttp.readyState == 4) {
		    	this.response = xhttp.responseText;
		    	// this.hideSpinner = true;
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var url = "/instanceUsers/"+e.model.__data__.user.id;
		xhttp.open("DELETE", url, true);
		xhttp.send();
		this.$.deleteUserDialog.opened = false;
	},
	//-----------------------------------------------------
	addUserAjax:function(){
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === 1) {
				this.hideSpinner = false;
			}
		    if (xhttp.readyState === 4) {
		    	// this.hideSpinner = true;
		    	this.response = xhttp.responseText;
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var body = JSON.stringify({'name':this.username,
								   'password':this.password,
								   'instanceId':this.database.ID});
		var url = "/instanceUsers/";
		xhttp.open("POST", url, true);
		xhttp.send(body);
	},
	//-----------------------------------------------------
	deleteDatabaseAjax:function() {
		var polymer = this;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	this.response = xhttp.responseText;
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var url = "/instances/"+this.database.ID;
		xhttp.open("DELETE", url, true);
		xhttp.send();
	},
	//-----------------------------------------------------
	updateDatabaseInformation:function(){
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	var response = xhttp.responseText;
		    	response = JSON.parse(response);
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var url = "/instances/";
		xhttp.open("GET", url, true);
		xhttp.send();
	},
	//-----------------------------------------------------
	changePasswordDialog:function(e){
		this.selectedUser = e.model.__data__.user;
		this.$.changeInstanceUserDialog.opened = true;
	},
	//-----------------------------------------------------
	changeInstanceUserPassword:function(){
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	var response = xhttp.responseText;
		    	response = JSON.parse(response);
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var url = "/instanceUsers/"+this.selectedUser.id;
		xhttp.open("PUT", url, true);
		var data = JSON.stringify({'password':this.password});
		xhttp.send(data);
	},
	//-----------------------------------------------------
	openBackupDialog:function(){
		this.$.dbInfoBackupDialog.opened = true;
	},
	//-----------------------------------------------------
	backupDB:function(){
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		this.$.dbInfoBackupDialog.opened = true;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	if(xhttp.status == 200) {
		    		polymer.$.dbInfoBackupSuccess.opened = true;
				}
				else {
					polymer.errorNumber = xhttp.status;
					polymer.errorBody = xhttp.responseText;
					polymer.$.dbInfoErrorDialog.opened = true;
				}
		    }
		};
		xhttp.open("POST", "/backup", true);
		var data = JSON.stringify({'instanceId':this.database.ID,"vmId":this.database.VMID,"type":this.database.TYPE});
		xhttp.send(data);
	},
	//-----------------------------------------------------
	showDeleteDBDialog:function(){
		this.$.deleteDatabaseDialog.opened = true;
	}
});