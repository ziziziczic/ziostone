<?
$root = "../../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$root}logistics1/config.inc.php";
include("xmlrpc.inc");
include("xmlrpcs.inc");

// 원격지 지입 정보등록
$jiib_info_add_sig = array(array($xmlrpcStruct, $xmlrpcStruct));
$jiib_info_add_doc = "지입정보 등록";
function jiib_info_add($remote_msg) {
	global $DB_TABLES;
	$rv = php_xmlrpc_decode($remote_msg);

	$remote_record = array();
	while (list($key, $value) = each($rv[0])) $remote_record[$key] = base64_decode($value);

	// 암호확인등을 위해 매니저정보추출
	$manager_info = $GLOBALS[lib_common]->get_data($DB_TABLES[member], "serial_num", $remote_record[serial_member]);
	$manager_info = $manager_info + $GLOBALS[lib_common]->get_data($DB_TABLES[manager_info], "serial_member", $remote_record[serial_member]);
	if ($manager_info[sync_pw] != '' && ($manager_info[sync_pw] != $remote_record[sync_pw])) return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"X")));

	switch ($remote_record[category]) {
		case "sell" :
			$table_name = $DB_TABLES[jiib_sell];
		break;
		case "jiib" :
			$table_name = $DB_TABLES[jiib_jiib];
		break;
		case "drivers" :
			$table_name = $DB_TABLES[jiib_driver];
		break;
	}
	
	// 불필요한 필드 제거
	unset($remote_record[sync_pw], $remote_record[category]);

	// 정보등록
	$exp_gugun = explode(' ', $remote_record[gugun]);
	$remote_record[gugun] = $exp_gugun[0];
	$new_serial_num = $GLOBALS[lib_common]->input_record($table_name, $remote_record, 'Y');

	// 거래처에게 오더 전송
	$title_broadcast = "{$remote_record[title]}, {$remote_record[pay]}만({$remote_record[pay_method]}), {$remote_record[first]}만원";
	broadcast($DB_TABLES[jiib_sell], $new_serial_num, $title_broadcast, '', $manager_info);

	if ($new_serial_num > 0) {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"Y", "serial_num"=>$new_serial_num)));
	} else {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"N")));
	}
}
// 지입정보 수정
$jiib_info_modify_sig = array(array($xmlrpcStruct, $xmlrpcStruct));
$jiib_info_modify_doc = "지입정보 수정";
function jiib_info_modify($remote_msg) {
	global $DTDR;
	$err = '';
	$rv = php_xmlrpc_decode($remote_msg);
	$jiib_info = array();
	$jiib_info[category_1] = $rv[0][category_1];
	$jiib_info[car_type_1] = $rv[0][car_type_1];
	$jiib_info[car_type_2] = $rv[0][car_type_2];
	$jiib_info[sido] = $rv[0][sido];
	$jiib_info[gugun] = $rv[0][gugun];
	$jiib_info[title] = $rv[0][title];
	$jiib_info[car] = $rv[0][car];
	$jiib_info[item] = $rv[0][item];
	$jiib_info[start] = $rv[0][start];
	$jiib_info[dest] = $rv[0][dest];
	$jiib_info['time'] = $rv[0]['time'];
	$jiib_info[time_etc] = $rv[0][time_etc];
	$jiib_info[holi] = $rv[0][holi];
	$jiib_info[pay] = $rv[0][pay];
	$jiib_info[pay_method] = $rv[0][pay_method];
	$jiib_info[support] = $rv[0][support];
	$jiib_info[first] = $rv[0][first];
	$jiib_info[money] = $rv[0][money];
	$jiib_info[divide] = $rv[0][divide];
	$jiib_info[insur] = $rv[0][insur];
	$jiib_info[age_s] = $rv[0][age_s];
	$jiib_info[age_e] = $rv[0][age_e];
	$jiib_info[upload_files] = $rv[0][upload_files];
	$jiib_info[detail] = $rv[0][detail];
	$jiib_info[staff_name] = $rv[0][staff_name];
	$jiib_info[staff_company] = $rv[0][staff_company];
	$jiib_info[staff_phone] = $rv[0][staff_phone];
	$jiib_info[staff_phone_mobile] = $rv[0][staff_phone_mobile];
	$jiib_info[staff_email] = $rv[0][staff_email];
	$jiib_info[staff_homepage] = $rv[0][staff_homepage];
	$jiib_info[staff_image] = $rv[0][staff_image];
	$jiib_info[state_S] = $rv[0][state_S];
	$jiib_info[date_sign] = $rv[0][date_sign];
	$jiib_info[date_sort] = $rv[0][date_sort];
	$jiib_info[date_modify] = $rv[0][date_modify];
	$jiib_info[priority] = $rv[0][priority];
	$jiib_info[is_private] = $rv[0][is_private];
	$jiib_info[plus_close] = $rv[0][plus_close];
	$jiib_info[color_close] = $rv[0][color_close];
	$jiib_info[color_info] = $rv[0][color_info];
	$jiib_info[bold_close] = $rv[0][bold_close];
	$jiib_info[moveup_close] = $rv[0][moveup_close];			
	$jiib_info[icon_close] = $rv[0][icon_close];
	$jiib_info[icon_info] = $rv[0][icon_info];
	$jiib_info_1 = array();
	while (list($key, $value) = each($jiib_info)) {
		$jiib_info_1[$key] = base64_decode($value);
	}
	$result = $GLOBALS[lib_common]->modify_record($DTDR[jiib_info], "serial_num", base64_decode($rv[0][serial_num]), $jiib_info_1);
	if (mysql_affected_rows() > 0) {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"Y")));
	} else {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"N")));
	}
}
// 지입정보 삭제
$jiib_info_delete_sig = array(array($xmlrpcStruct, $xmlrpcStruct));
$jiib_info_delete_doc = "지입정보 삭제";
function jiib_info_delete($remote_msg) {
	global $DTDR;
	$err = '';
	$rv = php_xmlrpc_decode($remote_msg);
	$serial_num = base64_decode($rv[0][serial_num]);
	$query = "delete from $DTDR[jiib_info] where serial_num='$serial_num'";			// 지입정보 삭제
	$result = $GLOBALS[lib_common]->querying($query);
	if (mysql_affected_rows() > 0) {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"Y")));
	} else {
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"N")));
	}
}

