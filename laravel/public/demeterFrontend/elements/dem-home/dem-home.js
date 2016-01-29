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
		returnDBName:{ observer:"compileReturnData" },
		condensedScreen:{ observer:"screenSizedChanged" },
		show: { observer: "showTemp" }
	},
	ready:function()
	{
		this.finishedLoading = false;
		this.loadingText = "Querying For Database Information..."
		this.$.ajaxUserDBFetch.generateRequest();//call the ajax
		// this.ajaxUserDBFetchResponse();//for testing
		this.screenSizedChanged();
		this.showTempDB = false;
		this.loading = false;
	},
	screenSizedChanged: function()
	{
		if(this.condensedScreen == false)
		{
			this.loginInfoRight = "login-info-right";
			this.loginInfoLeft = "login-info-left";
			this.loginInfoDiv = "login-info-div";
			this.spaceCalculator = "space-calculator-div";
		}
		else
		{
			this.loginInfoRight = "login-info-right";
			this.loginInfoLeft = "login-info-left";
			this.loginInfoDiv = "login-info-div-condensed";
			this.spaceCalculator = "space-calculator-div-condensed";
		}
	},
	ajaxUserDBFetchResponse:function()
	{
		this.finishedLoading = true;
		this.compileReturnData();
	},
	showTemp:function()
	{
		if(this.show == true) {
			console.log("working");
			this.showTempDB = true;
			this.showSize = "Creating";
			this.loading = true;
			setTimeout(
				function()
				{ 
					document.getElementById("tempSize").innerHTML = "20 MB";
					document.getElementById("tempBubble").value = 400;
			        document.getElementById("tempLoading").active = false;
			    }, 3000
			);

			console.log("end")
		}
	},
	compileReturnData:function()
	{
		 this.dbInfo = [];
		for(var i in this.returnUserInfo.instances) 
		{
			var instance = this.returnUserInfo.instances[i];
			for(var j in instance.dbs) 
			{
				dbs = instance.dbs[j];
				this.dbInfo.push(
					{
					 'NETID':this.returnUserInfo.netId,
					 'TYPE':instance.type,
					 'DBNAME':dbs.name,
					 'SIZE':parseFloat(dbs.maxSize).toFixed(0),
					 'USED':Math.floor((Math.random() * parseFloat(dbs.maxSize).toFixed(0)) + 1),
					 'IPADDRESS':'None',
					 'ID':dbs.id,
					 'CREATION':dbs.created_at
					}
				);	
			}
		}
		//below is for testing...
		// var size = 3;
		// for (var i =0; i < 3; i++) 
		// {
		// 	this.dbInfo[i] = {
		// 			 'NETID':'Test Net ID',
		// 			 'TYPE':'TEst type',
		// 			 'DBNAME':'Test DB Name',
		// 			 'SIZE':2048,
		// 			 'USED':1045,
		// 			 'IPADDRESS':'Test IP',
		// 			 'ID':'Test id',
		// 			 'CREATION':'Test Creation'
		// 			};
		// }
		console.log(this.dbInfo);
	}
});