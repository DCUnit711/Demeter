Polymer({
	is:"dem-login",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		animationConfig: {
      		value: function() {
        		return {
        			'entry':[{
        				name:'fade-in-animation',
        				node:this
        			}],
          			'exit':[
	                {
	                  name:'slide-down-animation',
	                  node:this.$.signInButton
	                },
	                {
		        		name: 'slide-right-animation',
          				node:this.$.inputUsername
          			},
          			{
		        		name: 'slide-left-animation',
          				node:this.$.inputPassword
          			},
          			{
          				name:'slide-up-animation',
          				node:this.$.loginTitleText
          			},
	                {
	                	name:'fade-out-animation',
	                	node:this
	                }]
        		}
      		}
    	}
	},
	ready:function(){
		this.hideUsername = true;
		this.$.ajaxVerifyLoggedIn.generateRequest();
	},
	ajaxVerifyLoggedInResponse:function(){
		if(this.status === true) {
			this.fire('goToPage',1);
		}
	},
	login:function(){
		var url = window.location.origin+"/demeter/CASLogic.php";
		window.location.href = url;
	},
	ajaxCASVerifyResponse:function(){
		if(this.casResponse.AUTH == true){
			this.fire('goToPage',1);
		}
	}
});