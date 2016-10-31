<?php

require_once('../../_config.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select count(*) as total, admin_status as 'v' from bots_ip group by v;");


//$data['data']= array();

$data['data']= array(
    array('label'=>'None', 'value'=>0),
    array('label'=>'Allow', 'value'=>0),
    array('label'=>'Block', 'value'=>0)
);

while($_row = $result->fetch_assoc()){
    $data['data'][$_row['v']]['value']=$_row['total'];
}

header('Content-Type: application/json');
echo json_encode($data);
