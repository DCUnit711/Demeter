Polymer({
	is:"dem-home",
	properties:
	{
		dbInfo:{ notify:true },
		returnDBUsed:{ observer:"compileReturnData" },
		returnDBTotalSize:{ observer:"compileReturnData" },
		returnDBType:{ observer:"compileReturnData" },
		returnValidUsername:{ observer:"compileReturnData" },
		returnDBIPAddress:{ observer:"compileReturnData" },
		returnDBName:{ observer:"compileReturnData" }
	},
	ready:function()
	{
		this.finishedLoading = false;
		this.loadingText = "Querying For Database Information..."
		this.dbInfo = {};
		this.$.ajaxUserDBFetch.generateRequest();//call the ajax
	},
	ajaxUserDBFetchResponse:function(){
		this.finishedLoading = true;
	},
	compileReturnData:function()
	{
		this.dbInfo = this.returnUserInfo.instances;
		console.log("finished");
		// this.dbInfo = {'DBNAME':this.returnUserInfo.instances[0].instanceId,
		// 				'TYPE':this.returnUserInfo.dbs[0].,
		// 				'SIZE':this.returnDBTotalSize,
		// 				'USED':this.returnDBUsed,
		// 				'USERNAME':this.returnValidUsername,
		// 				'IPADDRESS':this.returnDBIPAddress }	
	}
});