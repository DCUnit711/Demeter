Polymer({
	is:"dem-help",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
		        		name:'scale-up-animation',
		        		id:this.$.editCard,
		        		toPage:this
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
		
	}
});