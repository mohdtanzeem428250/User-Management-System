<?php
class Database
{
	private $dsn="mysql:host=localhost;dbname=user-management-system";
	private $dbuser="root";
	private $dbpass="";
	public $con;
	public function __construct()
	{
		try
		{
			$this->con=new PDO($this->dsn,$this->dbuser,$this->dbpass);
		}
		catch(PDOException $exception)
		{
			echo "Error : ".$exception->getMessage();
		}
		return $this->con;
	}
	public function test_input($data)
	{
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	public function showMessage($type,$message)
	{
		return '<div class="alert alert-'.$type.' alert-dismissible">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong class="text-center">'.$message.'</strong>
				</div>';
	}

	public function timeInAgo($timestamp)
	{
		date_default_timezone_set('Asia/Kolkata');
		$timestamp=strtotime($timestamp)?strtotime($timestamp):$timestamp;
		$time=time()-$timestamp;
		switch($time)
		{
			case $time<=60:
				return 'Just Now!';
			case $time>=60 && $time<3600:
				return (round($time/60)==1)?'A Minute Ago':round($time/60).' Minutes Ago';
			case $time>=3600 && $time<86400:
				return (round($time/3600)==1)?'An Hour Ago':round($time/3600).' Hours Ago';
			case $time>=86400 && $time<604800:
				return (round($time/86400)==1)?'A Day Ago':round($time/86400).' Days Ago';
			case $time>=604800 && $time<2600640:
				return (round($time/604800)==1)?'A Week Ago':round($time/604800).' Weeks Ago';
			case $time>=2600640 && $time<31207680:
				return (round($time/2600640)==1)?'A Month Ago':round($time/2600640).' Months Ago';
			case $time>=31207680:
				return (round($time/31207680)==1)?'A Year Ago':round($time/31207680).' Years Ago';
		}
	}
}

?>