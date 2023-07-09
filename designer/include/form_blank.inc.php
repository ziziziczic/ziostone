<?
$exp_blank = explode($GLOBALS[DV][ct4], $exp[13]);
$P_form_blank = "
			<table width=100% cellpadding=2 cellspacing=0 border=0>
				<tr>
					<td>위쪽</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($exp_blank[0], "blank_up", "text", "size='2' maxlength='5' class='designer_text'", '') . "
					</td>
					<td>아래쪽</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($exp_blank[1], "blank_down", "text", "size='2' maxlength='5' class='designer_text'", '') . "
					</td>
					<td>왼쪽</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($exp_blank[2], "blank_left", "text", "size='2' maxlength='5' class='designer_text'", '') . "
					</td>
					<td>오른쪽</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($exp_blank[3], "blank_right", "text", "size='2' maxlength='5' class='designer_text'", '') . "
					</td>
				<tr>
			</table>
";
$P_form_blank = $lib_insiter->w_get_img_box($IS_thema, $P_form_blank, $IS_input_box_padding, array("title"=>"<b>공백입력</b>"));
?>