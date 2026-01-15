<?php
require_once 'assets/php/admin-header.php';
require_once 'assets/php/admin-db.php';
$admin = new Admin();
?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-deck mt-3 text-light text-center font-weight-bold">
						<div class="card bg-primary">
							<div class="card-header">Total Users</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalCount('users'); ?></h1>
							</div>
						</div>

						<div class="card bg-warning">
							<div class="card-header">Verified Users</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalVerified('users','1'); ?></h1>
							</div>
						</div>

						<div class="card bg-success">
							<div class="card-header">Unverified Users</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalVerified('users','0'); ?></h1>
							</div>
						</div>

						<div class="card bg-danger">
							<div class="card-header">Website Hit</div>
							<div class="card-body">
								<h1 class="display-4"><?php $data= $admin->totalHitsUsers(); echo $data['hits']; ?></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-deck mt-3 text-light text-center font-weight-bold">
						<div class="card bg-danger">
							<div class="card-header">
								Total Notes
							</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalCount('tbl_notes'); ?></h1>
							</div>
						</div>

						<div class="card bg-success">
							<div class="card-header">
								Total Feedback
							</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalCount('tbl_feedback'); ?></h1>
							</div>
						</div>

						<div class="card bg-info">
							<div class="card-header">
								Total Notification
							</div>
							<div class="card-body">
								<h1 class="display-4"><?php echo $admin->totalCount('tbl_notification'); ?></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-deck my-3">
						
						<div class="card border-success">
							<div class="card-header bg-success text-center text-white lead">Male/Female User's Percentage</div>
							<div id="chartsOne" style="width: 99%; height: 400px;"></div>
						</div>

						<div class="card border-info">
							<div class="card-header bg-info text-center text-white lead">Verified/Unverified User's Percentage</div>
							<div id="chartsTwo" style="width: 99%; height: 400px;"></div>
						</div>

					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

		checkNotification();

			function checkNotification()
			{
				$.ajax(
				{
					url:'assets/php/admin-action.php',
					method:'POST',
					data:{action:'checkNotification'},
					success:function(response)
					{
						$("#checkNotification").html(response);
					}
				});
			}
		
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(PieChart);
      function PieChart() {
        var data = new google.visualization.arrayToDataTable([
        	['Gender','Number'],
        	<?php
        	$gender=$admin->genderPercentage();
        	foreach($gender as $rows)
        	{
        		echo '["'.$rows['gender'].'",'.$rows['number'].'],';
        	}
        	?>
        ]);
        var options={
        	is3D:false
        };
        var chart = new google.visualization.PieChart(document.getElementById('chartsOne'));
        chart.draw(data, options);
      }
    </script>
    <script>
    	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(colChart);
      function colChart() {
        var data = new google.visualization.arrayToDataTable([
        	['Verified','Number'],
        	<?php
        	$verify=$admin->verifiedPercentage();
        	foreach($verify as $row)
        	{
        		if($row['verified']==0)
        		{
        			$row['verified']='Unverified';
        		}
        		else
        		{
        			$row['verified']='Verified';
        		}
        		echo '["'.$row['verified'].'",'.$row['number'].'],';
        	}
        	?>
        ]);
        var options={
        	pieHole:0.4,
        };
        var chart = new google.visualization.PieChart(document.getElementById('chartsTwo'));
        chart.draw(data, options);
      }
    </script>
</body>
</html>
