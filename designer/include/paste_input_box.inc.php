<?
if ($field_name_input_box == '') $field_name_input_box = "comment_1";
$P_html_editer_tag = "
<input name='field_name_input_box' type='hidden' value='$field_name_input_box'>
<script src='{$DIRS[designer_root]}include/js/insite_html_editor.js'></script>
<script for='window' event='onload()'>return OnDocumentComplete()</script>
<script>interval_id = setInterval('force_editmode()', 1000 );</script>
<table border='0' cellspacing='0' cellpadding='0' width=100% height=100%>
	<tr valign='middle' height=35>
		<td>
			<table border='0' cellspacing='1' cellpadding='3' align='left' width=100% height=100% bgcolor='#AAAAAA'>
				<tr bgcolor=f3f3f3>
					<td height=30 bgcolor=ffffff width=110>
						&nbsp;<input type=radio CHECKED value=Y name=editor_yn onclick='OnChangeEditorYN()' class='designer_checkbox'><b>�������</b><br>
						&nbsp;<input type=radio  value=N name=editor_yn onclick='OnChangeEditorYN()' class='designer_checkbox'><b>HTML���</b>
					</td>
					<td id='insite_toolbar'>
						<table cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td>
									<select id='insite_edit' class='boolee' onchange='command(this)' style='font-size:11px; width:70px'>
									<option selected>&nbsp;&nbsp;�� ��</option>
									<option>--------</option>
									<option>��ü����</option>
									<option>�߶󳻱�</option>
									<option>�ٿ��ֱ�</option>
									<option>�����</option>
									<option>����</option>
									</select>
									<select id='insite_font' class='boolee' onchange='command(this)' style='font-size:11px; width:70px'>
									<option selected>&nbsp;&nbsp;�� ü</option>
									<option>--------</option>
									<option>����ü</option>
									<option>����ü</option>
									<option>����ü</option>
									<option>�ü�ü</option>
									<option>Arial</option>
									<option>Times</option>
									<option>Courier</option>
									</select>
									<select id='insite_fontsize' class='boolee' onchange='command(this)' style='font-size:11px; width:70px'>
									<option>&nbsp;&nbsp;�� Ʈ</option>
									<option>--------</option>
									<option value='1'>8pt</option>
									<option value='2'>10pt</option>
									<option value='3'>12pt</option>
									<option value='4'>14pt</option>
									<option value='5'>18pt</option>
									<option value='6'>24pt</option>
									<option value='7'>36pt</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<table width='348' height=30 background='{$DIRS[designer_root]}images/html_editor/sample_4.gif' border=1 cellspacing=1 cellpadding=0 bordercolor='#ffffff' onSelectStart='return false' onDragStart='return false'>
										<tr>
											<td id='insite_bold' title='����' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_italic' title='����̱�' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_underline' title='����' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_fontcolor' title='���ڻ�' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_fontbgcolor' title='���ڹ���' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_tablebgcolor' title='ǥ����' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_left' title='��������' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_center' title='�������' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_right' title='����������' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_numlist' title='���ڱ�ȣ' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_itemlist' title='���ڱ�ȣ' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_outdent' title='�����̱�' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_indent' title='�Ǵ��̱�' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_table' title='ǥ�����' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
											<td id='insite_anchor' title='������' onmouseover='buttonover(this)' onmouseout='buttonout(this)' onmousedown='buttondown(this)' onclick='command(this)'>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr valign='middle' align='center'>
		<td valign='middle'>
		<textarea class=gray_txt style='FONT-SIZE: 12px' name='$field_name_input_box' rows=32 cols=97 scrollbar='no' style='width:100%;height:100%;display:none'>{$default_text_value}</textarea>
		<iframe id='ObjInsiteEditor' src='about:blank' style='height:100%; width:100%;' onbeforedeactivate='deactivate_handler();' scrolling='yes'></iframe>
		</td>
	</tr>
	<tr>
		<td height=20 align=right>1�ٹٲٱ� Shift+Enter , 2�ٹٲٱ� Enter !</td>
	</tr>
</table>

<!-------------------------------- ǥ�׸��� ���̺� ���� ---------------------------------->
<div id = 'insite_cellsdiv' style='position:absolute;visibility:hidden;width:200px'>
<table id='insite_cellstable' border='1' cellspacing='0' cellpadding='0' bordercolor='gray' bgcolor='white'
	onmousemove='clear_timeout()' onmouseout='start_timeout(this)'>
	<tr id='base'>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	<td width='15' height='15' onmouseover='coloring(this)' onclick='selectXY(this)'>&nbsp;</td>
	</tr>
	<tr>
	<td colspan='10' id='xy_display' align='center' style='font:bold'>0*0</td>
	</tr>
</table>
</div>
";
if ($P_html_eidtor_no_print != 'Y') echo($P_html_editer_tag);
?>