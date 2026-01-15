<?php
require_once 'session.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'vendor/autoload.php';

if(isset($_POST['action']) && $_POST['action']=='addNote')
{
	$title=$cuser->test_input($_POST['title']);
	$note=$cuser->test_input($_POST['note']);
	$cuser->addNewNotes($id,$title,$note);
	$cuser->insertNotification($id,'Admin','Note Added');
}
if(isset($_POST['action']) && $_POST['action']=='display_notes')
{
	$output='';
	$serialNumber=1;
	$getNotes=$cuser->getAllNote($id);
	if($getNotes)
	{
		$output='
				<table id="notesTable" class="table table-bordered table-striped table-sm text-center">
    				<thead>
        				<tr>
            				<th class="text-center">Serial No.</th>
            				<th class="text-center">Title</th>
            				<th class="text-center">Notes</th>
            				<th class="text-center">Action</th>
        				</tr>
    				</thead>
    				<tbody>';
					foreach($getNotes as $rowsValues)
					{
    					$output .= '
    							<tr>
						        	<td>'.$serialNumber++.'</td>
						        	<td>'.$rowsValues['title'].'</td>
						        	<td>'.substr($rowsValues['notes'],0,75).'...</td>
						        	<td>
							            <a href="#" id="'.$rowsValues['id'].'" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>
							            <a href="#" id="'.$rowsValues['id'].'" class="text-primary editBtn" data-toggle="modal" data-target="#editNoteModal"><i class="fas fa-edit fa-lg"></i></a>
							            <a href="#" id="'.$rowsValues['id'].'" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
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
		echo '<h3 class="text-center text-secondary">:( You Have Not Written Any Note Yet! Write Your First Note Now!)</h3>';
	}
}

if(isset($_POST['edit_id']))
{
	$updateId=$_POST['edit_id'];
	$rowExist=$cuser->updateNotes($updateId);
	echo json_encode($rowExist);
}

if(isset($_POST['action']) && $_POST['action']=='update_note')
{
	$id=$cuser->test_input($_POST['id']);
	$title=$cuser->test_input($_POST['title']);
	$note=$cuser->test_input($_POST['note']);
	$cuser->updateQuery($id,$title,$note);
	$cuser->insertNotification($id,'Admin','Note Updated');
}

if(isset($_POST['del_id']))
{
	$deleted=$_POST['del_id'];
	echo $deleted;
	$cuser->deleteNotes($deleted);
	$cuser->insertNotification($id,'Admin','Note Deleted');
}

if(isset($_POST['info_id']))
{
	$infoId=$_POST['info_id'];
	$userData=$cuser->infoUserDetails($infoId);
	echo json_encode($userData);

}

if (isset($_FILES['image'])) {
    $name = $cuser->test_input($_POST['name']);
    $gender = $cuser->test_input($_POST['gender']);
    $dob = $cuser->test_input($_POST['dob']);
    $phone = $cuser->test_input($_POST['phone']);
    $oldImage = $cuser->test_input($_POST['oldimage']);
    $folder = "uploads/";

    // Check if an image is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Generate unique file name using timestamp
        $newImage = $folder . time() . "_" . $_FILES['image']['name'];

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $newImage)) {
            if ($oldImage != null) {
                unlink($oldImage); // Delete old image if it exists
            }
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        // If no new image is uploaded, use the old one
        $newImage = $oldImage;
    }

    // Update profile in the database
    $updateStatus = $cuser->updateProfile($name, $gender, $dob, $phone, $newImage, $id);
    $cuser->insertNotification($id,'Admin','Profile Updated');

    if ($updateStatus) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile.";
    }
}

if(isset($_POST['action']) && $_POST['action']=='change_password')
{
	$oldPass=$cuser->test_input($_POST['curpass']);
	$newPass=$cuser->test_input($_POST['newpass']);
	$cNewPass=$cuser->test_input($_POST['cnewpass']);
	$hashPass=password_hash($newPass, PASSWORD_DEFAULT);
	if($newPass!=$cNewPass)
	{
		echo $cuser->showMessage('danger','Password Did Not Matched!');
	}
	else
	{
		if(password_verify($oldPass,$password))
		{
			$cuser->changePassword($hashPass,$id);
			echo $cuser->showMessage('success','Password Changed Sucessfully!');
			$cuser->insertNotification($id,'Admin','Changed Password');
		}
		else
		{
			echo $cuser->showMessage('danger','Current Password Is Wrong!');
		}
	}
}

if(isset($_POST['action']) && $_POST['action']=='verify_email')
{
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
            $mail->Subject='Email Verification, User Management System';
            $mail->Body='<h3>Click The Below Link To Verify Your Email.<a href="http://localhost/User%20Management%20System/Admin/verify.php?email='.$email.'">Click The Link.</a><h3>
                         <p>Please do with anyone not share this Link for your security</p>
                         <p>Regards,</p>
                         <p>User Management System Team.</p>';
            $mail->send();
            echo $cuser->showMessage('success','Verification Link sent to your Email! Plase Check Your Email!');
            $cuser->insertNotification($id,'Admin','Email Verification');
		}
		catch(Exception $exception)
		{
			echo $cuser->showMessage('danger','Something Went Wrong Please Try Again Later!');
		}
}

if(isset($_POST['action']) && $_POST['action']=='feedback')
{
	$subject=$cuser->test_input($_POST['subject']);
	$feedback=$cuser->test_input($_POST['feedback']);
	$cuser->insertFeedback($subject,$feedback,$id);
	$cuser->insertNotification($id,'Admin','Feedback Written');
}

if(isset($_POST['action']) && $_POST['action']=='fetchNotification')
{
	$notification=$cuser->fetchNotifications($id);
	$output='';
	if($notification)
	{
		foreach($notification as $rows)
		{
			$output.='<div class="alert alert-danger" role="alert">
					<button type="button" id="'.$rows['id'].'" class="close" data-dismiss="alert" aria-label="close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="alert-heading">New Notification</h4>
					<p class="mb-0 lead">'.$rows['message'].'</p>
					<hr class="my-2">
					<p class="mb-0 float-left">Reply Of Feedback From Admin</p>
						<p class="mb-0 float-right">'.$cuser->timeInAgo($rows['created_at']).'</p>
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
	if($cuser->fetchNotifications($id))
	{
		echo '<i class="fas fa-circle fa-sm text-danger"></i>';
	}
	else
	{
		echo '';
	}
}

if(isset($_POST['notificationId']))
{
	$deleteId=$_POST['notificationId'];
	$cuser->deleteNotification($deleteId);
}

?>