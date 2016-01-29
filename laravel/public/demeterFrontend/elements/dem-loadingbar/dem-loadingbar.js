Polymer({
	is:"dem-loadingbar",
	properties:{
		current:{ observer: "calcPercent" },
		max:{ observer: "calcPercent" },
		progressBar: { observer: "calcPercent" },
		showAmounts:{ observer: "calcPercent" },
		showStanding:{ observer: "calcPercent" }
	},
	// The following is setup to run synchronously 
	calcPercent:function ()
	{
		var current = parseFloat(this.current).toFixed(2);
		var max = parseFloat(this.max).toFixed(2);
		this.percent = ( current / max ) * 100;
		if(this.percent > 100) 
		{
			this.percent = 100;
		}
		this.setLoadingBarCSS();
		this.setAmountsCSS();
		this.setStandingCSS();
		this.reloadBar();
	},
	setLoadingBarCSS:function()
	{
		if(this.progressBar == null || this.progressBar === false) 
		{
			if( this.percent > Number(75) ) 
			{
				this.$.loadingBar.style.background = "red";
				this.standing = "Warning: Low Space Remaing";
			}
			else if(this.percent > Number(50) && (this.percent < Number(75) || this.percent == Number(75)) )
			{
				this.$.loadingBar.style.background = "#FFFF00";
				this.standing = "Okay: High Space Usage";
			}
			else if(this.percent > Number(35) && (this.percent < Number(50) || this.percent == Number(50)) ) 
			{
				this.$.loadingBar.style.background = "#008F00";
				this.standing = "Good";
			}
			else if(this.percent < Number(35) || this.percent == Number(35) ) 
			{
				this.$.loadingBar.style.background = "#00CC00";
				this.standing = "Great"
			}
		}
		else
		{
			this.$.loadingBar.style.background = "#3399FF";
		}	
	},
	setAmountsCSS: function()
	{
		this.bottomLeft = false;
		this.bottomMiddle = false;
		this.bottomRight = false;
		this.bottomSplit = false;
		this.topRight = false;
		this.topMiddle = false;
		this.topLeft = false;
		this.topSplit = false;

		if(this.showAmounts === "bottom-left")
		{
			this.bottomLeft = true;
		}
		else if(this.showAmounts === "bottom-middle") 
		{
			this.bottomMiddle = true;
		}
		else if(this.showAmounts === "bottom-right") 
		{
			this.bottomRight = true;
		}
		else if(this.showAmounts === "bottom-split") 
		{
			this.bottomSplit = true;
		}
		else if(this.showAmounts === "top-left") 
		{
			this.topLeft = true;
		}
		else if(this.showAmounts === "top-middle") 
		{
			this.topMiddle = true;
		}
		else if(this.showAmounts === "top-right") 
		{
			this.topRight = true;
		}
		else if(this.showAmounts === "top-split") 
		{
			this.topSplit = true;
		}
	},
	setStandingCSS:function()
	{
		this.standingTopLeft = false;
		this.standingTopMiddle = false;
		this.standingTopRight = false;
		this.standingBottomLeft = false;
		this.standingBottomMiddle = false;
		this.standingBottomRight = false;

		if(this.showStanding === "top-left") 
		{
			this.standingTopLeft = true
		}
		else if(this.showStanding === "top-middle") 
		{
			this.standingTopMiddle = true;
		}
		else if(this.showStanding === "top-right") 
		{
			this.standingTopRight = true;
		}
		else if(this.showStanding === "bottom-left") 
		{
			this.standingBottomLeft = true;
		}	
		else if(this.showStanding === "bottom-middle") 
		{
			this.standingBottomMiddle = true;
		}
		else if(this.showStanding === "bottom-right")
		{
			this.standingBottomRight = true;
		}
	},
	reloadBar: function()
	{
		if(isNaN(this.percent) === true)
		{
			this.amountUsed = "Calculating...";
			this.amountRemaining = "Calculating...";
		}
		else
		{
			this.amountUsed = parseFloat(this.percent).toFixed(2)+"%";
			this.amountRemaining = parseFloat(100 - this.percent).toFixed(2)+"%";
		}
		$(this.$.loadingBar).animate({ width: this.percent+"%" }, 'slow');
	}
});