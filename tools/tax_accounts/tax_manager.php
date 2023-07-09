<?
include "include/manager_header.inc.php";
$auth_method_array = array(array('L', '1', $vg_tax_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("권한이 없습니다.");;
include "{$vg_tax_dir_info['include']}post_var_filter.inc.php";

if ($mode == "buyer") {	// 고객정보 편집
	switch ($mode_1) {
		case "add" :
			$biz_b_number = $biz_b_number_1 . $biz_b_number_2 . $biz_b_number_3;
			$query = "select * from $vg_tax_db_tables[buyer_list] where biz_number='$biz_b_number'";
			$result = $lh_common->querying($query);
			$verify_dups = mysql_num_rows($result);
			if ($verify_dups > 0) {
				$dups_value = mysql_fetch_array($result);
				$lh_common->alert_url("사업자번호 : $dups_value[biz_number] 중복오류");
			}
			$query = "select max(serial_num) from $vg_tax_db_tables[buyer_list]";
			$result = $lh_common->querying($query);
			$new_serial_num = mysql_result($result, 0, 0) + 1;
			$buyer_info = array();
			$buyer_info[serial_num] = $new_serial_num;
			if ($buyer_id == '') $buyer_id = $new_serial_num;
			$buyer_info[buyer_id] = $buyer_id;
			$buyer_info[biz_number] = $biz_b_number;
			$buyer_info[biz_name] = $biz_b_name;
			$buyer_info[biz_ceo] = $biz_b_ceo;
			$buyer_info[biz_address] = $biz_b_address;
			$buyer_info[biz_cond] = $biz_b_cond;
			$buyer_info[biz_type] = $biz_b_type;
			$buyer_info[biz_email] = $biz_b_email;
			$buyer_info[biz_fax] = $biz_b_fax;
			$buyer_info[biz_inc] = $biz_tax_inc;
			$buyer_info[sign_date] = $GLOBALS[w_time];
			$lh_common->input_record($vg_tax_db_tables[buyer_list], $buyer_info);
			$lh_common->alert_url('', 'E', $vg_tax_file[tax_list] . "&buyer_serial_num={$buyer_info[serial_num]}");
		break;
		case "modify" :
			$biz_b_number = $biz_b_number_1 . $biz_b_number_2 . $biz_b_number_3;
			$query = "update $vg_tax_db_tables[buyer_list] set buyer_id='$buyer_id', biz_number='$biz_b_number', biz_name='$biz_b_name', biz_ceo='$biz_b_ceo', biz_cond='$biz_b_cond', biz_type='$biz_b_type', biz_email='$biz_b_email', biz_fax='$biz_b_fax', biz_inc='$biz_tax_inc' where serial_num='$buyer_serial'";
			$lh_common->querying($query);
			$lh_common->alert_url('', 'E', $vg_tax_file[tax_list] . "&buyer_serial_num={$buyer_serial}&page=$page");
		break;
		case "delete" :
			$query = "delete from $vg_tax_db_tables[buyer_list] where serial_num='$buyer_serial_num'";
			$result = $lh_common->querying($query);
			$lh_common->alert_url('', 'E', $vg_tax_file[buyer_list]);
		break;
	}
} else {									// 계산서 정보 편집
	switch ($mode_1) {
		case "add" :
			$query = "select max(serial_num) from $vg_tax_db_tables[tax_list]";
			$result = $lh_common->querying($query);
			$new_serial_num = mysql_result($result, 0, 0) + 1;
			$tax_info = array();
			$tax_info[serial_num] = $new_serial_num;
			$tax_info[biz_a_name] = $biz_a_name;
			$tax_info[biz_a_number] = $biz_a_number_1 . $biz_a_number_2 . $biz_a_number_3;
			$tax_info[biz_a_ceo] = $biz_a_ceo;
			$tax_info[biz_a_address] = $biz_a_address;
			$tax_info[biz_a_cond] = $biz_a_cond;
			$tax_info[biz_a_type] = $biz_a_type;
			$tax_info[biz_b_serial] = $buyer_serial;
			$tax_info[biz_b_name] = $biz_b_name;
			$tax_info[biz_b_number] = $biz_b_number_1 . $biz_b_number_2 . $biz_b_number_3;
			$tax_info[biz_b_ceo] = $biz_b_ceo;
			$tax_info[biz_b_address] = $biz_b_address;
			$tax_info[biz_b_cond] = $biz_b_cond;
			$tax_info[biz_b_type] = $biz_b_type;
			$tax_info[biz_b_email] = $biz_b_email;
			$tax_info[biz_b_fax] = $biz_b_fax;
			$tax_info[biz_issue_date] = $biz_issue_date;
			$tax_info[biz_goods] = $biz_goods;
			$tax_info[biz_amount] = $biz_amount;
			$tax_info[biz_receipt] = $biz_receipt;
			$tax_info[biz_tax_inc] = $biz_tax_inc;
			$tax_info[sign_date] = $GLOBALS[w_time];
			$lh_common->input_record($vg_tax_db_tables[tax_list], $tax_info);
			$lh_common->alert_url('', 'E', $vg_tax_file[tax_view] . "&tax_serial_num={$new_serial_num}&buyer_serial=$buyer_serial");
		break;
		case "modify" :
			$biz_a_number = $biz_a_number_1 . $biz_a_number_2 . $biz_a_number_3;
			$biz_b_number = $biz_b_number_1 . $biz_b_number_2 . $biz_b_number_3;
			$query = "update $vg_tax_db_tables[tax_list] set biz_a_name='$biz_a_name', biz_a_number='$biz_a_number', biz_a_ceo='$biz_a_ceo', biz_a_address='$biz_a_address', biz_a_cond='$biz_a_cond', biz_a_type='$biz_a_type', biz_b_name='$biz_b_name', biz_b_number='$biz_b_number', biz_b_ceo='$biz_b_ceo', biz_b_address='$biz_b_address', biz_b_cond='$biz_b_cond', biz_b_type='$biz_b_type', biz_b_email='$biz_b_email', biz_b_fax='$biz_b_fax', biz_issue_date='$biz_issue_date', biz_goods='$biz_goods', biz_amount='$biz_amount', biz_receipt='$biz_receipt', biz_tax_inc='$biz_tax_inc' where serial_num='$tax_serial_num'";
			$lh_common->querying($query);
			$lh_common->alert_url('', 'E', $vg_tax_file[tax_list] . "&mode_1=modify&tax_serial_num={$tax_serial_num}&page=$page");
		break;
		case "delete" :
			$query = "delete from $vg_tax_db_tables[tax_list] where serial_num='$tax_serial_num'";
			$result = $lh_common->querying($query);
			$lh_common->alert_url('', 'E', $vg_tax_file[tax_list] . "&bbn=$bbn");
		break;
		case "send_email" :
			$saved_tax_info = $lh_common->get_data($vg_tax_db_tables[tax_list], "serial_num", $tax_serial_num);
			$mail_subject = "{$vg_tax_biz_info[name]}에서 발행된 세금계산서";
			$vg_tax_file_tax_view = substr($vg_tax_file[tax_view], strlen($vg_tax_dir_site_root));
			$vg_tax_dir_images = substr($vg_tax_dir_info[images], strlen($vg_tax_dir_site_root));
			$mail_contents = "
				아래의 버튼을 클릭하신후 인쇄하셔서 사용하시면 됩니다.
				<br><br><a href='http://{$SERVER_NAME}/{$vg_tax_file_tax_view}&tax_serial_num=$saved_tax_info[serial_num]&tsd=$saved_tax_info[sign_date]&bid=$saved_tax_info[biz_issue_date]' target=_blank><img src='http://{$SERVER_NAME}/{$vg_tax_dir_images}bt_voucher_tax.gif' border=0></a></center><br>
				감사합니다.
			";
			$mail_ok = $lh_common->mailer($vg_tax_biz_info[name], $vg_tax_biz_info[default_email], $saved_tax_info[biz_b_email], $mail_subject, $mail_contents, 1, '', "EUC-KR", '', '', $vg_tax_file[skin_mail], '', 'N', $saved_tax_info[biz_b_name], 'Y');
			if ($mail_ok) $msg = "발송되었습니다.";
			else $msg = "발송되지 않았습니다. 확인해 주세요.";
			$lh_common->alert_url($msg, 'E', '', '', "window.close()");
		break;
	}
}
?>