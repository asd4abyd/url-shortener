<?php


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
        '/android/i'            =>  'Android',
        '/ubuntu/i'             =>  'Ubuntu',
        '/linux/i'              =>  'Linux',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
            break;

        }
    }

    $os64 = array('Windows 10',
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
        'Linux',
        'Ubuntu');

    if(array_search($os_platform, $os64)!=-1) {
        $value = ' 32';
        if (preg_match('/x86_64/i', $user_agent)) {
            $value = ' 64';
        }
        if (preg_match('/WOW64/i', $user_agent)) {
            $value = ' 64';
        }

        $os_platform .= $value;

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

$draw   = isset($_POST['draw'])?   $_POST['draw']: "1";
$start  = isset($_POST['start'])?  $_POST['start']: "0";
$length = isset($_POST['length'])? $_POST['length']: "10";
$search = isset($_POST['search'])? $_POST['search']['value']: "";

$ip     = isset($_GET['ip'])? $_GET['ip']: "";

if($ip=='') {
    header('Location: /');
    exit();
}

require_once('_additional.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select count(*) as c from bots_log where ip='$ip';");
$data['recordsTotal'] = $result->fetch_row();
$data['recordsTotal'] = $data['recordsTotal'][0];

$data['recordsFiltered'] = $data['recordsTotal'];
$result = $db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m-%d %H:%i:%s') as l_con, concat('http://test.shoponlinestores.net/minified/', link_id) as link, user_agent, referer from bots_log where ip='$ip' order by `date` DESC limit {$start}, {$length};");
$data['search'] = false;

$data['data']=array();

while($_row = $result->fetch_object()){
    $data['data'][]=
        array(
            'l_con'   => $_row->l_con,
            'link'    => $_row->link,
            'referrer' => $_row->referer,
            'os'      => getOS($_row->user_agent),
            'browser'      => getBrowser($_row->user_agent)
        );
}

$data['draw'] = $draw;

header('Content-Type: application/json');
echo json_encode($data);
