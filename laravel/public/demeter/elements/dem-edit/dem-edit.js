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
		this.$.ajaxSendChanges.body = {'name':this.inputName,
										'description':this.inputDesc,
										'organization':this.inputOrg,
										'maxSize':this.inputSize,
										'ownerId':this.inputOwner};

		this.$.ajaxSendChanges.generateRequest();
	}
});