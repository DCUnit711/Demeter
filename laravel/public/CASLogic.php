<?php
require_once $phpcas_path . '/CAS.php';
//phpCAS::setDebug();
//phpCAS::setVerbose(true);
// header('Access-Control-Allow-Origin: http://128.187.104.23:1337');
phpCAS::client(CAS_VERSION_2_0, 'cas.byu.edu', 443, '/cas');
//phpCAS::setCasServerCACert($cas_server_ca_cert_path);
phpCAS::setFixedServiceURL('128.187.104.23:1337/demeter/index.html');
phpCAS::setNoCasServerValidation();
if($_REQUEST['login']){
	phpCAS::forceAuthentication();
}
if($_REQUEST['logout']){
	phpCAS::logout();
}
$auth = phpCAS::checkAuthentication();
if($_REQUEST['check']){
	if($_SESSION['AUTH'] == true || $auth == true) {
		$_SESSION['AUTH'] == true;
	}
	else {
		$_SESSION['AUTH'] == false;
	}
}
else {
	if($auth == true) {
		$user = phpCAS::getUser();
		$_SESSION['AUTH'] = true;
		header('Location: 128.187.104.23:1337/demeter/index.html');
	}
	else {
		$_SESSION['AUTH'] = false;
	}
}
echo $_SESSION['AUTH'];