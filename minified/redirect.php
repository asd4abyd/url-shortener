<?php

/*  definitions */
$link_id = $_GET['id'];

if (empty($link_id)) die();


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

$browser_array = array(
    '/rv/i'       =>  'Internet Explorer',
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


$agent = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'];

$browser=false;
$os = false;

foreach ($browser_array as $regex => $value) {
    if (preg_match($regex, $agent)) {
        $browser = true;
        break;
    }
}


foreach ($os_array as $regex => $value) {
    if (preg_match($regex, $agent)) {
        $os = true;
        break;
    }
}


require_once('_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$ip = $_SERVER['REMOTE_ADDR'];

define('BLOCKED_USER', 1);
define('ALLOW_USER',   0);

define('ADMIN_ALLOW_USER',   1);
define('ADMIN_BLOCK_USER',   2);


$result = $db->query("select `value` from bots_settings where `key`='connections per hour';");
$row = $result->fetch_row();

$connectionPerHour = $row[0];

$result = $db->query(" select count(*) from bots_log where ip='$ip' and (DATE_FORMAT(FROM_UNIXTIME(`date`),'%Y%m%d%H') = DATE_FORMAT(now(),'%Y%m%d%H'));");
$row = $result->fetch_row();

$block = ($row[0]>$connectionPerHour)?1:0;

$block=0;

/*  add bot to the list  */

$db->query("INSERT INTO bots_ip (ip, last_connection, `block`, admin_status) VALUE
('$ip', UNIX_TIMESTAMP(), 0, 0) ON DUPLICATE KEY UPDATE last_connection=VALUES(last_connection), `block`=$block");


if(empty($referer)){


    redirectBlockUsers();
}

if(!($os and $browser)){
    redirectBlockUsers();
}

/*  start conditions  */
if($result = $db->query("select `block`, admin_status from bots_ip where ip = '$ip' limit 1")) {
    $row = $result->fetch_object();

    if($row->admin_status == ADMIN_BLOCK_USER) {
        redirectBlockUsers();
    }

    if($row->admin_status == ADMIN_ALLOW_USER) {
        redirectURL($link_id);
    }

    if($row->admin_status != ADMIN_BLOCK_USER and $row->block == ALLOW_USER) {
        redirectURL($link_id);
    }
}

function redirectURL($link_id){
    global $db;
    global $ip;
    global $db_table;

    $browser = false;
    $os      = false;


    $agent = $_SERVER['HTTP_USER_AGENT'];
    $referer = $_SERVER['HTTP_REFERER'];


    $db->query("INSERT INTO bots_log (ip, `date`, link_id, user_agent, referer) VALUE
        ('$ip', UNIX_TIMESTAMP(), $link_id, '$agent', '$referer')");


    if ($result = $db->query("select link from `$db_table` where id = '$link_id' limit 1")) {
        $row = $result->fetch_row();
        $link = $row[0];

//        die("INSERT INTO bots_log (ip, `date`, link_id, user_agent, referer) VALUE
//    ('$ip', UNIX_TIMESTAMP(), $link_id, '$agent', '$referer'");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately

        header('Location: ' . $link, true, 301);
        exit();
    }
}

function redirectBlockUsers(){
    global $db;
    $result = $db->query("select `value` from bots_settings where `key`='redirect'");

    $row = $result->fetch_row();
    $v = $row[0];

    header('Location: '.$v , true, 302);
    exit();
}

function getCurlData($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 120);
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}

$siteKey='';

$result = $db->query("select `value` from bots_settings where `key`='use captcha'");

$row = $result->fetch_row();
$v = $row[0];

if($v=='true') {
    $msg = '';

    $result = $db->query("select `value` from bots_settings where `key`='Site Key'");

    $row = $result->fetch_row();
    $siteKey = $row[0];

    $result = $db->query("select `value` from bots_settings where `key`='Secret Key'");

    $row = $result->fetch_row();
    $secretKey = $row[0];

    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha = $_POST['g-recaptcha-response'];
        if (!empty($recaptcha)) {
            $google_url = "https://www.google.com/recaptcha/api/siteverify";
            $secret = $secretKey;
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha; //."&remoteip=".$ip;
            $res = getCurlData($url);
            $res = json_decode($res, true);
            //reCaptcha success check
            if ($res['success']) {
                redirectURL($link_id);
            } else {
                $msg = "Please complete the robot test";
            }
        } else {
            $msg = "Please complete the robot test";
        }
    }
}
else {
    redirectBlockUsers();
}

?>

<html>
<head>
    <title>Robot Test</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<div style="margin: 100px auto;display: table;">
    <?php
    if($msg!='') {
        echo "<h1>$msg</h1>";
    }
    ?>
<form action="?" method="POST">
    <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
    <br/>
    <input type="submit" value="Redirect Link">
</form>
</div>
</body>
</html>