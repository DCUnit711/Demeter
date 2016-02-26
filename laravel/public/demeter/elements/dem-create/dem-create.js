Polymer({
	is:"dem-create",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		database:{},
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
		console.log(e.target._lightChildren[0].data);
	},
	selectType:function(e){
		this.$.typeDropdown.label = e.target._lightChildren[0].data;
	},
	createDB:function(){
		if(this.inputOwner == null || this.inputOwner == "") {
			this.inputOwner = this.database.OWNERID;
		}
		if(this.inputName == null || this.inputName == "") {

		}
		if(this.inputDesc == null || this.inputDesc == "") {
			
		}
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		       console.log(xhttp.responseText);
		    }
		};
		var body = JSON.stringify({'name':this.inputName,
								   'ownerId':this.database.OWNERID,
								   'description':this.inputDesc,
								   'organization':this.inputOrg,
								   'maxSize':parseFloat(this.inputSize)});

		var url = "/instances/"+this.database.ID;
		xhttp.open("PUT", url, true);
		console.log(body);
		xhttp.send(body);
	}
});