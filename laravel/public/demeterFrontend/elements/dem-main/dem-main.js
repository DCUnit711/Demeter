Polymer({
	is:"dem-main",
	properties:{
		mobileScreen:{ observer:"changedScreenSize" }
	},
	ready:function(){
		this.selectedPage = 2;
		this.changedScreenSize();
		this.show = false;
	},
	toggleProgress: function(){
		this.progressBar = true;
	},
	toggleSpace: function(){
		this.progressBar = false;
	},
	selectHelpPage: function(){
		this.selectedPage = 1;
	},
	selectHomePage: function(){
		this.selectedPage = 0;
	},
	showCreationOptions:function(){
		this.$.dialogCreateDB.opened = true;
	},
	changedScreenSize:function()
	{
		if(this.mobileScreen == true)
		{
			this.toolbar = "heading-toolbar-mobile";
			this.createButton = "create-button-mobile";
			this.helpButton = "help-button-mobile";
			this.loginButton = "login-button-mobile";
		}
		else
		{
			this.toolbar = "heading-toolbar";
			this.createButton = "create-button";
			this.helpButton = "help-button";
			this.loginButton = "login-button";
		}
	},
	showTemp:function(){
		this.show = true;
	}
});