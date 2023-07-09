<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다
if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "그림") {
		$pp_define = array("width", "height", "border", "align");
		$pp_img = $GLOBALS[lib_common]->parse_property($exp[4], " ", "=", $pp_define);
		$pp_img_width = $pp_img[width];
		$pp_img_height = $pp_img[height];
		$pp_img_align = $pp_img[align];
		$pp_img_border = $pp_img[border];
		$pp_img_etc = $pp_img[etc];
		$pp_img_src = $exp[3];
	}
}

$FL_upload_image = 'Y';
include "./include/pp_form_img.inc.php";	 // $P_form_img 이미지 넘어옴
$P_img_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_img, $IS_input_box_padding, array("title"=>"이미지속성 입력"));

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	이 파일을 업로드 합니다.
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));


echo("
<script language='javascript1.2'>
<!--
	function verify_submit() {
		form = document.frm;
		if (form.userfile.value == '' &&  form.pp_img_src.value == '') {
			alert('업로드할 그림을 선택하세요');
			return false;
		}
		form.submit();
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_image_manager.php' enctype='multipart/form-data' onsubmit='verify_submit(); return false;'>
	<input type=hidden name=design_file value='$design_file'>
	<input type=hidden name=index value='$index'>
	<input type=hidden name=current_line value='$current_line'>
	<input type=hidden name=cpn value='$cpn'>
	<tr>
		<td>
			$P_img_form
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
	<tr>
		<td>
			$P_form_blank
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>	
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>