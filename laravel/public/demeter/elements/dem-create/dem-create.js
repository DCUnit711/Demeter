Polymer({
	is:"dem-create",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		animationConfig: {
	      	value: function() {
		        return {
		        	'entry':[{
		        		name:'slide-from-left-animation',
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
	selectSize:function(e){
		this.$.sizeDropdown.label = e.target._lightChildren[0].data;
	},
	selectType:function(e){
		this.$.typeDropdown.label = e.target._lightChildren[0].data;
	}
});