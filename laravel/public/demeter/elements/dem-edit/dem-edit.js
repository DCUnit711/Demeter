Polymer({
	is:"dem-edit",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		database:{},
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
		        		name:'hero-animation',
		        		id:'hero',
		        		toPage:this
		        	},
		        	{
		        		name:'scale-up-animation',
		        		node:this
		        	}],
		        	'exit':[{
		        		name:'fade-out-animation',
		        		node:this
		        	},
		        	{
		        		name:'hero-animation',
		        		id:'hero',
		        		fromPage:this
		        	}]
		        }
	      	}
	    },
	    sharedElements: {
            value: function() {
                return {
                    'hero': this.$.editCard
                }
            }
        }
	},
	// content:function(){
	// 	console.log(this.database);
	// 	this.inputName = this.database.NAME;
	// 	this.inputOrg = this.database.ORGANIZATION;
	// 	this.inputDesc = this.database.DESCRIPTION;
	// 	this.inputSize = this.database.SIZE;
	// 	this.inputOwner == this.database.OWNERID;
	// },
	goBackToInfoPage:function(){
		this.fire("goToPage", 5);
	},
	requestChanges:function(){
		if(this.inputName == "" || this.inputName == null) {
			this.inputName = this.database.NAME;
		}
		if(this.inputOrg == "" || this.inputOrg == null) {
			this.inputOrg = this.database.ORGANIZATION;
		}
		if(this.inputDesc == "" || this.inputDesc == null) {
			this.inputDesc = this.database.DESCRIPTION;
		}
		if(this.inputSize == "" || this.inputSize == null) {
			this.inputSize = this.database.SIZE;
		}
		if(this.inputOwner == "" || this.inputOwner == null) {
			this.inputOwner == this.database.OWNERID;
		}

		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	// this.processing = false;
		    	polymer.fire('updateDatabases');
				polymer.fire('goToPage', 1);
		    	this.response = xhttp.responseText;
		    	if(xhttp.status == 200) {
		    		this.response = xhttp.responseText;
		    	}
		    }
		};
		var body = JSON.stringify({'name':this.inputName,
								   'ownerId':this.database.OWNERID,
								   'description':this.inputDesc,
								   'organization':this.inputOrg,
								   'maxSize':parseFloat(this.inputSize)});

		var url = "/instances/"+this.database.ID;
		xhttp.open("PUT", url, true);
		xhttp.send(body);
		// this.processing = true;
		// this.$.progressDialog.opened = true;
	},
	goToList:function(){
		this.fire("goToPage", 1);
	}
});