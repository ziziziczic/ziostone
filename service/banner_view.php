<?
// 메인
include "header.inc.php";
$banner_info = $GLOBALS[lib_common]->get_data($DB_TABLES[banner], "serial_num", $_GET[serial_num]);
$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $banner_info[serial_service_item]);
$banner_preview = print_banner_list($service_item_info[serial_num], $banner_info[serial_num]);
$P_input_form = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=70 class=input_form_title><font color=red>*</font> 배너위치</td>
		<td class=input_form_value>
			$banner_info[name]
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 소유자명</td>
		<td class=input_form_value>
			$banner_info[owner_name]
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 휴대폰</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("phone", $banner_info[owner_phone_mobile], '-') . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 이메일</td>
		<td class=input_form_value>
			$banner_info[owner_email]
		</td>
	</tr>
</table>
";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>배너기본정보</b>"));

$P_input_form_admin = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=70 class=input_form_title><font color=red>*</font> 서비스</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("date", $banner_info[banner_open_date], '', "y-m-d H:i:s") . " ~
			" . $GLOBALS[lib_common]->get_format("date", $banner_info[banner_close_date], '', "y-m-d H:i:s") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 상태</td>
		<td class=input_form_value>
			{$BA_state[$banner_info[state]]}
		</td>
	</tr>										
	<tr>
		<td class=input_form_title><font color=red>*</font> 우선순위</td>
		<td class=input_form_value>
			$banner_info[priority]
		</td>
	</tr>
	<tr>
		<td class=input_form_title>* 링크타겟</td>
		<td class=input_form_value>
			{$SI_banner_target[$banner_info[link_target]]}, {$banner_info[link_target_pp]}
		</td>
	</tr>
</table>
";
$P_input_form_admin = $lib_insiter->w_get_img_box($IS_thema, $P_input_form_admin, $IS_input_box_padding, array("title"=>"<b>부가정보 (관리자용)</b>"));

$P_view_banner = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td class=input_form_value>
			$banner_preview[0]
		</td>
	</tr>
		<tr>
		<td class=input_form_value>
			링크주소 : $banner_info[link_url] | 보너스배너 : $banner_preview[1]
		</td>
	</tr>
</table>
";
$P_view_banner = $lib_insiter->w_get_img_box($IS_thema, $P_view_banner, $IS_input_box_padding, array("title"=>"<b>배너미리보기</b>"));

$today = getdate($GLOBALS[w_time]);
$property = array("class=designer_select", "class=designer_select");
if ($_GET[sch_date_year] != '') $sch_year = $_GET[sch_date_year];
else $sch_year = $today[year];
if ($_GET[sch_date_month] != '') $sch_month = $_GET[sch_date_month];
else $sch_month = $today[mon];
$print_info = array('Y'=>array("2006", $today[year], $sch_year, "년 "), 'M'=>array("1", "12", $sch_month, "월 "));
$option_null = array();
$date_select_box = $GLOBALS[lib_common]->get_date_select_box("sch_date", $print_info, $property, $option_null);
$banner_log_list = get_banner_log_list($banner_info[serial_num], $sch_year, $sch_month);

$P_banner_log_title = "
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td><b>배너 클릭분석</b></td>
		<td align=right>
			<table cellpadding=3 border=0 cellspacing=0>
			<form name=frm_sch_log action='$PHP_SELF' method='get'>
			<input type=hidden name='serial_num' value='$banner_info[serial_num]'>
				<tr>
					<td>$date_select_box</td>
					<td>
						<input type='submit' value='검색' class=designer_button>
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
</table>
";
$P_banner_log = $lib_insiter->w_get_img_box($IS_thema, $banner_log_list, $IS_input_box_padding, array("title"=>$P_banner_log_title));

$change_vars = array();
$link_list = "{$DIRS[service]}banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
$change_vars = array("serial_num"=>$banner_info[serial_num]);
$link_modify = "{$DIRS[service]}banner_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr valign=top>
		<td width=50%>$P_input_form</td>
		<td width=1%></td>
		<td width=49%>$P_input_form_admin</td>
	</tr>
	<tr><td colspan=3 height=10></td></tr>
	<tr>
		<td colspan=3>$P_view_banner</td>
	</tr>
	<tr><td colspan=3 height=10></td></tr>
	<tr>
		<td colspan=3>$P_banner_log</td>
	</tr>
	<tr>
		<td align=center height=40 colspan=3>
			<input type=button value='수정하기' onclick=\"document.location.href='$link_modify'\" class='designer_button'>
			<input type=button value='목록보기' onclick=\"document.location.href='$link_list'\" class='designer_button'>
		</td>
	</tr>
	<tr><td colspan=3 height=10></td></tr>
	<tr>
		<td colspan=3>
");
$F_include = "YES";
include "buy_list.php";
echo("
		</td>
	</tr>
</table>
");
include "{$DIRS[designer_root]}footer.inc.php";
?>