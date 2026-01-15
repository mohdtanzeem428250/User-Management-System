<?php
session_start();
require_once 'auth.php';
$cuser=new Auth();
if(!isset($_SESSION['user']))
{
	header('location:index.php');
	die();
}
$cemail=$_SESSION['user'];
$data=$cuser->currentUser($cemail);
$id=$data['id'];
$name=$data['name'];
$email=$data['email'];
$password=$data['password'];
$mobile=$data['phone'];
$gender=$data['gender'];
$dateOfBirth=$data['dob'];
$image=$data['photo'];
$date=$data['created_at'];
$status=$data['verified'];

$registeredDate=date('d M Y',strtotime($date));

$firstName=strtok($name, " ");

if($status==0)
{
	$status='Not Varified!';
}
else
{
	$status='Verified!';
}

?>
