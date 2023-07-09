<?
if ($root == '') $vg_cart_dir_site_root = "../../";
else $vg_cart_dir_site_root = $root;
include "{$vg_cart_dir_site_root}tools/cart/config.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ko">
<meta http-equiv="Content-Type" content="text/html; charset=ks_c_5601-1987">
<link rel="stylesheet" type="text/css" href="<?echo($vg_cart_dir_info['include'])?>style.css">
</head>
<body>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
<?
if ($vg_cart_file_name == '') $vg_cart_file_name = "list.php";
include "{$vg_cart_dir_info[root]}$vg_cart_file_name";
?>
		</td>
	</tr>
</table>
</body>
</html>