Polymer({
	is:"dem-sidemenu",
	properties:
	{
		page:{ notify:true }
	},
	ready:function(){
		$(window).on('hashchange', function() {
			switch(window.location.hash)
			{
				case '#home':
					document.getElementById('pageChanger').selected = 0;
					break;
				case '#create':
					document.getElementById('pageChanger').selected = 1;
					break;
				case '#help':
					document.getElementById('pageChanger').selected = 2;
					break;
				default:
					document.getElementById('pageChanger').selected = 0;
					break;
			}
		});
	},
});