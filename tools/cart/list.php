<?
include "{$vg_cart_dir_info['include']}lock_direct_conn.inc.php";
include "{$vg_cart_dir_info[root]}cart_list.inc.php";

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td height=10></td></tr>
	<tr>
		<td align=center>
			<table cellpadding=5>
				<tr>
					<td>" . $lh_common->make_input_box("주문하기", "order", "button", "class='design_button' onclick=\"document.location.href='{$vg_cart_file[order]}'\"", '') . "</td>
					<td>" . $lh_common->make_input_box("모두비우기", "delete_all", "button", "class='design_button' onclick=\"document.location.href='{$vg_cart_file[update]}?mode=delete_all'\"", '') . "</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
");
?>