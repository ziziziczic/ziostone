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
	case "design" :
		include "sub_menu_design.inc.php";
		$sub_menu = $sub_menu_design;
	break;
	case "board";
		include "sub_menu_board.inc.php";
		include "sub_menu_design.inc.php";		
		$sub_menu = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>$sub_menu_board</td>
				</tr>
				<tr><td height=5></td></tr>
				<tr>
					<td>$sub_menu_design</td>
				</tr>
			</table>
		";
	break;
	case "member";
		include "sub_menu_member.inc.php";
		include "sub_menu_design.inc.php";		
		$sub_menu = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>$sub_menu_member</td>
				</tr>
				<tr><td height=5></td></tr>
				<tr>
					<td>$sub_menu_design</td>
				</tr>
			</table>
		";
	break;
	case "popup";
		include "sub_menu_popup.inc.php";
		include "sub_menu_design.inc.php";		
		$sub_menu = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>$sub_menu_popup</td>
				</tr>
				<tr><td height=5></td></tr>
				<tr>
					<td>$sub_menu_design</td>
				</tr>
			</table>
		";
	break;
	case "visit";
		include "sub_menu_visit.inc.php";
		include "sub_menu_design.inc.php";		
		$sub_menu = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>$sub_menu_visit</td>
				</tr>
				<tr><td height=5></td></tr>
				<tr>
					<td>$sub_menu_design</td>
				</tr>
			</table>
		";
	break;
	default :
		$sub_menu = $lib_insiter->w_get_img_box("thin_skin_round_title", $lib_insiter->visit_count_view(), $IS_input_box_padding, array("title"=>"<b>방문자현황</b>"));
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