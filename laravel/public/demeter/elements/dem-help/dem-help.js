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
		this.externalLinks = [{'link':'https://dev.mysql.com/doc/refman/5.5/en/connecting.html', 'description':'MySQL - How To Log Into and query the database?'},
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/create-user.html','description':'MySQL - How Do I Create A User?'}];
	},
	goToLink:function(e){
		window.location.href = e.target.externalLink;
	}
});