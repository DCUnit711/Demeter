Polymer({
	is:"dem-help",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
		        		name:'scale-up-animation',
		        		node:this
		        	},
		        	{
		        		name:'hero-animation',
		        		id:'hero'
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

	},
	openMySQL:function(){
		this.$.collapse.toggle();
	}
});