<?
include "{$root}favorite_link/config.inc.php";

$auth_method_array = array(array('L', '7', $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

// 나만의 즐겨찾기
$T_category_list = array();
$P_category_list = '';
$query = "select * from $DB_TABLES[fav_category] where serial_member='$user_info[serial_num]' order by sort asc";
$result = $GLOBALS[lib_common]->querying($query);
if ($fav_config[skin] == '') $skin_dir = $FL_default_skin;
else $skin_dir = $fav_config[skin];
//if (mysql_num_rows($result) > 0) {
	// 분류별 링크목록 먼저 구함
	while ($fav_ct_value = mysql_fetch_array($result)) {
		$P_ct_title = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td><b>{$fav_ct_value[name]}</b></td>
				</tr>
			</table>
		";
		$ct_links = "
			<table width=100% cellpadding=2 cellspacing=0 border=0>
		";
		$query = "select * from $DB_TABLES[fav_link] where serial_category='$fav_ct_value[serial_num]' order by sort asc";
		$result_links = $GLOBALS[lib_common]->querying($query);
		while ($fav_links = mysql_fetch_array($result_links)) {
			$ct_links .= "
				<tr>
					<td>
						<a href='http://" . str_replace("http://", '', $fav_links[link_url]) . "' target=_blank>· {$fav_links[name]}</a>
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
			</table>
	";
	
	$P_category_list_title = "
		<table cellpadding=0 cellspacing=0 border=0 width=100%>
			<tr>
				<td><b>나만의 즐겨찾기</b></td>
				<td align=right><input type=button value='즐겨찾기관리' onclick=\"document.location.href='{$root}{$site_info[index_file]}?design_file=$FAV_link_setup'\" class=designer_button></td>
			</tr>
		</table>
	";
	$P_category_list = "
	<tr>
		<td>
			" . $lib_insiter->w_get_img_box("thin_skin_round_title", $P_category_list, $IS_input_box_padding, array("title"=>$P_category_list_title)) . "			
		</td>
	</tr>
	";
//}

// 공통 즐겨찾기 목록
$T_category_list = array();
$P_category_list_admin = '';
$query = "select * from $DB_TABLES[fav_category] where serial_member='$FL_default_fav' order by sort asc";
$result = $GLOBALS[lib_common]->querying($query);
if ($fav_config[skin] == '') $skin_dir = $FL_default_skin;
else $skin_dir = $fav_config[skin];
if (mysql_num_rows($result) > 0) {
	// 분류별 링크목록 먼저 구함
	while ($fav_ct_value = mysql_fetch_array($result)) {
		$P_ct_title = "
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td><b>{$fav_ct_value[name]}</b></td>
				</tr>
			</table>
		";
		$ct_links = "
			<table width=100% cellpadding=2 cellspacing=0 border=0>
		";
		$query = "select * from $DB_TABLES[fav_link] where serial_category='$fav_ct_value[serial_num]' order by sort asc";
		$result_links = $GLOBALS[lib_common]->querying($query);
		while ($fav_links = mysql_fetch_array($result_links)) {
			$ct_links .= "
				<tr>
					<td>
						<a href='http://" . str_replace("http://", '', $fav_links[link_url]) . "' target=_blank>· {$fav_links[name]}</a>
					</td>
				</tr>";
		}
		$ct_links .= "
			</table>
		";
		$T_category_list[] = $lib_insiter->w_get_img_box($FL_default_skin_admin, $ct_links, $IS_input_box_padding, array("title"=>$P_ct_title));
	}

	// 각 분류에 링크 목록 대입하고 테이블에 삽입
	$ct_list_nums = sizeof($T_category_list);
	$line_per_ct = 5;
	$width = " width='" . 100 / $line_per_ct . "%'";
	$P_category_list_admin = "
			<table cellpadding=2 cellspacing=0 border=0 width=100%>
	";
	for ($i=0; $i<$ct_list_nums; $i++) {
		$count = $i + 1;
		$left_value = $count % $line_per_ct;
		if ($left_value == 1) $P_category_list_admin .= "
				<tr>
		";
		if ($count == $ct_list_nums && $left_value != 0) {
			$tail_td_nums = $line_per_ct - ($count % $line_per_ct);
			$td_tail = "<td colspan='$tail_td_nums' bgcolor=ffffff></td>";
		}
		$P_category_list_admin .= "
					<td valign='top' bgcolor=ffffff{$width}>
						{$T_category_list[$i]}
					</td>
				$td_tail
		";
		if ($count % $line_per_ct == 0) {
			$P_category_list_admin .= "
				</tr>
			";
		}
	}
	$P_category_list_admin .= "
			</table>
	";
	$P_category_list_admin = "
	<tr><td height=10></td></tr>
	<tr>
		<td>
			" . $lib_insiter->w_get_img_box("halfsurface_darkblue_round_title", $P_category_list_admin, $IS_input_box_padding, array("title"=>"<b>공통 즐겨찾기</b> - {$site_info[site_name]} 에서 제공해 드리는 유용한 즐겨찾기 입니다.")) . "			
		</td>
	</tr>
	";
}

echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	$P_category_list
	$P_category_list_admin
</table>
");

?>