
<!--
Logout.php basically has a php code segment to carry out the logout functionality all across the website. 
It is achieved using session_destroy() method.
Logout.php is linked to the Signout link on every web page that have the sign out option in the dropdown of username in the navigation bar.
-->


<?php
	session_start();
	session_destroy();
	unset($_SESSION['username']);
	$_SESSION['message']="You are now logged out!";
	header("location:guestHome.php");
	
?>
