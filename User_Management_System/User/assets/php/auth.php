<?php
require_once 'connection.php';
class Auth extends Database
{
	public function registerUser($name,$email,$password)
	{
		$insertNewUser="INSERT INTO users(name,email,password) VALUES(:name,:email,:password)";
		$statementUser=$this->con->prepare($insertNewUser);
		$statementUser->execute(['name'=>$name,'email'=>$email,'password'=>$password]);
		return true;
	}

	public function isUserExists($email)
	{
		$userExists="SELECT * FROM users WHERE email=:email";
		$statementExists=$this->con->prepare($userExists);
		$statementExists->execute(['email'=>$email]);
		$ifUserExists=$statementExists->fetch(PDO::FETCH_ASSOC);
		return $ifUserExists;
	}

	public function login($email)
	{
		$loginCompare="SELECT email,password FROM users WHERE email=:email AND deleted != 0";
		$statementIsUser=$this->con->prepare($loginCompare);
		$statementIsUser->execute(['email'=>$email]);
		$rowsMatched=$statementIsUser->fetch(PDO::FETCH_ASSOC);
		return $rowsMatched;
	}

	public function currentUser($email)
	{
		$currentQuery="SELECT * FROM users WHERE email=:email AND deleted != 0";
		$statementUser=$this->con->prepare($currentQuery);
		$statementUser->execute(['email'=>$email]);
		$rowsIsMatched=$statementUser->fetch(PDO::FETCH_ASSOC);
		return $rowsIsMatched;
	}

	public function forgotPassword($token,$email)
	{
		$forgotPasswordQuery="UPDATE users SET token=:token, token_expire=DATE_ADD(NOW(),INTERVAL 10 MINUTE) WHERE email=:email";
		$statementForgotPassword=$this->con->prepare($forgotPasswordQuery);
		$statementForgotPassword->execute(['token'=>$token,'email'=>$email]);
		return true;
	}

	public function resetPassword($email,$token)
	{
		$resetSqlQuery="SELECT id FROM users WHERE email=:email AND token=:token AND token != '' AND token_expire > NOW() AND deleted != 0 ";
		$statementResetPassword=$this->con->prepare($resetSqlQuery);
		$statementResetPassword->execute(['email'=>$email,'token'=>$token]);
		$rowResetPassword=$statementResetPassword->fetch(PDO::FETCH_ASSOC);
		return $rowResetPassword;
	}

	public function updatePassword($password, $email)
	{
		$updateSqlQuery="UPDATE users SET token='', password=:password WHERE email=:email AND deleted!=0";
		$statementUpdatePassword=$this->con->prepare($updateSqlQuery);
		$statementUpdatePassword->execute(['password'=>$password,'email'=>$email]);
		return true;
	}

	public function addNewNotes($uid,$title,$note)
	{
		$addNewNotes="INSERT INTO tbl_notes(uid,title,notes) VALUES(:uid,:title,:note)";
		$statementAddNewNotes=$this->con->prepare($addNewNotes);
		$statementAddNewNotes->execute(['uid'=>$uid,'title'=>$title,'note'=>$note]);
		return true;
	}

	public function getAllNote($uid)
	{
		$getAllNote="SELECT * FROM tbl_notes WHERE uid=:uid";
		$statementGetNotes=$this->con->prepare($getAllNote);
		$statementGetNotes->execute(['uid'=>$uid]);
		$rowsNotes=$statementGetNotes->fetchAll(PDO::FETCH_ASSOC);
		return $rowsNotes;
	}

	public function updateNotes($id)
	{
		$updateNotes="SELECT * FROM tbl_notes WHERE id=:id";
		$statementUpdateNotes=$this->con->prepare($updateNotes);
		$statementUpdateNotes->execute(['id'=>$id]);
		$rowFetch=$statementUpdateNotes->fetch(PDO::FETCH_ASSOC);
		return $rowFetch;
	}

	public function updateQuery($id,$title,$note)
	{
		$updateQuery="UPDATE tbl_notes SET title=:title, notes=:notes, updated_at=NOW() WHERE id=:id";
		$statementUpdate=$this->con->prepare($updateQuery);
		$statementUpdate->execute(['title'=>$title,'notes'=>$note,'id'=>$id]);
		return true;
	}

	public function deleteNotes($id)
	{
		$deleteNotes="DELETE FROM tbl_notes WHERE id=:id";
		$statementDeleted=$this->con->prepare($deleteNotes);
		$statementDeleted->execute(['id'=>$id]);
		return true;
	}

	public function infoUserDetails($id)
	{
		$infoDetails="SELECT * FROM tbl_notes WHERE id=:id";
		$statementInfo=$this->con->prepare($infoDetails);
		$statementInfo->execute(['id'=>$id]);
		$userInfo=$statementInfo->fetch(PDO::FETCH_ASSOC);
		return $userInfo;
	}

	public function updateProfile($name,$gender,$dob,$phone,$photo,$id)
	{
		$updateProfileQuery="UPDATE users SET name=:name, gender=:gender, dob=:dob, phone=:phone, photo=:photo WHERE id=:id";
		$statementUpdateQuery=$this->con->prepare($updateProfileQuery);
		$statementUpdateQuery->execute(['name'=>$name,'gender'=>$gender,'dob'=>$dob,'phone'=>$phone,'photo'=>$photo,'id'=>$id]);
		return true;
	}

	public function changePassword($password,$id)
	{
		$updatePasswordQuery="UPDATE users SET password=:password WHERE id=:id AND deleted != 0";
		$statementPasswordQuery=$this->con->prepare($updatePasswordQuery);
		$statementPasswordQuery->execute(['password'=>$password,'id'=>$id]);
		return true;
	}

	public function verifyEmail($email)
	{
		$verifyEmailId="UPDATE users SET verified=1 WHERE email=:email AND deleted != 0";
		$statementVerify=$this->con->prepare($verifyEmailId);
		$statementVerify->execute(['email'=>$email]);
		return true;
	}

	public function insertFeedback($subject,$feedback,$id)
	{
		$insertFeedbackQuery="INSERT INTO tbl_feedback(uid,subject,feedback) VALUES(:uid,:subject,:feedback)";
		$statementInsert=$this->con->prepare($insertFeedbackQuery);
		$statementInsert->execute(['uid'=>$id,'subject'=>$subject,'feedback'=>$feedback]);
		return true;
	}

	public function insertNotification($uid,$type,$message)
	{
		$insertNotificationQuery="INSERT INTO tbl_notification(uid,type,message) VALUES(:uid,:type,:message)";
		$statementInsertNotification=$this->con->prepare($insertNotificationQuery);
		$statementInsertNotification->execute(['uid'=>$uid,'type'=>$type,'message'=>$message]);
		return true;
	}

	public function fetchNotifications($id)
	{
		$selectNotifications="SELECT * FROM tbl_notification WHERE uid=:uid";
		$statementNotification=$this->con->prepare($selectNotifications);
		$statementNotification->execute(['uid'=>$id]);
		$rowNotification=$statementNotification->fetchAll(PDO::FETCH_ASSOC);
		return $rowNotification;
	}

	public function deleteNotification($id)
	{
		$deleteNotification="DELETE FROM tbl_notification WHERE id=:id";
		$deleteNotification=$this->con->prepare($deleteNotification);
		$deleteNotification->execute(['id'=>$id]);
		return true;
	}

}
?>