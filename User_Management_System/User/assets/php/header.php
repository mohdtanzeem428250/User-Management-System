<?php
require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= ucfirst(basename($_SERVER['PHP_SELF'],'.php')); ?> | Dashboard</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Maven+Pro:400,500,600,700,800,900&display=swap');
		*
		{
			font-family: 'Maven Pro',sans-serif;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a href="index.php" class="navbar-brand"><i class="fas fa-code fa-lg"></i>&nbsp;&nbsp;User Management System</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collpase navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"> 
					<a href="home.php" class="nav-link <?= (basename($_SERVER['PHP_SELF'])=="home.php") ? "active" : ""; ?> "><i class="fas fa-home"></i>&nbsp;Home</a>
				</li>
				<li class="nav-item"> 
					<a href="profile.php" class="nav-link <?= (basename($_SERVER['PHP_SELF'])=="profile.php") ? "active" : ""; ?> "><i class="fas fa-user-circle"></i>&nbsp;Profile</a>
				</li>
				<li class="nav-item"> 
					<a href="feedback.php" class="nav-link <?= (basename($_SERVER['PHP_SELF'])=="feedback.php") ? "active" : ""; ?> "><i class="fas fa-comment-dots"></i>&nbsp;Feedback</a>
				</li>
				<li class="nav-item"> 
					<a href="notification.php" class="nav-link <?= (basename($_SERVER['PHP_SELF'])=="notification.php") ? "active" : ""; ?> "><i class="fas fa-bell"></i>&nbsp;Notification&nbsp;<span id="checkNotification"></span></a>
				</li>
				<li class="nav-item dropdown"> 
					<a href="#" class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown"><i class="fas fa-user-cog"></i>&nbsp;Hi! <?php echo $firstName; ?></a>
					<div class="dropdown-menu">
						<a href="#" class="dropdown-item"><i class="fas fa-cog"></i>&nbsp;Setting</a>
						<a href="assets/php/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</body>
</html>