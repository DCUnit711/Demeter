<?php

/**
 * Example that uses the CAS gateway feature
 *
 * PHP Version 5
 *
 * @file     example_gateway.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */
namespace = App\Http\Controllers;

// Load the settings from the central config file
  //require_once 'CASAuthentication/config.php';
  // Load the CAS lib
  //require_once $phpcas_path . '/CAS.php';

  // Enable debugging
//  phpCAS::setDebug();
  // Enable verbose error messages. Disable in production!
  //phpCAS::setVerbose(true);

  // Initialize phpCAS
 // phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);


class CASController extends Controller {

  // For production use set the CA certificate that is the issuer of the cert
  // on the CAS server and uncomment the line below
  // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

  public function casLogin(){
    // For quick testing you can disable SSL validation of the CAS server.
    // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
    // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
   // phpCAS::setNoCasServerValidation();
   // phpCAS::forceAuthentication();
    // check CAS authentication
   // $auth = phpCAS::checkAuthentication();
//    if ($auth == true) {
  //    echo "AUTHENTICATED! With User: "+phpCAS::getUser();
      echo "PHPCAS Version = "+phpCAS::getVersion();
    //}
   // else {
     // echo "Authentication Failed";
    //}
  }

  public function casLogout(){
    // For quick testing you can disable SSL validation of the CAS server.
    // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
    // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
   // phpCAS::setNoCasServerValidation();
    //phpCAS::logout();
    // check CAS authentication
    //$auth = phpCAS::checkAuthentication();
  }
}
