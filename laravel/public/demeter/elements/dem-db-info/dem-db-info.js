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
		console.log(this.database);
		if(this.database.users == null) {
			this.push("database.instance_users","No Users");
		}
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
		var THISE = this;
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 1) {
			 	this.hideSpinner = false;
			}
		    if (xhttp.readyState == 4) {
		    	this.response = xhttp.responseText;
		    	this.hideSpinner = true;
		    	if(xhttp.status == 200) {
		    	 	THISE.updateDatabaseInformation();
		    	}
		    }
		};
		var url = "/instanceUsers/"+e.model.__data__.user.id;
		xhttp.open("DELETE", url, true);
		xhttp.send();
	},
	//-----------------------------------------------------
	addUserAjax:function(){
		var xhttp = new XMLHttpRequest();
		var THISE = this;
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState === 1) {
				this.hideSpinner = false;
			}
		    if (xhttp.readyState === 4) {
		    	this.hideSpinner = true;
		    	this.response = xhttp.responseText;
		    	THISE.updateDatabaseInformation();
		    }
		};
		var body = JSON.stringify({'name':this.username,
								   'instanceId':this.database.ID});
		var url = "/instanceUsers/";
		xhttp.open("POST", url, true);
		xhttp.send(body);
	},
	//-----------------------------------------------------
	deleteDatabaseAjax:function() {
		this.fire('selectPage', 1);
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	this.response = xhttp.responseText;
		    }
		};
		var url = "/instances/"+this.database.ID;
		xhttp.open("DELETE", url, true);
		xhttp.send();
	},
	//-----------------------------------------------------
	updateDatabaseInformation:function(){
		var xhttp = new XMLHttpRequest();
		var THISE = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	var response = xhttp.responseText;
		    	response = JSON.parse(response);
		    	console.log(response);
		    	for(var index in response) {
		    		if(response[index].id === THISE.database.ID) {
		    			console.log("DATABASE FOUND!");
		    			console.log(response[index]);
		    			THISE.set("database", response[index]);
		    		}
		    	}
		    }
		};
		var url = "/instances/";
		xhttp.open("GET", url, true);
		xhttp.send();
	}
});