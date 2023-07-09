<?
if ($exp_function == '') $exp_function = explode($GLOBALS[DV][ct4], $exp[7]);
$is_msg_array = array('N'=>"출력안함", 'Y'=>"출력함");
$P_table_form_function = "
<table cellpadding=0 cellspacing=0 border=0 width=98% align=center>
	<tr>
		<td width=100>* 폼 전체속성</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($exp_function[0], "form_property", "text", "class=designer_text size=60", "width:100%") . "</td>
	</tr>
	<tr>
		<td>* Submit 함수내</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($exp_function[1], "form_function", "text", "class=designer_text size=60", "width:100%") . "</td>
	</tr>
	<tr>
		<td>* DB처리후 script</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($exp_function[2], "after_db_script", "text", "class=designer_text size=60", "width:100%") . "</td>
	</tr>
	<tr>
		<td>* 결과메시지</td>
		<td>" . $GLOBALS[lib_common]->get_list_boxs_array($is_msg_array, "after_db_msg", $exp_function[3], 'N', "class=designer_select") . "</td>
	</tr>
</table>
";
$P_table_form_function = $lib_insiter->w_get_img_box($IS_thema, $P_table_form_function, $IS_input_box_padding, array("title"=>"<b>폼속성 정의</b> (전체 속성은 name 부터 onsubmit 속성까지 모두 정의해야함)"));
?>