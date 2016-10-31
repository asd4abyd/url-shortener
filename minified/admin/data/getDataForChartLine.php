<?

$osArr = array(
    'Windows 10',
    'Windows 8.1',
    'Windows 8',
    'Windows 7',
    'Windows Vista',
    'Windows Server 2003/XP x64',
    'Windows XP',
    'Windows XP',
    'Windows 2000',
    'Windows ME',
    'Windows 98',
    'Windows 95',
    'Windows 3.11',
    'Mac OS X',
    'Mac OS 9',
    'Linux',
    'Ubuntu',
    'iPhone',
    'iPod',
    'iPad',
    'Android',
    'BlackBerry',
    'Mobile',
    'Unknown OS Platform'
);

function getOS($user_agent) {

    $os_platform = "Unknown OS Platform";

    $os_array    = array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
        );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}

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
        '/mobile/i'     =>  'Handheld Browser'
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

$os = array();

while($_row = $result->fetch_assoc()){
    $os[array_search(getOS($_row['user_agent']), $osArr)] += $_row['c'];
}

$data['data'] = array();

foreach($os as $key=>$val){
    $data['data'][] = array('y'=>$key, 'x'=>$val);
}


$data['xkey']= 'y';
$data['ykeys']= array('x');
$data['labels']= array('OS');

header('Content-Type: application/json');
echo json_encode(array('data'=>$data, 'os'=>$osArr));
