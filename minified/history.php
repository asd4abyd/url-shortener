<?php
require_once('_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
	//echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	die();
}

$base_url = ($_SERVER['SERVER_PORT']==443?'https://':'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';
?>

<table class="table table-bordered">
	<col width="50%">
	<col width="40%">
	<thead>
		<tr>
			<th>Source Link</th>
			<th>Redirect Link</th>
		</tr>
	</thead>
	<tbody>
<?php
if ($result = $db->query("select id, link from `$db_table` order by id desc limit 0,50")) {
	while ($row = $result->fetch_assoc()) {
		$link = $row['link'];
		$id = $row['id'];
		$redirect_link = $base_url . $id;
?>
		<tr>
			<td>
				<a href="<?php echo $link; ?>" title="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
			</td>
			<td>
				<a href="<?php echo $redirect_link; ?>" title="<?php echo $redirect_link; ?>" target="_blank"><?php echo $redirect_link; ?></a>
			</td>
		</tr>
<?php
	}
}
?>
	</tbody>
</table>
