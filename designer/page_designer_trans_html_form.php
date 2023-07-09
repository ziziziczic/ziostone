<?
include "header_sub.inc.php";

if ($_COOKIE[VG_save_source_image_dir] != '') $source_image_dir = $_COOKIE[VG_save_source_image_dir];
else $source_image_dir = "images";
if ($_COOKIE[VG_save_target_image_dir] != '') $target_image_dir = $_COOKIE[VG_save_target_image_dir];
else $target_image_dir = $GLOBALS[VI][default_file_dir];

if ($_COOKIE[VG_is_title_body] != '') {
	$is_title_body = $_COOKIE[VG_is_title_body];
} else {
	if ($site_page_info[type] == 'S') $is_title_body = 'Y';
}
if ($_COOKIE[VG_is_del_link] != '') $is_del_link = $_COOKIE[VG_is_del_link];

echo("
<table cellspacing='0' cellpadding='0' width='100%' height='700' border='0'>
<form method='post' action='page_designer_trans_html_manager.php'>
<input type='hidden' name='design_file' value='$design_file'>
	<tr> 
		<td valign='top' colspan='2'> 
			" . $GLOBALS[lib_common]->make_input_box('', "html_source", "textarea", "class='designer_textarea' wrap='off'", "width:100%;height:100%", "") . "
		</td>
	</tr>
	<tr height='30'>
		<td>&nbsp;
			<font color='#CC0000'><b>소스이미지경로</b></font>" . $GLOBALS[lib_common]->make_input_box($source_image_dir, "source_image_dir", "text", "size=40 maxlength=100 class='designer_text'", "", "") . "
			<font color='#CC0000'><b>대상이미지경로</b></font>" . $GLOBALS[lib_common]->make_input_box($target_image_dir, "target_image_dir", "text", "size=40 maxlength=100 class='designer_text'", "", "") . "
			" . $GLOBALS[lib_common]->make_input_box($is_title_body, "is_title_body", "checkbox", "class='designer_checkbox'", "", "Y") . "헤더저장
			" . $GLOBALS[lib_common]->make_input_box($is_del_link, "is_del_link", "checkbox", "class='designer_checkbox'", "", "Y") . "링크제거
		</td>
		<td width=180 align=right>
			<input type='submit' value='변환'>
			<input type='reset' value='다시'>
			<input type='button' value='창닫기' onclick='self.close()'>
		</td>
	</tr>
</form>
</table>
</body>
");
include "footer_sub.inc.php";
?>