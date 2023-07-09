<?
if ($root == '') $vg_tax_dir_site_root = "../../";
else $vg_tax_dir_site_root = $root;
include "{$vg_tax_dir_site_root}tools/tax_accounts/config.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ko">
<meta http-equiv="Content-Type" content="text/html; charset=ks_c_5601-1987">
<link rel="stylesheet" type="text/css" href="<?echo($vg_tax_dir_info['include'])?>style.css">
</head>
<body>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
<?
if ($vg_tax_file_name == '') $vg_tax_file_name = "tax_list.php";
include "{$vg_tax_dir_info[root]}$vg_tax_file_name";
?>
		</td>
	</tr>
</table>
</body>
</html>