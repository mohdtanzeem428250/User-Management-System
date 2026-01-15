<?php
require_once 'assets/php/session.php';
if(isset($_GET['email']))
{
	$email=$_GET['email'];
	$cuser->verifyEmail($email);
	header('location:profile.php');
	exit();
}
else
{
	header('location:index.php');
	exit();
}
?>
