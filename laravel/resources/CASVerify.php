<?php
require_once 'CASAuthentication/config.php';
// Load the CAS lib
require_once $phpcas_path . '/CAS.php';

  // Enable debugging
  //phpCAS::setDebug();
  // Enable verbose error messages. Disable in production!
  //phpCAS::setVerbose(true);

  // Initialize phpCAS
  phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

  // For production use set the CA certificate that is the issuer of the cert
  // on the CAS server and uncomment the line below
  // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

  // For quick testing you can disable SSL validation of the CAS server.
  // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
  // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
  phpCAS::setNoCasServerValidation();
  //phpCAS::forceAuthentication();
  // check CAS authentication
  $auth = phpCAS::checkAuthentication();
  
  // if ($auth == true) {
  //   echo "AUTHENTICATED! With User: "+phpCAS::getUser();
  //   echo "PHPCAS Version = "+phpCAS::getVersion();
  // }
  // else {
  //   echo "Authentication Failed";
  // }