Polymer({
	is:"dem-login",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		hideToolbar:{ notify:true },
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
		//window.location.href="../../../CASCall.php";
		//this.$.ajaxCASVerify.params = {'REQUEST':'login'};
		this.$.ajaxCASVerify.generateRequest();
	},
	login:function(){
		this.hideToolbar = false;
		// this.$.ajaxCASLogin.generateRequest();
		window.location.href = "../../../CASCall.php?login=";
		//this.fire('getAllDB',{});
		//this.fire('goToPage',1);

		//this.fire("ajaxLoginUser",{'USERNAME':this.username,'PASSWORD':this.password});
	},
	ajaxCASVerifyResponse:function(){
		console.log(this.casResponse);
		if(this.casResponse == true){
			this.fire('goToPage',1);
		}
	}
});