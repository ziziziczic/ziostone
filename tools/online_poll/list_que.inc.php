<?
if ($root == '') $VG_OP_dir_site_root = "../../";
else $VG_OP_dir_site_root = $root;
include "tools/online_poll/config.inc.php";

$query = "select * from $VG_OP_db_table[title_list] where ing='Y' order by sign_date desc";
$result = $lh_common->querying($query);
while ($value = mysql_fetch_array($result)) {
	$list_setup = array("skin"=>"default", "type"=>"user");
	$que_list = $lh_vg_op->get_que_list($value[serial_num], $list_setup);
	if ($que_list[0][method] == 'R') $submit_method = "return verify_submit_op_R(this, $que_list[2]);";
	else $submit_method = "return verify_submit_op_C(this, 'sb_box');";
	echo("	
	<form name=frm action='{$VG_OP_dir_info[root]}op_exec.php' method=post onsubmit=\"$submit_method\">
	<input type=hidden name=title_num value={$que_list[0][serial_num]}>
	$que_list[1]
	</form>
	");
}
?>
<script language='javascript1.2'>
<!--
	function verify_submit_op_R(form, que_num) {
		select_flag = 0;
		for (i=0; i<que_num; i++) if (form.sb_box[i].checked) select_flag = 1;
		if (select_flag != 1) {
			alert("항목을 선택하세요");
			return false;
		}
		win_input = window.open('', 'win_input', 'left=100,top=100,width=480,height=350');
		form.target = 'win_input';	
	}

	function verify_submit_op_C(form, box_name) {
		frm_els = form.elements;
		cnt = frm_els.length ;
		nm_cnt = box_name.length;
		select_flag = 0;
		for (i=0; i<cnt ; ++i) {
			if (frm_els[i].type == 'checkbox' && frm_els[i].name.substring(0, nm_cnt) == box_name) {	// 이름까지 비교.
				if (frm_els[i].checked) select_flag = 1;
			}
		}
		if (select_flag != 1) {
			alert("항목을 선택하세요");
			return false;
		}
		win_input = window.open('', 'win_input', 'left=100,top=100,width=480,height=350');
		form.target = 'win_input';
	}
//-->
</script>