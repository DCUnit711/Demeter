Polymer({
	is:"dem-all-pages",
	behaviors:[Polymer.NeonSharedElementAnimatableBehavior],
	properties:{
		hideToolbar:{ },
		database:{},
		allUsers:{}
	},
	ready:function(){
		var pages = this.$.pages;
		pages.selected = 0;
		this.hideToolbar = true;
		var polymer = this;
		document.addEventListener('goToPage',function(data){
			switch(data.detail) {
				case 0:
					polymer.hideToolbar = true;
					break;
				case 1:
				case 2:
				case 3:
				case 4:
					polymer.hideToolbar = false;
					break
				default:
					break;
			}
			pages.selected = data.detail;
		});
		var polymer = this;
		document.addEventListener('ajaxGetAllUsers',function(data){
			polymer.$.ajaxGetAllUsers.params = data.detail;
			polymer.$.ajaxGetAllUsers.generateRequest();
		});
		document.addEventListener('ajaxCreateDB',function(data){
			polymer.$.ajaxCreateDB.params = data.detail;
			polymer.$.ajaxCreateDB.generateRequest();
		});
		document.addEventListener('ajaxLoginUser',function(data){
			polymer.$.ajaxLoginUser.params = data.detail;
			polymer.$.ajaxLoginUser.generateRequest();
		});
		this.fire('goToPage', 0);
	},	
	casLogout:function(){
		var url = window.location.origin+"/demeter/CASLogic.php?logout";
		window.location.href = url;	},
	goToHome:function(){
		this.fire('goToPage',1);
	},
	goToHelp:function(){
		this.fire('goToPage',2);
	},
	goToCreate:function(){
		this.fire('goToPage',3);
	}
});