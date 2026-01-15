<?php
require_once 'config.php';
class Admin extends Database
{
	public function adminLogin($username,$password)
	{
		$selectAdmin="SELECT username,password FROM admin WHERE username=:username AND password=:password";
		$statementAdmin=$this->con->prepare($selectAdmin);
		$statementAdmin->execute(['username'=>$username,'password'=>$password]);
		$adminRows=$statementAdmin->fetch(PDO::FETCH_ASSOC);
		return $adminRows;
	}

	public function totalCount($tableName)
	{
		$selectQuery="SELECT * FROM $tableName";
		$statementUser=$this->con->prepare($selectQuery);
		$statementUser->execute();
		$rowsUser=$statementUser->rowCount();
		return $rowsUser;
	}

	public function totalVerified($tableName,$status)
	{
		$selectQuery="SELECT * FROM $tableName WHERE verified=:verified";
		$statementVerifiedUser=$this->con->prepare($selectQuery);
		$statementVerifiedUser->execute(['verified'=>$status]);
		$rowsUser=$statementVerifiedUser->rowCount();
		return $rowsUser;
	}

	public function genderPercentage()
	{
		$selectGenderQuery="SELECT gender, COUNT(*) AS number FROM users WHERE gender != '' GROUP BY gender";
		$statementGender=$this->con->prepare($selectGenderQuery);
		$statementGender->execute();
		$rowsGender=$statementGender->fetchAll(PDO::FETCH_ASSOC);
		return $rowsGender;
	}

	public function verifiedPercentage()
	{
		$selectVerifiedQuery="SELECT verified, COUNT(*) AS number FROM users GROUP BY verified";
		$statementVerified=$this->con->prepare($selectVerifiedQuery);
		$statementVerified->execute();
		$rowsVerified=$statementVerified->fetchAll(PDO::FETCH_ASSOC);
		return $rowsVerified;
	}

	public function totalHitsUsers()
	{
		$selectHits="SELECT hits FROM tbl_visitors";
		$statementHits=$this->con->prepare($selectHits);
		$statementHits->execute();
		$hitCounts=$statementHits->fetch(PDO::FETCH_ASSOC);
		return $hitCounts;
	}

	public function fetchAllUsers($values)
	{
		$selectAllUsers="SELECT *FROM users WHERE deleted != $values";
		$statementUsers=$this->con->prepare($selectAllUsers);
		$statementUsers->execute();
		$rowUsers=$statementUsers->fetchAll(PDO::FETCH_ASSOC);
		return $rowUsers;
	}

	public function fetchUserDetailsById($id)
	{
		$selectUserDetails="SELECT * FROM users WHERE id=:id AND deleted != 0";
		$statementUserDetails=$this->con->prepare($selectUserDetails);
		$statementUserDetails->execute(['id'=>$id]);
		$rowUserDetails=$statementUserDetails->fetch(PDO::FETCH_ASSOC);
		return $rowUserDetails;
	}

	public function userAction($id,$val)
	{
		$updateUserAction="UPDATE users SET deleted=:val WHERE id=:id";
		$statementUpdate=$this->con->prepare($updateUserAction);
		$statementUpdate->execute(['id'=>$id,'val'=>$val]);
		return true;
	}

	public function fetchAllNotes()
	{
		$selectNoted="SELECT notes.id, notes.title, notes.notes, notes.created_at, notes.updated_at, users.name, users.email FROM tbl_notes AS notes INNER JOIN users ON notes.uid=users.id";
	$statementNotes=$this->con->prepare($selectNoted);
	$statementNotes->execute();
	$rowResult=$statementNotes->fetchAll(PDO::FETCH_ASSOC);
	return $rowResult;
	}

	public function deleteNoteUser($id)
	{
		$deleteNotesAction="DELETE FROM tbl_notes WHERE id=:id";
		$statementDelete=$this->con->prepare($deleteNotesAction);
		$statementDelete->execute(['id'=>$id]);
		return true;
	}

	public function fetchFeedback()
	{
		$selectFeedbacks="SELECT feedback.id, feedback.subject, feedback.feedback, feedback.created_at, feedback.uid, users.name, users.email FROM tbl_feedback AS feedback INNER JOIN users ON feedback.uid=users.id WHERE replied!=1 ORDER BY feedback.id DESC";
		$statementFeedback=$this->con->prepare($selectFeedbacks);
		$statementFeedback->execute();
		$rowsFeedback=$statementFeedback->fetchAll(PDO::FETCH_ASSOC);
		return $rowsFeedback;
	}

	public function replyFeedback($uid,$message)
	{
		$insertReply="INSERT INTO tbl_notification(uid,type,message) VALUES(:uid,'user',:message)";
		$statementReply=$this->con->prepare($insertReply);
		$statementReply->execute(['uid'=>$uid,'message'=>$message]);
		return true;
	}

	public function feedbackReplied($fid)
	{
		$updateFeedbackReplied="UPDATE tbl_feedback SET replied=:val WHERE id=:fid";
		$statementRepliedUpdate=$this->con->prepare($updateFeedbackReplied);
		$statementRepliedUpdate->execute(['fid'=>$fid,'val'=>1]);
		return true;
	}

	public function fetchNotification()
	{
		$selectnotifications="SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM tbl_notification AS notification INNER JOIN users ON notification.uid=users.id WHERE type='admin' ORDER BY notification.id DESC LIMIT 5";
		$statementNotification=$this->con->prepare($selectnotifications);
		$statementNotification->execute();
		$rowsNotification=$statementNotification->fetchAll(PDO::FETCH_ASSOC);
		return $rowsNotification;
	}

	public function removeNotification($id)
	{
		$selectRemoveNotification="DELETE FROM tbl_notification WHERE id=:id AND type='admin'";
		$statementRemoveNotification=$this->con->prepare($selectRemoveNotification);
		$statementRemoveNotification->execute(['id'=>$id]);
		return true;
	}

	public function exportAllUsers()
	{
		$selectAllUsers="SELECT * FROM users";
		$statementUser=$this->con->prepare($selectAllUsers);
		$statementUser->execute();
		$rowAllUsers=$statementUser->fetchAll(PDO::FETCH_ASSOC);
		return $rowAllUsers;
	}
}

?>