Polymer({
	is:"dem-createDB",
	properties:{
		dbInfo:{ notify:true }
	},
	ready:function()
	{
		this.creatingDB = false;
		this.loadingCurrent = 0;
		this.loadingMax = 10;
	},
	createDB:function()
	{
		this.creatingDB = true;
		this.async(function() {
		  this.testIncrement(2, "Initializing Creating Process...");
		},1000);
		this.async(function() {
		  this.testIncrement(4,"Sending Information...");
		},3000);
		this.async(function() {
		  this.testIncrement(8,"Adding Tables...");
		},6000);
		this.async(function() {
		  this.testIncrement(10,"Complete!");
		},9000);
	},
	testIncrement:function(update, message)
	{
		this.updateMessage = message;
		this.loadingCurrent = update;
	}
});