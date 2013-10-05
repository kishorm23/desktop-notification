<html>
<body><?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('inc/facebook.php');
require_once('config.php');

  $facebook = new Facebook($config);
$params = array(
  'scope' => 'read_stream, friends_likes, manage_notifications, read_mailbox, email',
  'redirect_uri' => 'http://localhost/logged.php'
);

$loginUrl = $facebook->getLoginUrl($params);
header("Location: $loginUrl");
?>
</body>
</html>