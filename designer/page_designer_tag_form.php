<?
include "header_sub.inc.php";

$P_page_designer_tag_form = "
<table border=0 cellpadding=5 cellspacing=1 width='100%' class=input_form_table>
	<form name='title' method='post' action='page_designer_tag_manager.php?design_file=$design_file'>
	<input type='hidden' name='allow_div' value='Y'>
	<input type='hidden' name='is_stripslashes' value='N'>
	<tr> 
		<td class='input_form_title' width=100>
			{$IS_icon[form_title]}���&��Ÿ&JS<br><br>
			{$IS_icon[form_title]}<a href='javascript:insert_system_style()'><u>���彺Ÿ�ϻ���</u></a><br>
			{$IS_icon[form_title]}<a href='javascript:insert_system_js()'><u>����JS����</u></a>
		</td>
		<td class=input_form_value_11px>
			" . $GLOBALS[lib_common]->make_input_box($site_page_info[tag_header], "tag_header", "textarea", "rows=10 cols=60 class='designer_textarea' wrap='off'", "width:100%", '', 'N') . "
		</td>
	</tr>
	<tr> 
		<td class='input_form_title'>{$IS_icon[form_title]}�ٵ�</td>
		<td class=input_form_value_11px>
			" . $GLOBALS[lib_common]->make_input_box($site_page_info[tag_body], "tag_body", "text", "size='80' class='designer_text'", "", "") . " &lt;body&gt; ���� �Է�
		</td>
	</tr>
	<tr> 
		<td class='input_form_title'>{$IS_icon[form_title]}�ٵ𳻺�&Map</td>
		<td class=input_form_value_11px>
			" . $GLOBALS[lib_common]->make_input_box($site_page_info[tag_body_in], "tag_body_in", "textarea", "rows=7 cols=60 class='designer_textarea' wrap='off'", "width:100%", '', 'N') . "
		</td>
	</tr>
	<tr> 
		<td class='input_form_title'>{$IS_icon[form_title]}�ٵ�ܺ�</td>
		<td class=input_form_value_11px>
			" . $GLOBALS[lib_common]->make_input_box($site_page_info[tag_body_out], "tag_body_out", "textarea", "rows=3 cols=60 class='designer_textarea' wrap='off'", "width:100%", '', 'N') . "
		</td>
	</tr>
	<tr> 
		<td class='input_form_title'>{$IS_icon[form_title]}�������ܺ�</td>
		<td class=input_form_value_11px>
			" . $GLOBALS[lib_common]->make_input_box($site_page_info[tag_contents_out], "tag_contents_out", "textarea", "rows=3 cols=60 class='designer_textarea' wrap='off'", "width:100%", '', 'N') . "
		</td>
	</tr>
	<tr bgcolor=ffffff>
		<td colspan=2 height=20 align=right>
			<table border='0' cellpadding='3' cellspacing='0'>
				<tr> 
					<td><input type='image' src='$DIRS[designer_root]images/bt_save.gif' width='38' height='20' border='0'></td>
					<td><a href='#' onclick='reset()'><img src='$DIRS[designer_root]images/bt_repeat.gif' width='38' height='20' border='0'></a></td>
					<td><a href='javascript:self.close()'><img src='$DIRS[designer_root]images/bt_close.gif' width='38' height='20' border='0'></a></td>
				</tr>
			</table>
		</td>
	</tr>
	</form>
</table>
";
$P_page_designer_tag_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_page_designer_tag_form, $IS_input_box_padding, array("title"=>"<b>&lt;head&gt;, &lt;body&gt; ����</b>"));

$help_msg = "
���&��Ÿ&JS : ������ &lt;head&gt;&lt;/head&gt;, &lt;meta&gt;, &lt;script&gt; �κ��� ���� (����Ʈ�ؼ� ����ϸ� ���մϴ�.)<br>
�ٵ� : &lt;body&gt; �±�����<br>
�ٵ𳻺� : �α׺м� ��ũ��Ʈ�� �̹����� ��ũ�±� ���� �Է�.<br>
�ٵ�ܺ� : &lt;/body&gt; ������ ����ؾ� �� ���� �Է�
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	function insert_system_js() {
		form = document.title;
		form.tag_header.value = \"<script src='designer/include/js/javascript.js'></script>\\n\" + form.tag_header.value;
	}
	function insert_system_style() {
		form = document.title;
		form.tag_header.value = \"<link rel='stylesheet' href='designer/include/style.css' type='text/css'>\\n\" + form.tag_header.value;
	}
//-->
</script>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_page_designer_tag_form</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>