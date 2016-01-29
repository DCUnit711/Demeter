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
	},
	login:function(){
		this.hideToolbar = false;
		this.$.ajaxCASLogin.generateRequest();
		this.fire('getAllDB',{});
		this.fire('goToPage',1);

		//this.fire("ajaxLoginUser",{'USERNAME':this.username,'PASSWORD':this.password});
	}
});