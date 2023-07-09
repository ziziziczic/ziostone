<?
if ($VG_OP_dir_site_root == '') $VG_OP_dir_site_root = "../../";
include "config.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ko">
<meta http-equiv="Content-Type" content="text/html; charset=ks_c_5601-1987">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<table width=500>
	<tr>
		<td>
<?
if ($VG_OP_file_name == '') $VG_OP_file_name = "list.php";
include "$VG_OP_file_name";
?>
		</td>
	</tr>
</table>
</body>
</html>