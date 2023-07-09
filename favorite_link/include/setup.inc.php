<?
if (INSITER_INCLUDE != "YES") die("직접엑세스 할 수 없습니다");

// 분류개수
$option_name_ct_nums = array();
for ($i=5; $i<=20; $i=$i+5) $option_name_ct_nums[] = $i;

// 분류당 링크수
$option_name_links = array();
for ($i=1; $i<=30; $i++) $option_name_links[] = $i;

// 스킨선택
$table_skin_dir = "{$DIRS[designer_root]}images/box/";
$option_name = array(":: 기본스킨 ::");
$option_value = array('');

if ($handle = opendir($table_skin_dir)) {
	while (false !== ($file = readdir($handle))) { 
		if ($file != '.' && $file != ".." && substr($file, -6) == "_title") {
			$option_name[] = $file;
			$option_value[] = $file;
		}
	}
	closedir($handle);
}

$P_input_form = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<form name=frm_config method=post action='{$DIRS[favorite_link]}favorite_input.php' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='config'>
	<input type=hidden name='return_page' value='$return_page'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<tr>
		<td class=input_form_title width=150>{$IS_icon[form_title]}분류개수, 분류당 링크수</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_list_box("total_ct_nums", $option_name_ct_nums, $option_name_ct_nums, '', $fav_config[total_ct_nums], "class=designer_select", '') . " 개,
			" . $GLOBALS[lib_common]->make_list_box("ct_per_links", $option_name_links, $option_name_links, '', $fav_config[ct_per_links], "class=designer_select", '') . " 개
			" . $GLOBALS[lib_common]->make_list_box("skin", $option_name, $option_value, '', $fav_config[skin], "class='designer_select'") . "
			<input type=submit value='저장하기' class='designer_button'>
		</td>
	</tr>
	</form>
</table>
";
$P_input_form = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_input_form, $IS_input_box_padding, array("title"=>"<b>즐겨찾기 기본설정</b>"));

$P_input_form_category = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<form name=frm_add_ct method=post action='{$DIRS[favorite_link]}favorite_input.php' onsubmit='return verify_submit_add_ct(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='add_ct'>
	<input type=hidden name='return_page' value='$return_page'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<tr>
		<td class=input_form_title width=150>{$IS_icon[form_title]}분류명</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box('', "ct_name", "text", "size=20 class=designer_text", '') . "
			<input type=submit value='저장하기' class='designer_button'>
		</td>
	</tr>
	</form>
</table>
";
$P_input_form_category = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_input_form_category, $IS_input_box_padding, array("title"=>"<b>분류 추가하기</b>"));

