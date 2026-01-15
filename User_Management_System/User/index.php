<?php
session_start();
if(isset($_SESSION['user']))
{
	header('location:home.php');
}
include_once 'assets/php/connection.php';
$objectDatabase=new Database();
$updateVisitors="UPDATE tbl_visitors SET hits=hits+1 WHERE id='1'";
$statementUpdate=$objectDatabase->con->prepare($updateVisitors);
$statementUpdate->execute();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Management System</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center wrapper" id="login-box">
			<div class="col-lg-10 my-auto">
				<div class="card-group myShadow">
					<div class="card rounded-left p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-center">Sign In To Account</h1>
						<hr class="my-3">
						<form action="" method="POST" class="px-3" id="login-form">
							<div id="loginAlert"></div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg"></i></span>
								</div>
								<input type="email" name="email" id="email" class="form-control rounded-0" placeholder="Enter The Email" required value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>">
							</div>

							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="fas fa-key fa-lg"></i></span>
								</div>
								<input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Enter The Password" required value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>">
							</div>

							<div class="form-group">
								<div class="custom-control custom-checkbox float-left">
									<input type="checkbox" name="remember" class="custom-control-input" id="customCheck" <?php if(isset($_COOKIE['email'])) { ?> checked <?php } ?> >
									<label class="custom-control-label" for="customCheck">Remember Me</label>
								</div>
								<div class="forgot float-right">
									<a href="#" id="forgot-link">Forgot Password</a>
								</div>
								<div class="clearfix"></div>
							</div>

							<div class="form-group">
								<input type="submit" value="Sign In" id="login-btn" class="btn btn-primary btn-lg btn-block myBtn">
							</div>
						</form>
					</div>
					<div class="card justify-content-center rounded-right myColor p-4">
						<h1 class="text-center font-weight-bold text-white">Hello Friends!</h1>
						<hr class="my-3 bg-light myHr">
						<p class="text-center font-weight-bold text-light lead">Enter Your Personal Details And Start Your Journey With Us!</p>
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bold mt-4 myLinkBtn" id="register-link">Sign Up</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center wrapper" id="register-box" style="display: none;">
			<div class="col-lg-10 my-auto">
				<div class="card-group myShadow">
					<div class="card justify-content-center rounded-left myColor p-4">
						<h1 class="text-center font-weight-bold text-white">Welcome Back!</h1>
						<hr class="my-3 bg-light myHr">
						<p class="text-center font-weight-bold text-light lead">To Keep Connected With Us Please Login With Your Personal Information!</p>
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bold mt-4 myLinkBtn" id="login-link">Sign In</button>
					</div>
					<div class="card rounded-right p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-center">Create Account</h1>
						<hr class="my-3">
						<form action="" method="POST" class="px-3" id="register-form">
							<div id="regAlert"></div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="far fa-user fa-lg"></i></span>
								</div>
								<input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Enter Your Full Name" required>
							</div>

							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg"></i></span>
								</div>
								<input type="email" name="email" id="remail" class="form-control rounded-0" placeholder="Enter The Email" required>
							</div>

							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="fas fa-key fa-lg"></i></span>
								</div>
								<input type="password" name="password" id="rpassword" class="form-control rounded-0" placeholder="Enter The password" required minlength="8">
							</div>

							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="fas fa-key fa-lg"></i></span>
								</div>
								<input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Enter The Confirm password" required minlength="8">
							</div>

							<div class="form-group">
								<div id="passError" class="text-danger font-weight-bold"></div>
							</div>

							<div class="form-group">
								<input type="submit" value="Sign Up" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center wrapper" id="forgot-box" style="display: none;">
			<div class="col-lg-10 my-auto">
				<div class="card-group myShadow">
					<div class="card justify-content-center rounded-left myColor p-4">
						<h1 class="text-center font-weight-bold text-white">Reset Password!</h1>
						<hr class="my-3 bg-light myHr">
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bold mt-4 myLinkBtn" id="back-link">Back</button>
					</div>
					<div class="card rounded-right p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-center">Forgot Your Password</h1>
						<hr class="my-3">
						<p class="lead text-center text-secondary">To Reset Your Password, Enter The Registered Email Address And We Will Send You The Reset Instructions On Your Email!</p>
						<form action="" method="POST" class="px-3" id="forgot-form">
							<div id="forgotAlert"></div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0"><i class="far fa-envelope fa-lg"></i></span>
								</div>
								<input type="email" name="email" id="femail" class="form-control rounded-0" placeholder="Enter The Email" required>
							</div>

							<div class="form-group">
								<input type="submit" value="Reset Password" id="forgot-btn" class="btn btn-primary btn-lg btn-block myBtn">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>		

	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#register-link").click(function()
			{
				$("#login-box").hide();
				$("#register-box").show();
			});
			$("#login-link").click(function()
			{
				$("#login-box").show();
				$("#register-box").hide();
			});
			$("#forgot-link").click(function()
			{
				$("#login-box").hide();
				$("#forgot-box").show();
			});
			$("#back-link").click(function()
			{
				$("#forgot-box").hide();
				$("#login-box").show();
			});
			$("#register-btn").click(function(e)
			{
				if($("#register-form")[0].checkValidity())
				{
					e.preventDefault();
					$("#register-btn").val('Please Wait...');
					if($('#rpassword').val()!=$("#cpassword").val())
					{
						$("#passError").text('Password Did Not Matched!');
						$("#register-btn").val('Sign Up');
					}
					else
					{
						$("#passError").text('');
						$.ajax(
						{
							url:'assets/php/action.php',
							method:'POST',
							data: $("#register-form").serialize()+'&action=register',
							success:function(response)
							{
								$("#register-btn").val('Sign Up');
								if(response=='Register')
								{
									window.location='home.php';
								}
								else
								{
									$("#regAlert").html(response);
								}
							}
						})
					}
				}
			});
			$("#login-btn").click(function(e)
			{
				if($("#login-form")[0].checkValidity())
				{
					e.preventDefault();
					$("#login-btn").val('Please Wait...');
					$.ajax(
					{
						url:'assets/php/action.php',
						method:'POST',
						data:$("#login-form").serialize()+'&action=login',
						success:function(response)
						{
							$("#login-btn").val('Sign In');
							console.log(response);
							if(response==='Login')
							{
								window.location='home.php';
							}
							else
							{
								$("#loginAlert").html(response);
							}
						}
					});
				}
			});
			$("#forgot-btn").click(function(e)
			{
				if($("#forgot-form")[0].checkValidity())
				{
					e.preventDefault();
					$("#forgot-btn").val('Please Wait...');
					$.ajax(
					{
						url:'assets/php/action.php',
						method:'POST',
						data:$("#forgot-form").serialize()+'&action=forgot',
						success:function(response)
						{
							$("#forgot-btn").val('Reset Password');
							$("#forgot-form")[0].reset();
							$("#forgotAlert").html(response);
						}
					});
				}
			});
		});
	</script>

</body>
</html>