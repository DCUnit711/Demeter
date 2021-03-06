Polymer({
	is:"dem-home",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	stringify: function(obj){
                return JSON.stringify(obj);
        },

	properties:{
		users:{},
		databaseList:{ type:Array, value:function(){return [];}},
		editDatabase:{ notify:true },
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
	                	name:'fade-in-animation',
	                	node:this
	                },
	                {
	                	name:'hero-animation',
          				id:'hero',
          				toPage:this
		            }],
          			'exit':
          			[{
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
    	}
	},
	ready:function()
	{
		this.hideRightClickMenu = true;
		this.databaseList = [];
		this.$.ajaxGetAllDB.generateRequest();
		this.selectedDatabase = "";
		this.hideUpdateText = true;
	},
	refreshDBList:function(){
		this.hideUpdateText = false;
		this.fire("updateDatabases");
	},
	updateList:function(databases)
	{
		this.databaseList = databases
		this.$.listDatabase.render();
		this.hideUpdateText = true;
	},
	returnCurrentDate:function(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10) {
		    dd='0'+dd
		} 
		if(mm<10) {
		    mm='0'+mm
		} 
		return today;
	},
	closeRightClickMenu:function(){
		this.hideRightClickMenu = true;
	},
	goToEditDatabase:function(e){
		var target = e.target;
    	this.sharedElements = {
	      'hero': target
	    };
		this.editDatabase = e.model.__data__.database;
		this.selectedDatabase = document.getElementById(e.model.__data__.database.ID);
		this.fire("goToPage",5);
	},
	showRightClickMenu:function(e){
		var y = parseFloat(e.clientY) - 30;
		this.$.rightClickMenu.style.left = e.clientX+"px";
		this.$.rightClickMenu.style.top = y+"px";
		this.hideRightClickMenu = false;
	},
	ajaxGetAllDBResponse:function(){
		var statusString;
		var color;
		var object;
		var uniqueId;
		this.databaseList = [];
		if(this.databases != null) {
			for(var i=0; i < this.databases.length; i++){
				uniqueId = "DatabaseListItem"+i;	
				if(this.databases[i].inUse == "0") {	
					statusString = "Created, not in VM";
					color =  "green";
				}
				else if(this.databases[i].inUse == "1") {
					statusString = "Created and available in VM";
					color =  "green";
				}
				else if(this.databases[i].inUse == "-1") {
					statusString = "Waiting For Deletion";
					color = "red";
				}
				//this is also created in the all-oages element. Check there as well
				this.push('databaseList', {'CREATED':this.databases[i].created_at,
											'DESCRIPTION':this.databases[i].description,
											'ID':this.databases[i].id,
											'USERS':this.databases[i].instance_users,
											'DEMUSERS':this.databases[i].users,
											'CURRENTSIZE':this.databases[i].currentSize,
											'SIZE':this.databases[i].maxSize,
											'NAME':this.databases[i].name,
											'ORGANIZATION':this.databases[i].organization,
											'OWNERID':this.databases[i].ownerId,
											'OWNERNAME':this.databases[i].owner.netId,
											'TYPE':this.databases[i].type,
											'UPDATED':this.databases[i].updated_at,
											'VMID':this.databases[i].vmId,
											'VMIP':this.databases[i]['vm'].ipAddr,
											'STATUS':statusString,
											'COLOR':color,
											'HTMLID':uniqueId,
											'DBPORT':this.databases[i].port,
											'DBIP':this.databases[i].ipAddr});

			}
		}
	}
});
