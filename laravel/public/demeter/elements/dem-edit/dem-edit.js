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
		        		id:'editBox',
		        		toPage:this
		        	},
		        	{
		        		name:'scale-up-animation',
		        		node:this
		        	}],
		        	'exit':[{
		        		name:'fade-out-animation',
		        		node:this
		        	}]
		        }
	      	}
	    },
	    sharedElements: {
            value: function() {
                return {
                    'editBox': this.$.editCard
                }
            }
        }
	}
});