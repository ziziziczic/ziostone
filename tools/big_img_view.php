<?
//$Image = urldecode($enUrl);
$root = "../";
$img_src = $root . $_GET[src];
$image_size = getimagesize($img_src);
$hSize = $image_size[0] + 30;
$vSize = $image_size[1] + 60;

?>
<html>
<head>
<title>실제크기사진</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
</head>
<body bgcolor='#FFFFFF' text='#000000' topmargin='0' marginwidth='0' marginheight='0' leftmargin='0' onload='<?echo("self.resizeTo({$hSize}, {$vSize})")?>'>
<center><a href='javascript:window.close(self)'><img src='<?echo($img_src)?>' border='0'></a></center>
</body>
</html>