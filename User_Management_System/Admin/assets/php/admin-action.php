<?php
session_start();
require_once 'admin-db.php';
require_once 'config.php';
$admin=new Admin();

if(isset($_POST['action']) && $_POST['action']=='adminLogin')
{
	$username=$admin->test_input($_POST['username']);
	$password=$admin->test_input($_POST['password']);
	$hashPassword=sha1($password);
	$loggedInAdmin=$admin->adminLogin($username,$hashPassword);
	if($loggedInAdmin!=null)
	{
		echo 'admin_login';
		$_SESSION['username']=$username;
	}
	else
	{
		echo $admin->showMessage('danger','Username Or Password Is Incorrect!');
	}
}

if(isset($_POST['action']) && $_POST['action']=='fetchAllUsers')
{
	$output='';
	$data=$admin->fetchAllUsers(0);
	$path="../User/assets/php/";
	if($data)
	{
		$output .= '<table class="table table-striped table-bordered text-center">
						<thead>
							<tr>
								<th>Serial No.</th>
								<th>Image</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Gender</th>
								<th>Verified</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
						$serial=1;
						foreach($data as $row)
						{
							if($row['photo']!='')
							{
								$uploads=$path.$row['photo'];
							}
							else
							{
								$uploads='../User/assets/img/default-user.webp';
							}
							if($row['verified']==0)
							{
								$statusVerified='Unverified';
							}
							else
							{
								$statusVerified='Verified';
							}
							$output .= '<tr>
											<td>'.$serial++.'</td>
											<td><img src="'.$uploads.'" class="rounded-circle" width="40px"></td>
											<td>'.$row['name'].'</td>
											<td>'.$row['email'].'</td>
											<td>'.$row['phone'].'</td>
											<td>'.$row['gender'].'</td>
											<td>'.$statusVerified.'</td>
											<td>
<a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

												<a href="#" id="'.$row['id'].'" title="Delete User" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-lg"></i></a>
											</td>
										</tr>';
						}
						$output .= '
						</tbody>
					</table>';
				echo $output;
	}
	else
	{
		echo '<h3 class="text-center text-secondary">:(No Any Users Registered Yet!</h3>';
	}
}

if(isset($_POST['detailsId']))
{
	$id=$_POST['detailsId'];
	$data=$admin->fetchUserDetailsById($id);
	echo json_encode($data);
}

if(isset($_POST['del_id']))
{
	$deleteId=$_POST['del_id'];
	$admin->userAction($deleteId,0);
}


if(isset($_POST['action']) && $_POST['action']=='fetchAllDeletedUsers')
{
	$output='';
	$data=$admin->fetchAllUsers(1);
	$path="../User/assets/php/";
	if($data)
	{
		$output .= '<table class="table table-striped table-bordered text-center">
						<thead>
							<tr>
								<th>Serial No.</th>
								<th>Image</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Gender</th>
								<th>Verified</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
						$serial=1;
						foreach($data as $row)
						{
							if($row['photo']!='')
							{
								$uploads=$path.$row['photo'];
							}
							else
							{
								$uploads='../User/assets/img/default-user.webp';
							}
							if($row['verified']==0)
							{
								$statusVerified='Unverified';
							}
							else
							{
								$statusVerified='Verified';
							}
							$output .= '<tr>
											<td>'.$serial++.'</td>
											<td><img src="'.$uploads.'" class="rounded-circle" width="40px"></td>
											<td>'.$row['name'].'</td>
											<td>'.$row['email'].'</td>
											<td>'.$row['phone'].'</td>
											<td>'.$row['gender'].'</td>
											<td>'.$statusVerified.'</td>
											<td>

												<a href="#" id="'.$row['id'].'" title="Restore User" class="text-white restoreUserIcon badge badge-dark p-2">Restore</a>
											</td>
										</tr>';
						}
						$output .= '
						</tbody>
					</table>';
				echo $output;
	}
	else
	{
		echo '<h3 class="text-center text-secondary">:(No Any Deleted Users Yet!</h3>';
	}
}

if(isset($_POST['resId']))
{
	$restoreId=$_POST['resId'];
	$admin->userAction($restoreId,1);
}

