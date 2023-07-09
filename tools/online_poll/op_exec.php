<?
$VG_OP_dir_site_root = "../../";
include "config.inc.php";
if (!is_array($sb_box)) {	// 라디오버튼인경우
	$query = "update $VG_OP_db_table[que_list] set count=count+1 where serial_num='$sb_box'";
	$result = $lh_common->querying($query);
} else {									// 체크상자인경우
	for ($i=0; $i<sizeof($sb_box); $i++) {
		$query = "update $VG_OP_db_table[que_list] set count=count+1 where serial_num='{$sb_box[$i]}'";
		
		$result = $lh_common->querying($query);
	}
}
$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=view.php&title_num=$title_num");
?>