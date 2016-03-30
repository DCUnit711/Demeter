Polymer({
	is:"dem-create",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		database:{},
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
		        		name:'slide-from-left-animation',
		        		node:this
		        	}],
		        	'exit':[{
		        		name:'fade-out-animation',
		        		node:this
		        	}]
		        }
	      	}
	    }
	},
	ready:function(){
		this.inputOwner = "";
		this.inputName = "";
		this.inputDesc = "";
		this.inputOrg = "";
		this.size = 0;
	},
	selectSize:function(e){
		this.$.sizeDropdown.label = e.target._lightChildren[0].data;
		switch(e.target._lightChildren[0].data) {
			case "2 GB":
				this.size = 2048;
				break;
			case "4 GB":
				this.size = 4096;
				break;
			case "8 GB":
				this.size = 8184;
				break;
			default:
				break;
		}
	},
	selectType:function(e){
		this.$.typeDropdown.label = e.target._lightChildren[0].data;
		this.dbType = e.target._lightChildren[0].data;
	},
	createDB:function(){
		if(this.inputName == null || this.inputName == "") {
			this.inputName = this.database.NAME;
		}
		if(this.inputDesc == null || this.inputDesc == "") {
			this.inputDesc = this.database.DESCRIPTION;
		}
		if(this.inputOrg == null || this.inputOrg == "") {
			this.inputOrg = this.database.ORGANIZATION;
		}
		if(this.size == undefined || this.size < 1) {
			console.error('didnt add size');
		}
		var polymer = this;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		       	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    }
		};
		var body = JSON.stringify({'name':this.inputName,
								   'password':this.inputPassword,
								   'username':this.inputUsername,
								   'description':this.inputDesc,
								   'organization':this.inputOrg,
								   'maxSize':parseFloat(this.size),
								   'type':this.dbType});

		var url = "/instances";
		xhttp.open("POST", url, true);
		xhttp.send(body);
	}
});