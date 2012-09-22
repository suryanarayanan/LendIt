<?php

// Get these from http://developers.facebook.com
$api_key = '422128541181076';
$secret  = '16a32a398469d4003043a75116747cde';

include_once '../facebook/php/facebook.php';

$facebook = new Facebook($api_key, $secret);
$user = $facebook->require_login();

?>

<h1>Friends list demo</h1>
Hello <fb:name uid='<?php echo $user; ?>' useyou='false' possessive='true' />! <br>
Your id : <?php echo $user; ?>.

You have several friends:<br>
<?
$friends = $facebook->api_client->friends_get();
?>

<ul>
<?
foreach($friends as $friend){
	echo "<li><fb:name uid=\"$friend\" useyou=\"false\"></li>";	
}
?>
</ul>
