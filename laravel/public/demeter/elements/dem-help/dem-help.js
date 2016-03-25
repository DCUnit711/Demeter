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
							  {'link':'http://dev.mysql.com/doc/refman/5.7/en/insert.html','description':'MySQL - How Do I Insert New Information?'},
							  {'link':'https://docs.oracle.com/cd/E17952_01/refman-5.1-en/insert.html':'description':'Oracle - How Do I Insert Information?'},
							  {'link':'http://docs.oracle.com/javadb/10.5.3.0/ref/rrefsqlj26498.html','description':'Oracle - How Do I Update Information?'},
							  {'link':'https://docs.oracle.com/cd/B12037_01/appdev.101/b10807/13_elems014.htm','description':'Oracle - How Do I Delete Information?'},
							  {'link':'http://docs.oracle.com/javadb/10.6.1.0/ref/rrefsqlj24513.html','description':'Oracle - How Do I Create Something In The Database?'},
							  {'link':'https://docs.mongodb.org/manual/reference/method/db.collection.update/','description':'MongoDB - How Do I Update Information?'},
							  {'link':'https://docs.mongodb.org/manual/reference/method/db.collection.insert/','description':'MongoDB - How Do I Insert Information Into The DB?'},
							  {'link':'https://docs.mongodb.org/manual/reference/command/delete/','description':'MongoDB - How Do I Delete Information?'}];
	},
	goToLink:function(e){
		window.location.href = e.target.externalLink;
	},
	filterSelections:function(search) {
    return function(item){
      var string;
      if (!search) return true;
      if (!item) return false;
      search = search.toUpperCase();
      if(item.description && ~item.description.toUpperCase().indexOf(search)) {
        return true;
      }
      else {
        return false;
      }
    }
  },
});