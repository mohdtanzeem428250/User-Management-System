<?php require_once 'assets/php/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php if($status=='Not Varified!'): ?>
				<div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
					<button class="close" type="button" data-dismiss="alert">&times;</button>
					<strong>Your Email Is Not Verified! We're Send You An Email Verification Link On Your Email, Check & Verify Now!</strong>
				</div>
				<?php endif; ?>
				<h4 class="text-center text-primary mt-2">Write Your Notes Here & Access Anytime Anywhere!</h4>
			</div>
		</div>
		<div class="card border-primary">
			<h5 class="card-header bg-primary d-flex justify-content-between">
				<span class="text-light lead align-self-center">All Notes</span>
				<a href="#" class="btn btn-light" data-toggle="modal" data-target="#addNoteModal"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Note</a>
			</h5>
			<div class="card-body">
				<div class="table-responsive" id="showNote">		
					<p class="text-center lead mt-5">Please Wait...</p>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addNoteModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<h4 class="modal-title text-light">Add New Note</h4>
					<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="" method="POST" id="add-note-form" class="px-3">
						<div class="form-group">
							<input type="text" name="title" class="form-control form-control-lg" placeholder="Enter The Title" required>
						</div>

						<div class="form-group">
							<textarea type="text" name="note" class="form-control form-control-lg" placeholder="Write Your Notes Here!" rows="6" required></textarea>
						</div>

						<div class="form-group">
							<input type="submit" name="addNote" id="addNoteBtn" value="Add Note" class="btn btn-success btn-block btn-lg">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editNoteModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h4 class="modal-title text-light">Update Note</h4>
					<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="" method="POST" id="edit-note-form" class="px-3">
						<input type="hidden" name="id" id="id">
						<div class="form-group">
							<input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter The Title" required>
						</div>

						<div class="form-group">
							<textarea type="text" name="note" id="note" class="form-control form-control-lg" placeholder="Write Your Notes Here!" rows="6" required></textarea>
						</div>

						<div class="form-group">
							<input type="submit" name="editNote" id="editNoteBtn" value="Update Note" class="btn btn-info btn-block btn-lg">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("table").DataTable();


			$("#addNoteBtn").click(function(e)
			{
				if($("#add-note-form")[0].checkValidity())
				{
					e.preventDefault();
					$("#addNoteBtn").val("Please Wait...");
					$.ajax(
					{
						url:'assets/php/process.php',
						method:'POST',
						data:$("#add-note-form").serialize()+'&action=addNote',
						success:function(response)
						{
							$("#addNoteBtn").val("Add Note");
							$("#add-note-form")[0].reset();
							$("#addNoteModal").modal('hide');
							Swal.fire(
							{
								title:'Notes Added Successfully.',
								type:'success'
							});
							displayAllNoted();
						}
					});
				}
			});

			displayAllNoted();

			$("body").on("click",".editBtn",function(e)
			{
				e.preventDefault();
				editId=$(this).attr('id');
				$.ajax(
				{
					url:'assets/php/process.php',
					method:'POST',
					data: { edit_id:editId },
					success:function(response)
					{
						data=JSON.parse(response);
						$("#id").val(data.id);
						$("#title").val(data.title);
						$("#note").val(data.notes);
					}
				});
			});

			$("#editNoteBtn").click(function(e)
			{
				if($("#edit-note-form")[0].checkValidity())
				{
					e.preventDefault();
					$.ajax(
					{
						url:'assets/php/process.php',
						method:'POST',
						data: $("#edit-note-form").serialize()+'&action=update_note',
						success:function(response)
						{
							Swal.fire(
							{
								title:'Notes Updated Successfully.',
								type:'success'
							});
							$("#edit-note-form")[0].reset();
							$("#editNoteModal").modal('hide');
							displayAllNoted();
						}
					});
				}
			});

			$("body").on("click",".deleteBtn",function(e)
			{
				e.preventDefault();
				deleteId=$(this).attr('id');

				Swal.fire(
				{
					title:'Are You Sure?',
					text:"You Won't Be Able To Revert This!",
					type:'warning',
					showCancelButton:true,
					confirmButtonColor:'#3085d6',
					cancelButtonColor:'#d33',
					confirmButtonText:'Yes, Delete It'
				}).then((result)=>
				{
					if(result.value)
					{
						$.ajax(
						{
							url:'assets/php/process.php',
							method:'POST',
							data:{ del_id:deleteId },
							success:function(response)
							{
								Swal.fire(
									'Deleted!',
									'Your Notes Has Been Deleted Successfully!',
									'success'
								)
								displayAllNoted();
							}
						});
					}
				})
			});

			$("body").on("click",".infoBtn",function(e)
			{
				e.preventDefault();
				infoId=$(this).attr('id');
				$.ajax(
				{
					url:'assets/php/process.php',
					method:'POST',
					data: { info_id:infoId },
					success:function(response)
					{
						data=JSON.parse(response);
						Swal.fire(
						{
							title:'<strong>Note : ID('+data.id+')</strong>',
							type:'info',
							html:'<b>Title : </b>'+data.title+'<br><br><b>Note : </b>'+data.notes+'<br><br><b>Written On : </b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
							showCloseButton:true,
						});
					}
				});
			});

			function displayAllNoted()
			{
				$.ajax(
				{
					url:'assets/php/process.php',
					method:'POST',
					data: { action:'display_notes' },
					success:function(response)
					{
						$("#showNote").html(response);
						$("table").DataTable(
						{
							order:[0,'desc']
						});
					}
				});
			}

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

			$.ajax(
			{
				url:'assets/php/action.php',
				method:'POST',
				data:{action:'checkUser'},
				success:function(response)
				{
					if(response==='bye')
					{
						window.location='index.php';
					}
				}
			});
		})
	</script>
</body>
</html>