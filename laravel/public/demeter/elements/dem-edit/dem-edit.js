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
			this.inputOwner == this.database.OWNERNAME;
		}

		var xhttp = new XMLHttpRequest();
		var polymer = this;
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	if(xhttp.status === 200) {
			    	polymer.fire('updateDatabases');
					polymer.fire('goToPage', 1);
			    	this.response = xhttp.responseText;
			    	if(xhttp.status == 200) {
			    		polymer.response = xhttp.responseText;
			    	}
		    	}
		    	else {
		    		polymer.errorNumber = xhttp.status;
		    		polymer.errorBody = xhttp.responseText;
		    		polymer.$.errorDialog.opened = true;
		    	}
		    }
		};
		console.log(this.inputOwner);
		var body = JSON.stringify({'name':this.inputName,
								   'ownerName':this.inputOwner,
								   'description':this.inputDesc,
								   'organization':this.inputOrg,
								   'maxSize':parseFloat(this.inputSize)});

		var url = "/instances/"+this.database.ID;
		xhttp.open("PUT", url, true);
		xhttp.send(body);
	},
	goToList:function(){
		this.fire("goToPage", 1);
	}
});