<?php

$browserArr = array(
    'Internet Explorer' =>  0,
    'Firefox'           =>  0,
    'Safari'            =>  0,
    'Chrome'            =>  0,
    'Opera'             =>  0,
    'Netscape'          =>  0,
    'Maxthon'           =>  0,
    'Konqueror'         =>  0,
    'Handheld Browser'  =>  0,
    'Mobile Android'    =>  0,
    'Mobile iPhone'     =>  0,
    'Mobile iPod'       =>  0,
    'Mobile iPad'       =>  0,
    'Mobile BlackBerry' =>  0,
    'Mobile'            =>  0,
    "Unknown Browser"   =>  0
);

function getBrowser($user_agent) {
    $browser       = "Unknown Browser";

    $browser_array = array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser',
        '/android/i'    =>  'Mobile Android',
        '/iphone/i'     =>  'Mobile iPhone',
        '/ipod/i'       =>  'Mobile iPod',
        '/ipad/i'       =>  'Mobile iPad',
        '/blackberry/i' =>  'Mobile BlackBerry',
        '/webos/i'      =>  'Mobile'
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    return $browser;
}

require_once('../../_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select count(*) as 'c', user_agent from bots_log group by user_agent;");

while($_row = $result->fetch_assoc()){
    $browserArr[getBrowser($_row['user_agent'])] += $_row['c'];
}

$data['data']= array();

foreach($browserArr as $key=>$val) {
    $data['data'][]= array(
        'label'=> $key,
        'value'=> $val
    );
}

header('Content-Type: application/json');
echo json_encode($data);
