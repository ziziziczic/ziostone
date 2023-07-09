<?
include "header_sub.inc.php";

$category_info = $GLOBALS[lib_common]->get_data($DB_TABLES[fav_category], array("serial_num"=>$_GET[serial_category], "serial_member"=>$user_info[serial_num]), '');
if ($category_info[serial_num] == '') $GLOBALS[lib_common]->alert_url("분류 관리권한이 없습니다.", 'E', '', '', "window.close()");

// 분류명 수정폼
$P_input_form_name = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<form name=frm_ct_name method=post action='favorite_input.php' onsubmit='return verify_submit_ct_name(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='modify_ct'>
	<input type=hidden name='serial_category' value='$_GET[serial_category]'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<tr>
		<td class=input_form_title>{$IS_icon[form_title]}카테고리명</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($category_info[name], "ct_name", "text", "size=30 class=designer_text", '') . "
			<input type='submit' value='수정하기' class=designer_button>
			<input type='button' value='삭제' onclick='verify_delete(this.form)' class=designer_button>
		</td>
	</tr>
	</form>
</table>
";
$P_input_form_name = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_input_form_name, $IS_input_box_padding, array("title"=>"<b>분류정보</b>"));

// 즐겨찾기 링크 입력폼
$P_input_form_list = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr align=center>
		<td class=input_form_title width=35><b>순서</b></td>
		<td class=input_form_title width=100><b>사이트이름</b></td>
		<td class=input_form_title><b>URL 주소</b> (http:// 제외하고 입력)</td>
	</tr>
";
$query = "select * from $DB_TABLES[fav_link] where serial_category='$category_info[serial_num]' and serial_member='$user_info[serial_num]' order by sort asc";
$result = $GLOBALS[lib_common]->querying($query);
$value_link = array();
while ($value = mysql_fetch_array($result)) $value_link[] = $value;

for ($i=0; $i<max($fav_config[ct_per_links], sizeof($value_link)); $i++) {
	if ($value_link[$i][name] != '') {
		$btns_sort = "
			<a href=\"javascript:verify_submit_sort('sort_up_link', '{$value_link[$i][serial_link]}')\">{$IS_btns[sort_up]}</a>
			<a href=\"javascript:verify_submit_sort('sort_down_link', '{$value_link[$i][serial_link]}')\">{$IS_btns[sort_down]}
		";
	} else {
		$btns_sort = "
			{$IS_btns[sort_up]}
			{$IS_btns[sort_down]}
		";
	}
	$P_input_form_list .= "
	<tr>
		<td class=input_form_value align=center>
			$btns_sort
		</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($value_link[$i][name], "link_name[]", "text", "size=25 class=designer_text", "width:100%") . "
		</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($value_link[$i][link_url], "link_url[]", "text", "size=60 class=designer_text", "width:100%") . "
		</td>
	</tr>
	";
}
$P_input_form_list .= "
</table>
";
$P_input_form_list = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_input_form_list, $IS_input_box_padding, array("title"=>"<b>'{$category_info[name]}' 분류</b> 즐겨찾기 링크 등록"));

echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td align=center>
			$P_input_form_name
		</td>
	</tr>
	<tr><td height=10></td></tr>
	<form name=frm method=post action='favorite_input.php' onsubmit='return verify_submit_links(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='add_urls'>
	<input type=hidden name='serial_category' value='$_GET[serial_category]'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<input type=hidden name='serial_link' value=''>
	<input type=hidden name='return_page' value=''>
	<tr>
		<td>
			$P_input_form_list
		</td>
	</tr>
	<tr>
		<td align=center height=40>
			<input type=submit value='저장하기' class='designer_button'>
			<input type=button value='닫기' onclick='opener.location.reload();window.close()' class='designer_button'>
		</td>
	</tr>
	</form>
</table>
<script language='javascript1.2'>
<!--
	function verify_submit_ct_name(form) {
		if (form.ct_name.value == '') {
			alert('분류명을 입력하세요');
			form.ct_name.focus();
			return false;
		}
	}
	function verify_submit_links(form) {
		if (!confirm(\"사이트이름이 없는 항목은 저장되지 않습니다.\\n\\n계속 하시려면 '확인'을 다시한번 확인 하시려면 '취소'를 클릭하세요\")) return false;
	}
	function verify_delete(form) {
		if (!confirm(\"분류를 삭제하시면 분류안의 모든 즐겨찾기도 삭제됩니다.\\n\\n계속 하시려면 '확인'을 다시한번 확인 하시려면 '취소'를 클릭하세요\")) return false;
		form.proc_mode.value = 'delete_ct';
		form.submit();
	}
	function verify_submit_sort(mode, serial_link) {
		form = document.frm;
		form.serial_link.value = serial_link;
		form.proc_mode.value = mode;
		form.return_page.value = '{$DIRS[favorite_link]}favorite_input_form.php';
		form.submit();
	}
//-->
</script>
");
include "{$DIRS[designer_root]}footer_sub.inc.php";
?>