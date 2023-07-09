<?
class library_vg_op {

/*
	공용 함수 클래스
*/

	function library_vg_op() {
		// nothing
	}
	
	// 설문 문항 추출
	function get_que_list($title_num, $list_setup) {
		global $VG_OP_db_table, $lh_common, $VG_OP_dir_info;
		if ($list_setup[skin] == '') $skin = "default";
		else $skin = $list_setup[skin];
		$op_gp_info = $lh_common->get_data($VG_OP_db_table[title_list], "serial_num", $title_num);
		
		if ($list_setup[type] != "result") {
			if ($op_gp_info[method] == 'R') {
				$input_type = "radio";
				$sb_name = "sb_box";
				$def_pp = "class=input_radio";
			} else {
				$input_type = "checkbox";
				$sb_name = "sb_box[]";
				$def_pp = "class=input_checkbox";
			}
			$skin_file_name = "que.html";
		} else {
			$query = "select sum(count) from $VG_OP_db_table[que_list] where title_num=$title_num";
			$result = $lh_common->querying($query);
			$count_sum = mysql_result($result, 0, 0);
			$skin_file_name = "result.html";
		}

		$query = "select * from $VG_OP_db_table[que_list] where title_num=$title_num order by que_num asc";
		$result = $lh_common->querying($query);
		$que_num = mysql_num_rows($result);

		$list = $i = '';
		while ($value = mysql_fetch_array($result)) {
			$i++;
			$subject = stripslashes($value[subject]);
			if ($list_setup[type] != "result") {
				$select_box = $lh_common->make_input_box('', $sb_name, $input_type, $def_pp, '', $value[serial_num]);
				$list .= "
					<tr>
						<td width=20>$select_box</td>
						<td>$subject</td>
					</tr>
				";
			} else {
				$percent = ($value[count] * 100) / $count_sum;
				$list .= "
					<tr>
						<td>$i</td>
						<td>$subject</td>
						<td width=100><table width=100% cellpadding=0 cellspacing=1 bgcolor=cccccc><tr><td bgcolor=ffffff><img src={$VG_OP_dir_info[root]}images/bg_poll1.gif width=$percent border=0 height=10></td></tr></table></td>
						<td>" . number_format($value[count]) . "</td>
						<td>(" . number_format($percent) . "%)</td>
					</tr>
				";
			}
		}
		$skin_dir = $VG_OP_dir_info[skin] . $skin;
		$skin_file = $skin_dir . '/' . $skin_file_name;
		if (file_exists($skin_file)) {			
			$fp = @fopen($skin_file, "r");
			$skin_contents = @fread($fp, 10000);
			@fclose ($fp);
			$content = str_replace("%I_PATH%", $skin_dir, $skin_contents);
			$content = str_replace("%SUBJECT%", $op_gp_info[subject], $content);
			$content = str_replace("%QUE_LIST%", $list, $content);
			$content = str_replace("%COUNT_SUM%", $count_sum, $content);

		} else {
			$content = $list;
		}
		return array($op_gp_info, $content, $que_num);
	}

	// 설문 그룹 목록
	function get_op_list($query, $total, $ppa=0, $page=1, $colspan='5') {
		global $VG_OP_dir_info, $VG_OP_user_info, $lh_common, $VG_OP_db_table;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $lh_common->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		$i = 0;
		$print_value = '';
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			$subject = stripslashes($value[subject]);
			$subject = $lh_common->make_link($subject, "index.php?VG_OP_file_name=view.php&title_num=$value[serial_num]", "_nw", "win_input,10,10,500,350,0,1,1,0");
			$sign_date = date("y-m-d", $value[sign_date]);
			$que_num = mysql_result(mysql_query("select count(serial_num) from $VG_OP_db_table[que_list] where title_num='$value[serial_num]'"), 0, 0);
			$auth_method_array = array(array('L', '1', $VG_OP_user_info[level], 'E'));
			if ($lh_common->auth_process($auth_method_array)) {
				//$btn_modify = " <input type='button' value='수정' class='input_button' onclick=\"javascript:window.open('{$VG_OP_dir_info[root]}?VG_OP_file_name=input_form.php&title_num=$value[serial_num]', 'win_input', 'left=10,top=10,width=800,height=700,scrollbars=1,resizable=1').focus()\">";
				$btn_modify = " <input type='button' value='수정' class='input_button' onclick=\"document.location.href='{$VG_OP_dir_info[root]}?VG_OP_file_name=input_form.php&title_num=$value[serial_num]'\">";
				$btn_delete = " <input type='button' value='삭제' class='input_button' onclick=\"javascript:verify_delete($value[serial_num])\">";
				$admin_btn = "
												<table>
													<tr>
														<td>$btn_modify $btn_delete</td>
													</tr>
												</table>
				";
			}
			$print_value .= "
										<tr bgcolor=ffffff align=center>
											<td>$virtual_num</td>
											<td align=left>$subject</td>
											<td>$que_num</td>
											<td>$sign_date</td>
											<td>$admin_btn</td>
										</tr>
			";
			$i++;
		}	// while end	
		if ($i == 0) {
			$print_value .= "
										<tr bgcolor=ffffff>
											<td colspan={$colspan} align=center height=50>검색된 정보가 없습니다.</td>
										</tr>
			";
		} else {
			$print_value .= "
				<script language='javascript1.2'>
				<!--
				function verify_delete(title_num) {
					if (confirm('선택한 정보를 삭제하시겠습니까?')) {
						url = '{$VG_OP_dir_info[root]}input.php?VG_OP_mode=delete&title_num=' + title_num;
						window.open(url, 'temp','top=7000,left=7000,width=0,height=0');
					}
				}
				//-->
				</script>
			";
		}
		mysql_free_result($result);
		return array($print_value);
	}
}
?>