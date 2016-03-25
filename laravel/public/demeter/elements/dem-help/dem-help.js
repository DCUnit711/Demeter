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
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/create-user.html','description':'MySQL - How Do I Create A User?'},
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/update.html','description':'MySQL - How Do I Update Information?'},
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/delete.html','description':'MySQL - How Do I Delete Information?'},
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/insert.html','description':'MySQL - How Do I Insert New Information'}];
	},
	goToLink:function(e){
		window.location.href = e.target.externalLink;
	}
});