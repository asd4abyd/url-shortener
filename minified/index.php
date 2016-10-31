<?php
	include_once('_config.php');

$ip = $_SERVER['REMOTE_ADDR'];

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
	//echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	die();
}

$result = $db->query("select admin_status from bots_ip where ip='$ip';");
if($result->num_rows()>0){
	$data = $result->fetch_row();
	if($data[0]==2) {
		$r = $db->query("select `value` from bots_settings where `key`='redirect';");
		$d = $r->fetch_row();
		header('Location: '.$d[0]);
		exit();

	}
}



?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="css/style.css">

	<title>Enctype</title>
</head>
<body>
	<div class="container">
		<form action="encode.php" method="post" enctype="application/x-www-form-urlencoded" role="form" id="encrypt-form">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<h3>Encrypt</h3>
				<div class="form-group input-group">
					<input type="text" class="form-control" name="link" value="" required>
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit">Encrypt</button>
					</span>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" value="" readonly id="redirect_link">
				</div>
				<div id="error-messages"></div>
			</div>
		</div>
		</form>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<hr>
				<h3>History</h3>
				<div id="history"></div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</body>
</html>