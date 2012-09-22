<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>demo</title>
  </head>
<body>
Finally !!
<?php

// Get these from http://developers.facebook.com
include_once '../facebook/php/facebook.php';
$app_id = '422128541181076';
$secret  = '16a32a398469d4003043a75116747cde';
$facebook = new Facebook(array(
  'appId'  => $app_id,
  'secret' => $secret,
  'cookie' => false,
));

//$session = $facebook->getSession();
$friends = array();
$userData = null;

 {
    try {
         $uid = $facebook->getUser();      
         $me = $facebook->api('/me');
    }catch (FacebookApiException $e) {
   }
}

if ($me) {
	$logoutUrl = $facebook->getLogoutUrl();
	} else {
	$loginUrl = $facebook->getLoginUrl();
}

?>

<h1>Friends list demo</h1>
<?php if ($me): ?>
 <?php echo "Welcome, ".$me['first_name']. ".<br />"; ?>
	<a href="<?php echo $logoutUrl; ?>">
	      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
	    </a>
	    <?php else: ?>
	      <a href="<?php echo $loginUrl; ?>">
	        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
	 </a>
<?php endif ?>


<?
/*
$friends = $facebook->api_client->friends_get();
*/
?>

<ul>
<?
/*
foreach($friends as $friend){
	echo "<li><fb:name uid=\"$friend\" useyou=\"false\"></li>";	
}
*/
?>
</ul>

</body>

</html>
