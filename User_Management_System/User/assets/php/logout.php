<?php
session_start();
require_once 'session.php';
$cuser->insertNotification($id,'Admin','Logout User');
unset($_SESSION['user']);
header('location:../../index.php');
?>