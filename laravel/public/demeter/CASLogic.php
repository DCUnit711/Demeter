<html>
  	<body>
  		Authenticating with CAS, please wait...
	</body>
	<script>
//-------------------- PHPCAS SECTION ----------------------------	
<?php
	require_once '../resources/CASAuthentication/CAS.php';

	?>console.log('made it')<?php
	phpCAS::client(CAS_VERSION_2_0, 'cas.byu.edu', 443, '/cas');
    //--------------------------------------------------------------------------
  	phpCAS::setNoCasServerValidation();
  	$url = 'http://128.187.104.23:1337/demeter/CASLogic.php';
	phpCAS::setFixedServiceURL($url);

	if (isset($_REQUEST['logout'])) {
		echo "Logging Out.";
		$_SESSION['AUTH'] = false;
		$_SESSION['AUTH_USER'] = ''; 
		$url = "http://128.187.104.23:1337/demeter/index.html";
		phpCAS::logoutWithRedirectServiceAndUrl($url,'');
	}
	else {
		$auth = phpCAS::checkAuthentication();
		if($auth == false) {
			$_SESSION['AUTH'] = false;
			$_SESSION['AUTH_USER'] = '';
		    phpCAS::forceAuthentication();
		}
		else {
			$_SESSION['AUTH'] = true;
			$_SESSION['AUTH_USER'] = phpCAS::getUser();
		}
	} 
	?>
//--------------- PAGE REDIRECTING SERVICES -----------------------------------
		console.log('CAS Finished. Redirecting...');
		var url = window.location.origin+"/demeter/index.html";
		console.log(url);
		window.location.href = url;
	</script>
</html>