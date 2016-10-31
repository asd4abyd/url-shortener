<?php

require_once('_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
	//echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	die();
}

$base_url = ($_SERVER['SERVER_PORT']==443?'https://':'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';

$link = trim($_REQUEST['link']);

if (empty($link)) {
	echo json_encode(array(
		"error" => 1,
		"message" => "Link can not be empty!",
	));
	die();
}

if (!preg_match("/^https?:\/\//",$link)) {
	$link = "http://" . $link;
}

function sendRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).DIRECTORY_SEPERATOR.'c00kie.txt');
//    curl_setopt($ch, CURLOPT_MAXREDIRS, 50);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
    //curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($ch, CURLOPT_URL, $url);

    $response = curl_exec($ch);

    $result = array(
        'response'=>$response,
        'url'=>$url,
        'error'=> curl_errno($ch),
        'msg'=> curl_error($ch)
    );


    curl_close($ch);

    return $result;
}


function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
{
    $result = '';

    
    $response = sendRequest($url);

    if($response['error']!=0) {
        return ['response'=>'', 'url'=>''];
        
	    echo json_encode(array(
            "error" => $response['error'],
		    "message" => $response['msg']
	    ));

	    die();
    }

    $contents = $response['response'];

    if (isset($contents) && is_string($contents))
    {
		preg_match_all("/<[\s]*meta[\s]*http-equiv=[\"']?REFRESH['\"]?[\s]*content=['\"]?[0-9]*;[\s]*URL[\s]*=[\s]*([^>\"]*)['\"]?[\s]*[\/]?[\s]*>/si",  $contents, $match);

        if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
        {
            if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
            {
				return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
            }

            $result = ['response'=>'', 'url'=>''];
        }
        else
        {
            $result = $response;
        }
    }

    return $result;
}



$htmlContent = getUrlContents($link, 10);

preg_match_all("/<base.*>/", $htmlContent['response'], $output_array);

if(count($output_array)==0 or count($output_array[0])==0) {
    $htmlContent = preg_replace("/(<head.*>)/", "$1<base href='{$htmlContent['url']}' />", $htmlContent['response']);
}
else
{
    $htmlContent = $htmlContent['response'];
}

//$htmlContent = preg_replace("/<base.*>/", "", $htmlContent);
//$htmlContent = preg_replace("/(<head.*>)/", "$1<base href='{$link}' />", $htmlContent);


$htmlContent = mysqli_real_escape_string($db, $htmlContent);


if (!$db->query("INSERT INTO `$db_table` (`link`, `encrypt`, `html`) VALUES ('$link', NULL, '{$htmlContent}')")) {
	echo json_encode(array(
		"error" => 1,
		"message" => "DB insert error!",
	));
	die();
}

$link_id = mysqli_insert_id($db);

echo json_encode(array(
	"error" => 0,
	"id" => $link_id,
	"link" => $link,
	"redirect_link" => $base_url . $link_id,
));
?>
