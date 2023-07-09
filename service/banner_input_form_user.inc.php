<?
include_once "./service/config.inc.php";

$proc_mode = "add_user";
if ($_GET[serial_service_item] == '' && $i_class_review > 0) $_GET[serial_service_item] = '3';
$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $_GET[serial_service_item]);

if ($service_item_info[serial_num] == '') $GLOBALS[lib_common]->alert_url('배너종류가 선택되지 않았습니다.');

include "include/banner_input_form.inc.php";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>배너기본정보</b>"));
$P_input_form = "
	<tr>
		<td>$P_input_form</td>
	</tr>
";
$P_input_form_owner = $lib_insiter->w_get_img_box($IS_thema, $P_input_form_owner, $IS_input_box_padding, array("title"=>"<b>광고주정보</b>"));
$P_input_form_owner = "
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_input_form_owner</td>
	</tr>
";

echo("
<script src='{$DIRS[designer_root]}include/js/javascript.js'></script>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<form name=frm method=post action='service/banner_input.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='$proc_mode'>
	<input type=hidden name='serial_num' value='$_GET[serial_num]'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	$P_input_form
	$P_input_form_owner
	<tr>
		<td align=center height=40>
			<input type=submit value='저장하기' class='designer_button'>
		</td>
	</tr>
");
if ($proc_mode == "add_user" || $proc_mode == "add") {
	echo("
	<tr>
		<td>
	");
	$BIF_serial_service_item = array($_GET[serial_service_item]);
	$BIF_form_name = "frm";
	$BIF_item_select = 'Y';
	include "buy_input_form.inc.php";
	$script_buy = "if (verify_submit_buy(form) == false) return false;";
	echo("
		</td>
	</tr>
	");
}
echo("
	</form>
</table>
<script id='dynamic_manager'></script>
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (verify_submit_banner(form) == false) return false;
		if (verify_submit_banner_owner(form) == false) return false;
		$script_buy
	}
//-->
</script>
");
?>