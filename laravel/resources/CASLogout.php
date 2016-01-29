<?php

require_once 'CASAuthentication/config.php';
// Load the CAS lib
require_once $phpcas_path . '/CAS.php';

  // Initialize phpCAS
  phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);


    // For quick testing you can disable SSL validation of the CAS server.
    // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
    // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
    phpCAS::setNoCasServerValidation();
    phpCAS::logout();
    // check CAS authentication
    $auth = phpCAS::checkAuthentication();
