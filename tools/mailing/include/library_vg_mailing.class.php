<?
class library_vg_mailing {
/*
	전용 라이브러리
*/
	function library_vg_mailing() {
		//$GLOBALS[lib_common] = $obj;
	}

	function get_sh_list($query, $total, $ppa=0, $page=1, $colspan) {
	global $lh_common, $vg_mailing_setup, $vg_mailing_file;
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
	while ($value = mysql_fetch_array($result)) {
		$virtual_num = $total - (($page-1)*$ppa) - $i;
		$send_num = sizeof(explode($vg_mailing_setup[divider], $value[sh_receivers]));
		$list .= "
									<tr bgcolor=white onmouseover=\"this.className='onmouseover';\" onmouseout=\"this.className='onmouseout';\">
										<td align=center>$virtual_num</td>
										<td><a href='{$vg_mailing_file[history_view]}&sh_serial=$value[sh_serial]'>" . stripslashes($value[sh_subject]) . "</a></td>
										<td>" . number_format($send_num) . "</td>
										<td>" . date("Y-m-d h:i:s", $value[sign_date]) . "</td>
									</tr>
		";
		$i++;
	}	// while end	
	if ($i == 0) {
		$list = "
										<tr bgcolor=ffffff>
											<td colspan={$colspan}>검색된 고객정보 없음</td>
										</tr>
		";
	}
	mysql_free_result($result);
	$return_value = array($list);
	return $return_value;
}

}
?>