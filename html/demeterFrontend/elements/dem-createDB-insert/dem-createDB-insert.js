Polymer({
	is:"dem-createDB-insert",
	properties:{
		
	},
	ready:function()
	{
		this.$.addContent.opened = false;
		this.showButton = true;
		this.dbOptions = [
			{'NAME':'MySQL', 'ID':'MySQLID'},
			{'NAME':'Oracle','ID':'OracleID'},
			{'NAME':'Mongo','ID':'MongoID'}
		];
		
		this.dbSizeOptions = [
			{'DISPLAY':'4 Gigabytes', 'ID':'4'},
			{'DISPLAY':'6 Gigabytes', 'ID':'6'},
			{'DISPLAY':'8 Gigabytes', 'ID':'8'},
			{'DISPLAY':'10 Gigabytes', 'ID':'10'}
		];
	},
	displayForum:function()
	{
		this.$.addContent.opened = true;
		this.showButton = false;
	},
	hideForum:function()
	{
		this.$.addContent.opened = false;
		this.showButton = true;
	},
	formCheck:function()
	{
		if(this.checkFields() == false)
		{
			this.popupDialogShow(true, "Missing Fields", "You have missing information. Fill out all the fields to continue.", 1);
		}
		else 
		{
			this.popupDialogShow(false, "About To Submit", "You are about to submit. Please verify that the information placed in this form is correct. This is final.", 2);
		}
	},
	createDB:function(){
		console.log("IT WORKED");
	},
	//---------SUPPORTING FUNCTIONS--------------//
	popupDialogShow:function(error, title, body, buttons){
		this.dialogBody = body;
		this.dialogTitle = title;
		if(error == true) 
		{
			this.$.titleDialog.style.color = "red";
		}
		else
		{
			this.$.titleDialog.style.color = "black";
		}
		this.noButton = false;
		this.oneButton = false;
		this.twoButtons = false;
		switch(buttons)
		{
			case 0:
				this.noButton = true;
				break;
			case 1:
				this.oneButton = true;
				break;
			case 2:
				this.twoButtons = true;
				break;
			default:
				this.oneButton = true;
				break;
		};
		this.$.popupDialog.opened = true;
	},
	setDatabaseSize:function(e)
	{
		this.selectedDatabaseSize = e.model.__data__.sizeOption.ID;
	},
	setDatabase:function(e)
	{
		this.selectedDatabase = e.model.__data__.database.ID;
	},
	checkFields:function()
	{
		var outcome = true;
		this.databaseName = this.$.dbNameInput.value;
		if(this.databaseName === null || this.databaseName === undefined || this.databaseName === "") 
		{
			outcome = false;
		}
		if(this.selectedDatabase == null)
		{
			outcome = false;
		}
		if(this.selectedDatabaseSize == null)
		{
			outcome = false;
		}
		console.log("name = "+this.databaseName+" selected = "+this.selectedDatabase+" size = "+this.selectedDatabaseSize);
		return outcome;
	}
});