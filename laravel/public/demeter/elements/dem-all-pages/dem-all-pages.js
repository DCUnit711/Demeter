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
		pages.selected = 1;
		this.hideToolbar = true;

		document.addEventListener('goToPage',function(data){
			pages.selected = data.detail;
		});
		document.addEventListener('ajaxGetAllUsers',function(data){
			document.getElementById('ajaxGetAllUsers').params = data.detail;
			document.getElementById('ajaxGetAllUsers').generateRequest();
		});
		document.addEventListener('ajaxCreateDB',function(data){
			document.getElementById('ajaxCreateDB').params = data.detail;
			document.getElementById('ajaxCreateDB').generateRequest();
		});
		// document.addEventListener('getAllDB',function(data){
		// 	document.getElementById('ajaxGetAllDB').params = data.detail;
		// 	document.getElementById('ajaxGetAllDB').generateRequest();
		// });
		document.addEventListener('ajaxLoginUser',function(data){
			document.getElementById('ajaxLoginUser').params = data.detail;
			document.getElementById('ajaxLoginUser').generateRequest();
		});
	},	
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