if(isset($_POST['action']) && $_POST['action']=='fetchAllNotes')
{
	$output='';
	$note=$admin->fetchAllNotes();
	$path="../User/assets/php/";
	if($note)
	{
		$output .= '<table class="table table-striped table-bordered text-center">
						<thead>
							<tr>
								<th>User ID</th>
								<th>Username</th>
								<th>Email</th>
								<th>Note Title</th>
								<th>Note</th>
								<th>Written On</th>
								<th>Updated On</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
						$serial=1;
						foreach($note as $row)
						{
							$output .= '<tr>
											<td>'.$row['id'].'</td>
											<td>'.$row['name'].'</td>
											<td>'.$row['email'].'</td>
											<td>'.$row['title'].'</td>
											<td>'.$row['notes'].'</td>
											<td>'.$row['created_at'].'</td>
											<td>'.$row['updated_at'].'</td>
											<td>

												<a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteNoteIcon"><i class="fas fa-trash-alt fa-lg"></i></a>
											</td>
										</tr>';
						}
						$output .= '
						</tbody>
					</table>';
				echo $output;
	}
	else
	{
		echo '<h3 class="text-center text-secondary">:(No Any Notes Written Yet!</h3>';
	}
}

if(isset($_POST['note_id']))
{
	$noteId=$_POST['note_id'];
	$admin->deleteNoteUser($noteId);
}

if(isset($_POST['action']) && $_POST['action']=='fetchAllFeedback')
{
	$output='';
	$feedback=$admin->fetchFeedback();
	$path="../User/assets/php/";
	if($feedback)
	{
		$output .= '<table class="table table-striped table-bordered text-center">
						<thead>
							<tr>
								<th>FID</th>
								<th>UID</th>
								<th>Username</th>
								<th>Email</th>
								<th>Subject</th>
								<th>Feedback</th>
								<th>Send On</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
						$serial=1;
						foreach($feedback as $row)
						{
							$output .= '<tr>
											<td>'.$row['id'].'</td>
											<td>'.$row['uid'].'</td>
											<td>'.$row['name'].'</td>
											<td>'.$row['email'].'</td>
											<td>'.$row['subject'].'</td>
											<td>'.$row['feedback'].'</td>
											<td>'.$row['created_at'].'</td>
											<td>

												<a href="#" fid="'.$row['id'].'" id="'.$row['uid'].'" title="Reply" class="text-primary replyFeedbackIcon" data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply fa-lg"></i></a>
											</td>
										</tr>';
						}
						$output .= '
						</tbody>
					</table>';
				echo $output;
	}
	else
	{
		echo '<h3 class="text-center text-secondary">:(No Any Feedback Written Yet!</h3>';
	}
}

if(isset($_POST['message']))
{
	$uid=$_POST['uid'];
	$fid=$_POST['fid'];
	$message=$admin->test_input($_POST['message']);
	$admin->replyFeedback($uid,$message);
	$admin->feedbackReplied($fid);
}

if(isset($_POST['action']) && $_POST['action']=='fetchNotification')
{
	$notification=$admin->fetchNotification();
	$output='';
	if($notification)
	{
		foreach($notification as $rows)
		{
			$output.='<div class="alert alert-dark" role="alert">
					<button type="button" id="'.$rows['id'].'" class="close" data-dismiss="alert" aria-label="close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="alert-heading">New Notification</h4>
					<p class="mb-0 lead">'.$rows['message'].' By '.$rows['name'].'</p>
					<hr class="my-2">
					<p class="mb-0 float-left"><b>User Email :- '.$rows['email'].'</b></p>
						<p class="mb-0 float-right">'.$admin->timeInAgo($rows['created_at']).'</p>
						<div class="clearfix"></div>
					</div>';
		}
		echo $output;
	}
	else
	{
		echo '<h3 class="text-center text-secondary mt-5">No Any New Notification Yet!</h3>';
	}
}

if(isset($_POST['action']) && $_POST['action']=='checkNotification')
{
	if($admin->fetchNotification())
	{
		echo '<i class="fas fa-circle text-danger fa-sm"></i>';
	}
	else
	{
		echo '';
	}
}

if(isset($_POST['notification_id']))
{
	$notificationId=$_POST['notification_id'];
	$admin->removeNotification($notificationId);
}

if(isset($_GET['export']) && $_GET['export']=='excel')
{
	header("Content-Type: application/xls");
	header("Content-Disposition: attachment; filename=users.xls");
	header("pragma: no-cache");
	header("Expires: 0");
	$data=$admin->exportAllUsers();
	echo '<table border="1" align=center>';
	echo '<tr>
			<th>Serial Number</th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Gender/th>
			<th>Date Of Birth</th>
			<th>Joined On</th>
			<th>Verified</th>
			<th>Deleted</th>
		  </tr>';
		foreach($data as $rows)
		{
			echo '<tr>
					<td>'.$rows['id'].'</tr>
					<td>'.$rows['name'].'</tr>
					<td>'.$rows['email'].'</tr>
					<td>'.$rows['phone'].'</tr>
					<td>'.$rows['gender'].'</tr>
					<td>'.$rows['dob'].'</tr>
					<td>'.$rows['created_at'].'</tr>
					<td>'.$rows['verified'].'</tr>
					<td>'.$rows['deleted'].'</tr>
				  </tr>';
		}
	echo '</table>';
}

?>