// 파일업로드
$file_upload_add_sig = array(array($xmlrpcStruct, $xmlrpcStruct));
$file_upload_add_doc = "파일업로드";
function file_upload($remote_msg) {
	global $DIRS;
	$err = '';
	$rv = php_xmlrpc_decode($remote_msg);
	$upload_path = $rv[0][path];
	for ($i=0; $i<sizeof($rv[0][nums]); $i++) {
		$key_name = "name_{$i}";
		$key_contents = "contents_{$i}";
		$file_path_full = $upload_path . $rv[0][$key_name];
		if (!$handle = fopen($file_path_full, 'a')) {
				echo "Cannot open file ($file_path_full)";
				exit;
		}
		if (fwrite($handle, base64_decode($rv[0][$key_contents])) === FALSE) {
			 echo "Cannot write to file ($file_path_full)";
			 exit;
		}
		fclose($handle);
		return new xmlrpcresp(php_xmlrpc_encode(array("ok"=>"Y")));
	}
}

$server = new xmlrpc_server(array(
	"server.jiib_info_add" => array(
		"function" => "jiib_info_add",
		"signature" => $jiib_info_add_sig,
		"docstring" => $jiib_info_add_doc
	),
	"server.jiib_info_modify" => array(
		"function" => "jiib_info_modify",
		"signature" => $jiib_info_modify_sig,
		"docstring" => $jiib_info_modify_doc
	),
	"server.jiib_info_delete" => array(
		"function" => "jiib_info_delete",
		"signature" => $jiib_info_delete_sig,
		"docstring" => $jiib_info_delete_doc
	),
	"server.file_upload" => array(
		"function" => "file_upload",
		"signature" => $file_upload_sig,
		"docstring" => $file_upload_doc
	)
));
?>
