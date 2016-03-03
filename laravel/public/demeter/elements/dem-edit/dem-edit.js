Polymer({
	is:"dem-edit",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		database:{ observer:"setDatabaseInstance"},
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
	setDatabaseInstance:function(){
		console.log(this.database);
		//this.$.ajaxSendChanges.url = "/instances/"+this.database.ID;
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
			this.inputOwner == this.database.OWNERID;
		}

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4) {
		    	this.processing = false;
		    	if(xhttp.status != 200) {
		    		this.response = "There was an error with your request.";
		    	}
		    	else {
		    		this.response = "Successfully sent your change request.";
		    		document.getElementById('ajaxGetAllDB').generateRequest();
		    	}
		       // Action to be performed when the document is read;
		       console.log(xhttp.responseText);
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
		this.processing = true;
		this.$.progressDialog.opened = true;
	},
	goToList:function(){
		this.fire("goToPage", 1);
	}
});