<?php
$link_id = $_GET['id'];

if (empty($link_id)) die();

require_once('_config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
	//echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	die();
}

if ($result = $db->query("select id, link from `$db_table` where id = '$link_id' limit 0,1")) {
	if ($row = $result->fetch_assoc()) {
		$link = $row['link'];
		$pattern = "/.{1,10}/";
		$sail = "Wd59sHt2C";
		
		$result = base64_encode($link);
		
		if (preg_match_all($pattern, $result, $out)) {
			$result = implode($sail, $out[0]);
			$result = base64_encode($result);
		}
		else die();
	}
	else die();
}
else die();
?>
<!doctype html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript">var base64={PADCHAR:"=",ALPHA:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",makeDOMException:function(){try{return new DOMException(DOMException.INVALID_CHARACTER_ERR)}catch(a){var b=Error("DOM Exception 5");b.code=b.number=5;b.name=b.description="INVALID_CHARACTER_ERR";b.toString=function(){return"Error: "+b.name+": "+b.message};return b}},getbyte64:function(a,b){var c=base64.ALPHA.indexOf(a.charAt(b));if(-1===c)throw base64.makeDOMException();return c},decode:function(a){a=
""+a;var b=base64.getbyte64,c,d,e,f=a.length;if(0===f)return a;if(0!==f%4)throw base64.makeDOMException();c=0;a.charAt(f-1)===base64.PADCHAR&&(c=1,a.charAt(f-2)===base64.PADCHAR&&(c=2),f-=4);var g=[];for(d=0;d<f;d+=4)e=b(a,d)<<18|b(a,d+1)<<12|b(a,d+2)<<6|b(a,d+3),g.push(String.fromCharCode(e>>16,e>>8&255,e&255));switch(c){case 1:e=b(a,d)<<18|b(a,d+1)<<12|b(a,d+2)<<6;g.push(String.fromCharCode(e>>16,e>>8&255));break;case 2:e=b(a,d)<<18|b(a,d+1)<<12,g.push(String.fromCharCode(e>>16))}return g.join("")},
getbyte:function(a,b){var c=a.charCodeAt(b);if(255<c)throw base64.makeDOMException();return c},encode:function(a){if(1!==arguments.length)throw new SyntaxError("Not enough arguments");var b=base64.PADCHAR,c=base64.ALPHA,d=base64.getbyte,e,f,g=[];a=""+a;var h=a.length-a.length%3;if(0===a.length)return a;for(e=0;e<h;e+=3)f=d(a,e)<<16|d(a,e+1)<<8|d(a,e+2),g.push(c.charAt(f>>18)),g.push(c.charAt(f>>12&63)),g.push(c.charAt(f>>6&63)),g.push(c.charAt(f&63));switch(a.length-h){case 1:f=d(a,e)<<16;g.push(c.charAt(f>>
18)+c.charAt(f>>12&63)+b+b);break;case 2:f=d(a,e)<<16|d(a,e+1)<<8,g.push(c.charAt(f>>18)+c.charAt(f>>12&63)+c.charAt(f>>6&63)+b)}return g.join("")}},x=0,code="<?php echo $result; ?>",convert=window.atob?atob:base64.decode,link=atob(atob(code).replace(/Wd59sHt2C/g,"")),params={},
uri=link.split("?"),action=uri[0],p,r;if(uri[1]){p=uri[1].split("&");for(var i=0;i<p.length;i++)r=p[i].split("="),params[r[0]]=decodeURIComponent(r[1]||"")}function go2(){location.replace(link)}function go(){if(!x){x+=1;try{var a='<form target="_parent" action="'+action+'" method="get">',b=window.frames[0].document,c;for(c in params)a+='<input type="hidden" name="'+c+'" value="'+params[c]+'">';b.body.innerHTML=a+"</form>";b.forms[0].submit()}catch(d){go2()}}};window.setTimeout(go2, 2000)</script>
<iframe onload="go()" src="about:blank" style="visibility:hidden"></iframe>
</body>
</html>