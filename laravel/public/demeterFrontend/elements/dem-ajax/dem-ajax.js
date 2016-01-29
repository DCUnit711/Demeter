Polymer({
	is:"dem-ajax",
	properties:
	{
		dBUsedParams:{observer:"callDBUsed"},
		returnDBUsed:{notify:true},
		dBTotalSizeParams:{observer:"callDBTotalSize"},
		returnDBTotalSize:{notify:true},
		dBTypeParams:{observer:"callDBType"},
		returnDBType:{notify:true},
		validUsernameParams:{observer:"callValidUsername"},
		returnValidUsername:{notify:true},
		dBIPAddressParams:{observer:"callDBIPAddress"},
		returnDBIPAddress:{notify:true},
		dBNameParams:{observer:"callDBName"},
		returnDBName:{notify:true}
	},
	callDBUsed:function()
	{
		this.$.ajaxDBUsedFetch.params = dBUsedParams;
		this.$.ajaxDBUsedFetch.generateRequest();
	},
	callDBTotalSize:function()
	{
		this.$.ajaxTotalSizeFetch.params = dBTotalSizeParams;
		this.$.ajaxTotalSizeFetch.generateRequest();
	},
	callDBType:function()
	{
		this.$.ajaxDBTypeFetch.params = dBTypeParams;
		this.$.ajaxDBTypeFetch.generateRequest();
	},
	callValidUsername:function()
	{
		this.$.ajaxUsernameCheckFetch.params = validUsernameParams;
		this.$.ajaxUsernameCheckFetch.generateRequest();
	},
	callDBIPAddress:function()
	{
		this.$.ajaxIPAddressFetch.params = dBIPAddressParams;
		this.$.ajaxIPAddressFetch.generateRequest();
	},
	callDBName:function()
	{
		this.$.ajaxDBNameFetch.params = dBNameParams;
		this.$.ajaxDBNameFetch.generateRequest();
	}
});