<?php
require_once('inc/facebook.php');
require_once('config.php');
$facebook = new Facebook($config);
echo "Access Token: ".$facebook->getAccessToken();
?>
