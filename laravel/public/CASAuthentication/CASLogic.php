<html>
  	<body>
  		Authenticating with CAS, please wait...
	</body>
	<script>
//-------------------- PHPCAS SECTION ----------------------------	
<?php
	require_once '../resources/CASAuthentication/CAS.php';			//PHPCAS Library Import		

	phpCAS::client(CAS_VERSION_2_0, 'cas.byu.edu', 443, '/cas');	//Setup the phpCAS client
    //------------------------------------------------------------
  	phpCAS::setNoCasServerValidation();								//Don't validate with SSL
  	$url = 'http://128.187.104.23:1337/demeter/CASLogic.php';		//Return url after validation
	phpCAS::setFixedServiceURL($url);								//Set the return URL

	if (isset($_REQUEST['logout'])) {								//If wanting to log out
		echo "Logging Out.";
		$_SESSION['AUTH'] = false;									//Make user unable to call backend functions
		$_SESSION['AUTH_USER'] = ''; 								//Removed stored user
		$url = "http://128.187.104.23:1337/demeter/index.html";		//url to return to after completion
		phpCAS::logoutWithRedirectServiceAndUrl($url,'');			//set return url
	}
	else {
		?>console.log('Requesting to Log in');<?php
		$auth = phpCAS::checkAuthentication();						//Go to CAS and verify
		if($auth == false) {										//CAS failed the authentication
			?>console.log('Authentication Failed.');<?php
			$_SESSION['AUTH'] = false;								//Make user unable to call backend functions
			$_SESSION['AUTH_USER'] = '';							//Removed stored user
		    phpCAS::forceAuthentication();							//Take User to CAS sign in page
		}
		else {
			?>console.log('Currently Logged in - SET AUTH to true');<?php
			$_SESSION['AUTH'] = true;								//CAS successfully authenticated
			$_SESSION['AUTH_USER'] = phpCAS::getUser();				//return the authenticated user
		}
	} 
	?>
//--------------- PAGE REDIRECTING SERVICES -----------------------------------
		var url = window.location.origin+"/demeter/index.html";		//will redirect back to demeter index page
		window.location.href = url;									//do the redirect
	</script>
</html>