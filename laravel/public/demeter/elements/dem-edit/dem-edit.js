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
		this.$.ajaxSendChanges.url = "/instances/"+this.database.ID;
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
		// this.$.ajaxSendChanges.body = JSON.stringify({'name':this.inputName,
		// 								'description':this.inputDesc,
		// 								'organization':this.inputOrg,
		// 								'maxSize':this.inputSize,
		// 								'ownerId':this.inputOwner});

		// this.$.ajaxSendChanges.url = "/instances/"+this.database.ID;
		// console.log(this.$.ajaxSendChanges);
		// console.log(this.$.ajaxSendChanges.body);
		// this.$.ajaxSendChanges.generateRequest();
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		       // Action to be performed when the document is read;
		    }
		};
		var body = {'name':this.inputName,
										'description':this.inputDesc,
										'organization':this.inputOrg,
										'maxSize':this.inputSize,
										'ownerId':this.inputOwner};
		var url = "/instances/"+this.database.ID;
		xhttp.open("PUT", url, true);
		xhttp.send(body);
	}
});