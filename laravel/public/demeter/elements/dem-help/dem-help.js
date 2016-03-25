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
	},
	goToLink:function(e){
		console.log(Polymer.dom(e).path);
	}
});