<?php

require_once '../resources/CASVerify.php';
if($auth == true || $_SESSION['AUTH'] == true) {
	$_SESSION['AUTH'] = true;
}
else {
	$_SESSION['AUTH'] = false;
}
echo $_SESSION['AUTH'];