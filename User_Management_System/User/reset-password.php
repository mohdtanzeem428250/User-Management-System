<?php
require_once 'assets/php/auth.php';
$user=new Auth();
$message='';
if(isset($_GET['email']) && $_GET['token'])
{
	$email=$user->test_input($_GET['email']);
	$token=$user->test_input($_GET['token']);
	$authUsers=$user->resetPassword($email,$token);
	if($authUsers!=null)
	{
		if(isset($_POST['submit']))
		{
			$password=$_POST['password'];
			$confirmPassword=$_POST['cpassword'];
			$hashNewPassword=password_hash($password,PASSWORD_DEFAULT);
			if($password==$confirmPassword)
			{
				$user->updatePassword($hashNewPassword,$email);
				$message='Password Changed Successfully!<br><a href="index.php">Login Here!</a>';
			}
			else
			{
				$message='Password Did Not Matched!';
			}
		}
	}
	else
	{
		header('location:index.php');
		exit();
	}
}
else
{
	header('location:index.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Password</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center wrapper">
			<div class="col-lg-10 my-auto">
				<div class="card-group myShadow">
					<div class="card justify-content-center rounded-left myColor p-4">
						<h1 class="text-center font-weight-bold text-white">Reset Your Password Here!</h1>
					</div>
					<div class="card rounded-right p-4" style="flex-grow: 2;">
						<h1 class="text-center font-weight-bold text-center">Enter New Password</h1>
						<hr class="my-3">
						<form action="" method="POST" class="px-3">
							<div class="text-center lead mb-2"><?php echo $message; ?></div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="fas fa-key fa-lg"></i></span>
								</div>
								<input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Enter The New Password" required minlength="8">
							</div>

							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="fas fa-key fa-lg"></i></span>
								</div>
								<input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Enter The Confirm Password" required minlength="8">
							</div>

							<div class="form-group">
								<input type="submit" value="Reset Password" name="submit" class="btn btn-primary btn-lg btn-block myBtn">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</body>
</html>