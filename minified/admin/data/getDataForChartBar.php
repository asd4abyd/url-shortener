<?php


require_once('../../_config.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m-%d') as y, count(*) as 'x' from bots_log group by y order by `date` DESC limit 7;");

$data=array();
$data['data']= array();
$data['xkey']= 'y';
$data['ykeys']= array('x');
$data['labels']= array('Users Count');

while($_row = $result->fetch_assoc()){
    $data['data'][]=$_row;
}

header('Content-Type: application/json');
echo json_encode($data);
