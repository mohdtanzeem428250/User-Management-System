<?php require_once 'assets/php/header.php'; ?>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card rounded-0 mt-3 border-primary">
					<div class="card-header border-primary">
						<ul class="nav nav-tabs card-header-tabs">
							<li class="nav-item">
								<a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
							</li>
							<li class="nav-item">
								<a href="#editprofile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
							</li>
							<li class="nav-item">
								<a href="#changepassword" class="nav-link font-weight-bold" data-toggle="tab">Change Password</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane container active" id="profile">
								<div id="verifyEmailAlert"></div>
								<div class="card-deck">
									<div class="card border-primary">
										<div class="card-header bg-primary text-light text-center lead">
											User Id : <?= $id ?>
										</div>
										<div class="card-body">
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Name : </b><?= $name; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Email : </b><?= $email; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Gender : </b><?= $gender; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Date Of Birth : </b><?= $dateOfBirth; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Phone : </b><?= $mobile; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Registered On : </b><?= $registeredDate; ?></p>
											<p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Email Verified : </b><?= $status; ?>
											<?php
											if($status=="Not Varified!"):
											?>
											<a href="#" id="verify-email" class="float-right">Verify Now</a>
											<?php endif; ?>
											</p>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="card border-primary">
									<?php if(!$image):?>
										<img src="assets/img/default-user.webp" class="img-thumbnail img-fluid" width="408px">
									<?php else: ?>
										<img src="<?= 'assets/php/'.$image; ?>" class="img-thumbnail img-fluid" width="408px">
									<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="tab-pane container fade" id="editprofile">
								<div class="card-deck">
									<div class="card border-danger align-self-center">
										<?php if(!$image):?>
											<img src="assets/img/default-user.webp" class="img-thumbnail img-fluid" width="408px">
										<?php else: ?>
											<img src="<?= 'assets/php/'.$image; ?>" class="img-thumbnail img-fluid" width="408px">
										<?php endif; ?>
									</div>
									<div class="card border-danger">
										<form action="" method="POST" class="px-3 mt-2" enctype="multipart/form-data" id="profile-update-form">
											<input type="hidden" name="oldimage" value="<?= $image; ?>">
											<div class="form-group m-0">
												<label for="profilePhoto" class="m-1">Upload Profile Image</label><br>
												<input type="file" name="image" id="profilePhoto">
											</div>

											<div class="form-group m-0">
												<label for="name" class="m-1">Name</label>
												<input type="text" name="name" id="name" class="form-control" value="<?= $name; ?>">
											</div>

											<div class="form-group m-0">
												<label for="gender" class="m-1">Gender</label>
												<select name="gender" id="gender" class="form-control">
													<option value="" disabled <?php if($gender==null){ echo 'selected'; } ?> >Select Gender</option>
													<option value="Male" <?php if($gender=='Male'){ echo 'For Male'; } ?> >For Male</option>
													<option value="Female" <?php if($gender=='Female'){ echo 'For Female'; } ?> >For Female</option>
												</select>
											</div>

											<div class="form-group m-0">
												<label for="dob" class="m-1">Date Of Birth</label>
												<input type="date" name="dob" id="name" class="form-control" value="<?= $dateOfBirth; ?>">
											</div>

											<div class="form-group m-0">
												<label for="phone" class="m-1">Phone</label>
												<input type="tel" name="phone" id="phone" class="form-control" value="<?= $mobile; ?>" placeholder="Phone">
											</div>

											<div class="form-group mt-2">
												<input type="submit" name="profile_update" value="Update Profile" class="btn btn-danger btn-block" id="profileUpdateBtn">
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="tab-pane container fade" id="changepassword">
								<div id="changePassAlert"></div>
								<div class="card-deck">
									<div class="card border-success">
										<div class="card-header bg-success text-white text-center">
											Change Password
										</div>
										<form action="" method="POST" class="px-3 mt-2" id="change-password-form">
											<div class="form-group">
												<label for="curpass">Enter Your Current Password</label>
												<input type="password" name="curpass" placeholder="Enter Your Current Password" class="form-control form-control-lg" id="curpass" required minlength="8">
											</div>

											<div class="form-group">
												<label for="newpass">Enter New Password</label>
												<input type="password" name="newpass" placeholder="Enter New Password" class="form-control form-control-lg" id="newpass" required minlength="8">
											</div>

											<div class="form-group">
												<label for="cnewpass">Enter Confirm Password</label>
												<input type="password" name="cnewpass" placeholder="Enter Confirm Password" class="form-control form-control-lg" id="cnewpass" required minlength="8">
											</div>

											<div class="form-group">
												<p id="changePassError" class="text-danger"></p>
											</div>

											<div class="form-group">
												<input type="submit" name="changepassword" value="Change Password" class="btn btn-success btn-block btn-lg" id="changePassBtn">
											</div>
										</form>
									</div>
									<div class="card border-success align-self-center" >
										<img src="assets/img/change.jpg" class="img-tumbnail img-fluid" style="height: 400px;" width="408px">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">
		var $j = jQuery.noConflict();
		$j(document).ready(function() 
		{
    		$j("#profile-update-form").submit(function(e) {
	        e.preventDefault();
	        $j.ajax({
	            url: 'assets/php/process.php',
	            method: 'POST',
	            processData: false,
	            contentType: false,
	            cache: false,
	            data: new FormData(this),
	            success: function(response) 
	            {
	            	location.reload();    
	            }
	        });
    	});
    	$("#changePassBtn").click(function(e)
    	{
    		if($("#change-password-form")[0].checkValidity())
    		{
    			e.preventDefault();
    			$("#changePassBtn").val('Please Wait...');
    			if($("#newpass").val() != $("#cnewpass").val())
    			{
    				$("#changePassError").text('Password Did Not Matched!');
    				$("#changePassBtn").val('Change Password');
    			}
    			else
    			{
    				$j.ajax(
    				{
    					url:'assets/php/process.php',
    					method:'POST',
    					data:$("#change-password-form").serialize()+'&action=change_password',
    					success:function(response)
    					{
    						$("#changePassAlert").html(response);
    						$("#changePassBtn").val('Change Password');
    						$("#changePassError").text('');
    						$("#change-password-form")[0].reset();
    					}
    				});
    			}
    		}
    	});

    	$("#verify-email").click(function(e)
    	{
    		e.preventDefault();
    		$(this).text('Please Wait...');
    		$j.ajax(
    		{
    			url:'assets/php/process.php',
    			method:'POST',
    			data:{ action:'verify_email' },
    			success:function(response)
    			{
    				$("#verifyEmailAlert").html(response);
    				$("#verify-email").text('Verify Now');
    			}
    		});
    	});

    	checkNotification();
			function checkNotification()
			{
				$.ajax(
				{
					url:'assets/php/process.php',
					method:'POST',
					data:{action:'checkNotification'},
					success:function(response)
					{
						$("#checkNotification").html(response);
					}
				})
			}

	});

	</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>