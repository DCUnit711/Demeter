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
		this.$.ajaxSendChanges.body = JSON.stringify({'NAME':this.database.NAME,
													  'DESCRIPTION':this.database.DESCRIPTION,
													  'ORGANIZATION':this.database.ORGANIZATION,
													  'SIZE':this.database.SIZE,
													  'OWNERID':this.database.OWNERID
													  'ID':this.database.ID});
		this.$.ajaxSendChanges.generateRequest();
	}
});