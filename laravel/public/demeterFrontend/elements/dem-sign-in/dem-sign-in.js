Polymer({
	is:"dem-sign-in",
	properties:{
		signInName:{ notify:true }
	},
	signIn:function(){
		document.getElementById("toolbarCheck").if = true;
		document.getElementById("pageChanger").selected = 0;
		// this.$.pageChanger.selected = 0;
	},
	setUserName:function(e){
		document.getElementById("welcomeUser").innerHTML = "Welcome back, "+e.target.value;
	}
});