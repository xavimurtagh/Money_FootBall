<?php
// site root
define('SITE_ROOT', '');
define('PROJECT_INC', 'project-include');
define('PROJECT_LAYOUT', 'project-layout');
defined('ABSPATH') ? ABSPATH : define('ABSPATH', dirname(__FILE__) . '/'); 

// importing functions php-->
require_once(ABSPATH.'/functions.php');

// getting every php file in folder
foreach (glob(ABSPATH . PROJECT_INC . '/' . '*.php') as $filename) {
    require_once $filename;
}

// gives every user a unique token
global $session;
if (!isset($_SESSION["token"]) || $_SESSION["token"] == '') {
    $_SESSION["token"] = md5(rand(0, 10000000));
}

// gets the userid
if (isset($session->userId)) {
    $loggedInUserObj           = User::findById($session->userId);
	
    // status 'verification_pending'=>'-1', 'deactivated' => '0', 'activated' => '1','pending'=>'2','expired' => '3'

    // returns trailing name component of path	
	$basename  = basename($_SERVER["PHP_SELF"]);
}

// checks if variable is set and if nothing was submitted
if (isset($_POST) && !empty($_POST)) {
    foreach ($_POST as $key => $val) {
        // strip_tags(string,allow)
        if (!is_array($val)) {
            $_POST[$key] = strip_tags($val, '<a><br><br />');
        }
    }
}
if(isset($session->userId)) {
    $loggedInUserObj  = User::findById($session->userId);
}