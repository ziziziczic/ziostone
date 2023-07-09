<?
$exp_tag_both = explode($GLOBALS[DV][ct4], $exp[12]);
$tag_open = $exp_tag_both[0];
$tag_close = $exp_tag_both[1];
$P_form_open_close_tag = "
			<table width='100%' border='0' cellspacing='0' cellpadding='3' >
				<tr>
					<td height='25'>시작태그</td>
					<td height='25' colspan='3'>
						" . $GLOBALS[lib_common]->make_input_box($tag_open, "tag_open", "text", "size='60' maxlength='255' class='designer_text'", "") . "
					</td>
				</tr>
				<tr>
					<td height='25'>끝태그</td>
					<td height='25' colspan='3'>
						" . $GLOBALS[lib_common]->make_input_box($tag_close, "tag_close", "text", "size='60' maxlength='255' class='designer_text'", "") . "
					</td>
				</tr>
			</table>
";
$P_form_open_close_tag = $lib_insiter->w_get_img_box($IS_thema, $P_form_open_close_tag, $IS_input_box_padding, array("title"=>"<b>Open & Close 태그입력</b>"));
?>
