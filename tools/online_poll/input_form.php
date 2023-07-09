<?
$auth_method_array = array(array('L', '1', $VG_OP_user_info[level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) $lh_common->die_msg("관리자만 가능합니다.", '');
if ($_GET[title_num] != '') {
	$VG_OP_site_info = $lh_common->get_data($VG_OP_db_table[title_list], "serial_num", $_GET[title_num]);
	$VG_OP_mode = "mod_op_gp";
	if ($VG_OP_site_info[ing] == 'Y') {
		$btn_switch = "<input type='button' value='완료시킴' class='input_button' onclick=\"javascript:verify_op_switch($value[serial_num])\">";
		$sw_code = 'N';
	} else {
		$btn_switch = "<input type='button' value='진행시킴' class='input_button' onclick=\"javascript:verify_op_switch($value[serial_num])\">";
		$sw_code = 'Y';
	}
} else {
	$VG_OP_mode = "add_op_gp";
	$VG_OP_site_info[method] = 'R';
}


?>
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.subject.value == '') {
			alert("제목을 입력하세요");
			form.subject.focus();
			return false;
		}
	}

	function verify_delete_que(serial_num) {
		if (confirm("삭제하시겠습니까?")) {
			document.location.href='input.php?VG_OP_mode=delete_que&title_num=<?echo($VG_OP_site_info[serial_num])?>&serial_num=' + serial_num;
		}
	}

	function verify_op_switch() {
		if (confirm("변경하시겠습니까?")) {
			document.location.href='input.php?VG_OP_mode=change_op&title_num=<?echo($VG_OP_site_info[serial_num])?>&sw_code=<?echo($sw_code)?>';
		}
	}


//-->
</script>

<table border="0" cellpadding="7" cellspacing="0" width="680">
	<form name=frm method=post action='input.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type=hidden name='title_num' value='<?echo($VG_OP_site_info[serial_num])?>'>
	<input type=hidden name='VG_OP_mode' value='<?echo($VG_OP_mode)?>'>
	<tr>
		<td width="100%" height="16"># 설문그룹정보</td>
	</tr>
	<tr>
		<td width="100%" height="16">
			<table border="0" cellpadding="5" cellspacing="1" width="100%" bgcolor="#CDCDCD">
				<tr>
					<td width="50" bgcolor="#F6F6F6">제목</td>
					<td bgcolor="#FFFFFF">
<? echo($lh_common->make_input_box($VG_OP_site_info[subject], "subject", "text", "size=60 maxlength=50 class=input_text", '', '')); ?>
					</td>
				</tr>
				<tr>
					<td bgcolor="#F6F6F6">방식</td>
					<td bgcolor="#FFFFFF">
<? echo($lh_common->make_input_box($VG_OP_site_info[method], "method", "radio", "class=input_radio", '', 'R') . "단일선택(라디오버튼) "); ?>
<? echo($lh_common->make_input_box($VG_OP_site_info[method], "method", "radio", "class=input_radio", '', 'C') . "다중선택(체크버튼)"); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="16" align=right>
			<table width=100%>
				<tr>
					<td>
						<input type='submit' value='저장하기'>
						<input type='button' value='리셋' onclick='this.form.reset()'>
						<?echo($btn_switch)?>
					</td>
					<td>&nbsp;</td>
					<td align=right><input type='button' value='목록보기' onclick="document.location.href='index.php'"> <input type='button' value='새설문등록' onclick="document.location.href='index.php?VG_OP_file_name=input_form.php'"></td>
				</tr>
			</table>
		</td>
	</tr>
	</form>
<?
if ($VG_OP_site_info[serial_num] != '') {
?>
	<tr><td height="16"># 문항추가</td></tr>
	<tr>
		<td width="100%" height="16">
			<table border="0" cellpadding="5" cellspacing="1" width="100%" bgcolor="#CDCDCD">
				<form name=frm_add_que method=post action='input.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
				<input type=hidden name='title_num' value='<?echo($VG_OP_site_info[serial_num])?>'>
				<input type=hidden name='VG_OP_mode' value='add_op_que'>
				<tr bgcolor=#F6F6F6 align=center>
					<td width=50>번호</td>
					<td>제목</td>
					<td>투표수</td>
					<td>&nbsp;</td>
				</tr>
<?
	echo("
				<tr>
					<td width=50 bgcolor=#F6F6F6>
		" . $lh_common->make_input_box('', "que_num", "text", "size=5 class=input_text", '', '') . "
					</td>
					<td bgcolor=#FFFFFF>
		" . $lh_common->make_input_box('', "subject", "text", "size=60 class=input_text", '', '') . "
					</td>
					<td bgcolor=#FFFFFF>
		" . $lh_common->make_input_box('', "count", "text", "size=5 class=input_text", '', '') . "
					</td>
					<td bgcolor=#FFFFFF><input type='submit' value='추가'></td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
	");

	$query = "select * from $VG_OP_db_table[que_list] where title_num='$title_num' order by que_num asc";
	$result = $lh_common->querying($query);
	$total_q_num = mysql_num_rows($result);
	$q_list_tag = $serial_nums = '';
	while ($value = mysql_fetch_array($result)) {
		$serial_nums .= $value[serial_num] . ',';
		$q_num_name = "q_num_" . $value[serial_num];
		$q_subject_name = "q_subject_" . $value[serial_num];
		$q_count_name = "q_count_" . $value[serial_num];
		$q_list_tag .= "
				<tr bgcolor=ffffff>
					<td width=50 bgcolor=#F6F6F6>
		" . $lh_common->make_input_box($value[que_num], $q_num_name, "text", "size=5 class=input_text", '', '') . "
					</td>
					<td bgcolor=#FFFFFF>
		" . $lh_common->make_input_box($value[subject], $q_subject_name, "text", "size=60 class=input_text", '', '') . "
					</td>
					<td bgcolor=#FFFFFF>
		" . $lh_common->make_input_box($value[count], $q_count_name, "text", "size=5 class=input_text", '', '') . "
					</td>
					<td><input type='button' value='삭제' class='input_button' onclick=\"javascript:verify_delete_que($value[serial_num])\"></td>
				</tr>
		";
	}
	$serial_nums = substr($serial_nums, 0, -1);
	if ($q_list_tag != '') {
		echo("
	<tr><td height='16'># 저장된 문항</td></tr>
	<tr>
		<td>
			<table border=0 cellpadding=5 cellspacing=1 width=100% bgcolor=#CDCDCD>
				<form name=frm_mod_que method=post action='input.php'>
				<input type=hidden name='title_num' value='$VG_OP_site_info[serial_num]'>
				<input type=hidden name='VG_OP_mode' value='mod_op_que'>
				<input type=hidden name='serial_nums' value='$serial_nums'>
				<tr bgcolor=f3f3f3 align=center>
					<td>순번</td>
					<td>문항제목</td>
					<td>투표수</td>
					<td>삭제</td>
				</tr>
				$q_list_tag
				<tr><td colspan=5 bgcolor=ffffff align=center height=40><input type=submit value='문항일괄수정'></td></tr>
				</form>
			</table>
		</td>
	</tr>
		");
	}
}
?>
</table>
</form>