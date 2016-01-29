Polymer({
	is:"dem-home",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		users:{},
		databaseList:{ },
		editDatabase:{ notify:true },
		animationConfig: {
      		value: function() {
        		return {
        			'entry':[{
		        		name: 'slide-from-right-animation',
		        		timing:{ delay:200 },
          				node:this.$.databaseCard
          			},
          			{
		        		name: 'fade-in-animation',
		        		timing:{ delay:400 },
          				node:this.$.databaseCard
          			},
          			{
          				name:'slide-from-left-animation',
          				timing:{ delay: 100 },
          				node:this.$.databasePageTitle
          			},
	                {
	                	name:'fade-in-animation',
	                	node:this
	                }],
          			'exit':[
          			{
          				name:'hero-animation',
          				id:this.selectedDatabase,
          				fromPage:this
          			},
          			{
          				name:'slide-right-animation',
          				node:this.$.databaseCard
          			},
          			{
          				name:'slide-left-animation',
          				node:this.$.databasePageTitle
          			},
	                {
	                  name:'fade-out-animation',
	                  node:this
	                }]
        		}
      		}
    	}
	},
	ready:function(){
		this.hideRightClickMenu = true;
		this.databaseList = [];
		this.$.ajaxGetAllDB.generateRequest();
		this.selectedDatabase = "";
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
		this.editDatabase = e.model.__data__.database;
		this.selectedDatabase = document.getElementById(e.model.__data__.database.HTMLID);
		this.fire("goToPage",4);
	},
	showRightClickMenu:function(e){
		var y = parseFloat(e.clientY) - 30;
		this.$.rightClickMenu.style.left = e.clientX+"px";
		this.$.rightClickMenu.style.top = y+"px";
		this.hideRightClickMenu = false;
	},
	ajaxGetAllDBResponse:function(){
		var inuse;
		var color;
		var object;
		var uniqueId;
		this.databaseList = [];
		for(var i=0; i<this.databases.length; i++){
			uniqueId = "DatabaseListItem"+i;
			if(this.databases[i].inUse == 1) {
				inuse = "Currently In Use";
				color =  "green";
			}
			else {
				inuse = "Currently Not Use";
				color = "red";
			}
			object = {'CREATED':this.databases[i].created_at,
									'DESCRIPTION':this.databases[i].description,
									'ID':this.databases[i].id,
									'USERS':this.databases[i].instance_users,
									'SIZE':this.databases[i].maxSize,
									'NAME':this.databases[i].name,
									'ORGANIZATION':this.databases[i].organization,
									'OWNERID':this.databases[i].ownerId,
									'TYPE':this.databases[i].type,
									'UPDATED':this.databases[i].updated_at,
									'VMID':this.databases[i].vmId,
									'VMIP':this.databases[i]['vm'].ipAddr,
									'INUSE':inuse,
									'COLOR':color,
									'HTMLID':uniqueId};
			this.push('databaseList', object);
		}
		this.$.listDatabase.render();
	}
});