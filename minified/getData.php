<?php



$draw   = isset($_POST['draw'])?   $_POST['draw']: "1";
$start  = isset($_POST['start'])?  $_POST['start']: "0";
$length = isset($_POST['length'])? $_POST['length']: "10";
$search = isset($_POST['search'])? $_POST['search']['value']: "";

require_once('_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select count(*) as c from bots_ip;");
$data['recordsTotal'] = $result->fetch_row();
$data['recordsTotal'] = $data['recordsTotal'][0];

if($search==''){
    $data['recordsFiltered'] = $data['recordsTotal'];
    $result = $db->query("select ip, DATE_FORMAT(FROM_UNIXTIME(`last_connection`), '%Y-%m-%d %H:%i:%s') as l_con, if(block=1,'Block', 'Allow') as b, if(admin_status=2,'Block', if(admin_status=1,'Allow', 'None')) as admin_b from bots_ip order by `last_connection` DESC limit {$start}, {$length};");
    $data['search'] = false;
}
else
{
    $result = $db->query("select count(*) as c from bots_ip where ip = '{$search}';");
    $data['recordsFiltered'] = $result->fetch_row();
    $data['recordsFiltered'] = $data['recordsFiltered'][0];

    $result = $db->query("select ip, DATE_FORMAT(FROM_UNIXTIME(`last_connection`), '%Y-%m-%d %H:%i:%s') as l_con, if(block=1,'Block', 'Allow') as b, if(admin_status=2,'Block', if(admin_status=1,'Allow', 'None')) as admin_b from bots_ip where ip = '{$search}' order by `last_connection` desc limit {$start}, {$length};");
    $data['search'] = true;
}
$data['data']=array();

while($_row = $result->fetch_object()){
    $data['data'][]=$_row;
}

$data['draw'] = $draw;

header('Content-Type: application/json');
echo json_encode($data);
