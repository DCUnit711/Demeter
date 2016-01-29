Polymer({
	is:"dem-help",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		animationConfig: {
	      	value: function() {
		        return {
		        	name: 'scale-down-animation',
		        	node: this
		        }
	      	}
	    }
	},
	ready:function(){
	}
});