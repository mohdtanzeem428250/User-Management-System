<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'vendor/autoload.php';
require_once 'auth.php';
$user=new Auth();
if(isset($_POST['action']) && $_POST['action']=='register')
{
	$name=$user->test_input($_POST['name']);
	$email=$user->test_input($_POST['email']);
	$password=$user->test_input($_POST['password']);
	$hashPassword=password_hash($password, PASSWORD_DEFAULT);
	if($user->isUserExists($email))
	{
		echo $user->showMessage('warning','This Email Is Already Registered!');
	}
	else
	{
		if($user->registerUser($name,$email,$hashPassword))
		{
			echo 'Register';
			$_SESSION['user']=$email;
		}
		else
		{
			echo $user->showMessage('danger','Something Went Wrong! Try Again Later!');
		}
	}
}
if(isset($_POST['action']) && $_POST['action']=='login')
{
	$email=$user->test_input($_POST['email']);
	$password=$user->test_input($_POST['password']);
	$loggedInUser=$user->login($email);
	if($loggedInUser!=null)
	{
		if(password_verify($password, $loggedInUser['password']))
		{
			if(!empty($_POST['remember']))
			{
				setcookie("email",$email,time()+(30*24*60*60),'/');
				setcookie("password",$password,time()+(30*24*60*60),'/');
			}
			else
			{
				setcookie("email","",1,'/');
				setcookie("password","",1,'/');
			}
			$_SESSION['user']=$email;
			echo "Login";
		}
		else
		{
			echo $user->showMessage('danger','Password Is Incorrect!');
		}
	}
	else
	{
		echo $user->showMessage('danger','User Not Found!');
	}
}
if(isset($_POST['action']) && $_POST['action']=='forgot')
{
	$email=$user->test_input($_POST['email']);
	$userIsFound=$user->currentUser($email);
	if($userIsFound!=null)
	{
		$token=uniqid();
		$token=str_shuffle($token);
		$user->forgotPassword($token,$email);
		$mail=new PHPMailer(true);
		try
		{
			$mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='ecofriendlyshop.eco@gmail.com';
            $mail->Password='hnkp wjqx kunr zxba';
            $mail->SMTPSecure='tls';
            $mail->Port=587;
            $mail->setFrom('ecofriendlyshop.eco@gmail.com', 'User Management System');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject='Reset Password, User Management System';
            $mail->Body = '
<h3>Click the link below to reset your password:</h3>
<p>
<a href="http://localhost/User%20Management%20System/user/reset-password.php?email='.$email.'&token='.$token.'">
Reset Password
</a>
</p>
<p>Please do not share this link with anyone.</p>
<p>Regards,<br>User Management System Team</p>
';

            $mail->send();
            echo $user->showMessage('success','We Have Send You The Reset Link In Your Email Id, Please Check Your Email!');
		}
		catch(Exception $exception)
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
			// echo $user->showMessage('danger','Something Went Wrong Please Try Again Later!');
		}
	}
	else
	{
		echo $user->showMessage('danger','This Email Is Not Registered!');
	}
}

if(isset($_POST['action']) && $_POST['action']=='checkUser')
{
	if(!$user->currentUser($_SESSION['user']))
	{
		echo 'bye';
		unset($_SESSION['user']);
	}
}
?>