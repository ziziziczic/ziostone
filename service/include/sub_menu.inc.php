<?
echo("
<table cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table cellspacing=0 cellpadding=0 align=center border=0 width=100%>
				<tr>
					<td align=center>
");
switch ($_SESSION[MU]) {
	case "service" :
		include "sub_menu_service.inc.php";
		$sub_menu = $sub_menu_service;
	break;
	default :
		// nothing
	break;
}
echo("
						$sub_menu
					</td>
				</tr>
				<tr><td height=10></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>" . $lib_insiter->w_get_img_box("thin_ruby_round", "<table width=100%><tr><td align=center bgcolor=ffffff><img src='{$DIRS[designer_root]}images/cs_center.gif'></td></tr></table>", 0) . "</td>
	</tr>
	<tr height=20><td></td></tr>
</table>
");
?>