// 분류목록
$T_category_list = array();
$P_category_list = '';
$query = "select * from $DB_TABLES[fav_category] where serial_member='$user_info[serial_num]' order by sort asc";
$result = $GLOBALS[lib_common]->querying($query);
if ($fav_config[skin] == '') $skin_dir = $FL_default_skin;
else $skin_dir = $fav_config[skin];
if (mysql_num_rows($result) > 0) {
	// 분류별 링크목록 먼저 구함
	while ($fav_ct_value = mysql_fetch_array($result)) {
		$ct_title = $GLOBALS[lib_common]->make_link($fav_ct_value[name] . "&nbsp;", "{$DIRS[favorite_link]}favorite_input_form.php?serial_category={$fav_ct_value[serial_num]}", "_nw", "ct_input,10,10,550,600,1,0,1,0");
		$P_ct_title = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td><b><u>$ct_title</u></b></td>
					<td align=right>
						<a href=\"javascript:verify_submit_sort('sort_up_ct', '{$fav_ct_value[serial_num]}', '')\">{$IS_btns[sort_left]}</a>
						<a href=\"javascript:verify_submit_sort('sort_down_ct', '{$fav_ct_value[serial_num]}', '')\">{$IS_btns[sort_right]}</a>
					</td>
				</tr>
			</table>
		";
		$ct_links = "
			<table width=100% cellpadding=3 cellspacing=0 border=0>
		";
		$query = "select * from $DB_TABLES[fav_link] where serial_category='$fav_ct_value[serial_num]' order by sort asc";
		$result_links = $GLOBALS[lib_common]->querying($query);
		while ($fav_links = mysql_fetch_array($result_links)) {
			$ct_links .= "
				<tr>
					<td>
						<a href=\"javascript:verify_submit_sort('sort_up_link', '{$fav_ct_value[serial_num]}', '{$fav_links[serial_link]}')\">{$IS_btns[sort_up]}</a>
						<a href=\"javascript:verify_submit_sort('sort_down_link', '{$fav_ct_value[serial_num]}', '{$fav_links[serial_link]}')\">{$IS_btns[sort_down]}</a>
						<a href='http://" . str_replace("http://", '', $fav_links[link_url]) . "' target=_blank>{$fav_links[name]}</a>
					</td>
				</tr>";
		}
		$ct_links .= "
			</table>
		";
		$T_category_list[] = $lib_insiter->w_get_img_box($skin_dir, $ct_links, $IS_input_box_padding, array("title"=>$P_ct_title));
	}

	// 각 분류에 링크 목록 대입하고 테이블에 삽입
	$ct_list_nums = sizeof($T_category_list);
	$line_per_ct = 5;
	$width = " width='" . 100 / $line_per_ct . "%'";
	$P_category_list = "
			<table cellpadding=2 cellspacing=0 border=0 width=100%>
				<form name=frm method=post action='{$DIRS[favorite_link]}favorite_input.php' onsubmit='return verify_submit_add_ct(this)' enctype='multipart/form-data'>
				<input type=hidden name='proc_mode' value=''>
				<input type=hidden name='return_page' value='$return_page'>
				<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
				<input type=hidden name='serial_category' value=''>
				<input type=hidden name='serial_link' value=''>
	";
	for ($i=0; $i<$ct_list_nums; $i++) {
		$count = $i + 1;
		$left_value = $count % $line_per_ct;
		if ($left_value == 1) $P_category_list .= "
				<tr>
		";
		if ($count == $ct_list_nums && $left_value != 0) {
			$tail_td_nums = $line_per_ct - ($count % $line_per_ct);
			$td_tail = "<td colspan='$tail_td_nums' bgcolor=ffffff></td>";
		}
		$P_category_list .= "
					<td valign='top' bgcolor=ffffff{$width}>
						{$T_category_list[$i]}
					</td>
				$td_tail
		";
		if ($count % $line_per_ct == 0) {
			$P_category_list .= "
				</tr>
			";
		}
	}
	$P_category_list .= "
				</form>
			</table>
	";
	$P_category_list = "
	<tr><td height=10></td></tr>
	<tr>
		<td>
			" . $lib_insiter->w_get_img_box("thin_skin_round_title", $P_category_list, $IS_input_box_padding, array("title"=>"<b>분류별 즐겨찾기 목록</b> - 분류 이름을 클릭하시면 세부 링크를 작성할 수 있습니다.")) . "			
		</td>
	</tr>
	";
}

echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td>$P_input_form</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_input_form_category</td>
	</tr>
	$P_category_list
	<tr><td height=5></td></tr>
	<tr>
		<td align=center><input type=button value='즐겨찾기보기' onclick=\"document.location.href='$FAV_link_view'\" class=designer_button></td>
	</tr>
</table>
<script language='javascript1.2'>
<!--
	function verify_submit_add_ct(form) {
		if (form.ct_name.value == '') {
			alert('분류명을 입력하세요');
			form.ct_name.focus();
			return false;
		}
	}
	function verify_submit_sort(mode, serial_category, serial_link) {
		form = document.frm;
		form.serial_category.value = serial_category;
		form.serial_link.value = serial_link;
		form.proc_mode.value = mode;
		form.submit();
	}
//-->
</script>
");

?>