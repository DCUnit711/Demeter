Polymer({
	is:"dem-all-pages",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		hideToolbar:{ },
		database:{},
		allUsers:{},
		database:{notify:true}
	},
	ready:function(){
		var pages = this.$.pages;
		pages.selected = 0;
		this.hideToolbar = true;
		var polymer = this;
		document.addEventListener('goToPage',function(data){
			switch(data.detail) {
				case 0:
					polymer.hideToolbar = true;
					break;
				case 1:
				case 2:
				case 3:
				case 4:
					polymer.hideToolbar = false;
					break
				default:
					break;
			}
			pages.selected = data.detail;
		});
		var polymer = this;
		document.addEventListener("updateDatabases",function(data) {
			console.log("Received this update call");
			polymer.updateAllDatabaseInfo();
		});
		console.log("Called Update Database")
		this.fire('updateDatabases');
		this.fire('goToPage', 0);
	},
	updateAllDatabaseInfo:function(){
		console.log("reached the function");
		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	var response = xhttp.responseText;
		    	response = JSON.parse(response);
		    	var tempArray = [];
		    	for(var index in response) {
		    		var object = {'CREATED':response[index].created_at,
									'DESCRIPTION':response[index].description,
									'ID':response[index].id,
									'USERS':response[index].instance_users,
									'SIZE':response[index].maxSize,
									'NAME':response[index].name,
									'ORGANIZATION':response[index].organization,
									'OWNERID':response[index].ownerId,
									'TYPE':response[index].type,
									'UPDATED':response[index].updated_at,
									'VMID':response[index].vmId,
									'VMIP':response[index]['vm'].ipAddr};
					tempArray.push(object);
		    	}
		    	this.database = tempArray;
		    	console.log(this.database);
		    }
		}
		var url = "/instances/";
		xhttp.open("GET", url, true);
		xhttp.send();
	},
	casLogout:function(){
		var url = window.location.origin+"/demeter/CASLogic.php?logout";
		window.location.href = url;	},
	goToHome:function(){
		this.fire('goToPage',1);
	},
	goToHelp:function(){
		this.fire('goToPage',2);
	},
	goToCreate:function(){
		this.fire('goToPage',3);
	}
});