<?
if ($FL_upload_image == 'Y') {
	if ($pp_img_src != '') {
		if (file_exists($root . $pp_img_src)) {
			$image_size = getimagesize($root . $pp_img_src);   // �׸��� ũ�⸦ ���Ѵ�.
			if ($image_size[0] > 250) $img_width = " width=250 ";
			if ($image_size[1] > 250) $img_height = " height=250 ";
			$prev_img = "<img src='{$root}$pp_img_src'{$img_width}{$img_height}border='0' name=selected_image>";
		} else {
			$prev_img = "<img src='{$DIRS[designer_root]}images/preview.jpg' border='0' name=selected_image>";
		}
	} else {
		$prev_img = "<img src='{$DIRS[designer_root]}images/preview.jpg' border='0' name=selected_image>";
	}
	$upload_img_form = "
	<script language='javascript1.2'>
	<!--
	function pre_view_client() {
		var prev_img;
		var form = eval(document.frm);
		form.pp_img_src.value = '';
		prev_img = new Image();	// �̹��� ������ ��ü�� �����.
		prev_img.src = form.userfile.value;	// ����ڰ� ������ ������ �� �̹��� ��ü�� ��´�.
		if (prev_img.complete == true) {
			form.pp_img_width.value = prev_img.width;	 // �̹��� �ʺ� �Է� ���ڿ� ���� �ʺ� �����Ѵ�.
			form.pp_img_height.value = prev_img.height;	//   ''    ����          ''               ''	
			form.real_width.value = prev_img.width;
			form.real_height.value = prev_img.height;
			if (prev_img.width > 250) prev_img.width = 250;
			form.selected_image.src = prev_img.src;	
			form.selected_image.width = prev_img.width;
		} else {
			form.pp_img_width.value = '';
			form.pp_img_height.value = '';
		}
	}
	//-->
	</script>
	<tr>
		<td colspan=4>
			<table>
				<tr>
					<td width=250>
						<table width='100%' border='0' cellpadding='3' cellspacing='0'>
							<tr> 
								<td align=center>
									$prev_img
								</td>
							</tr>
						</table>
					</td>
					<td valign=top>
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr title=' �� ����� ��ǻ�Ϳ� �ִ� �׸��� ������ ����մϴ�.'> 
								<td height='25'>���̹��� / �̹������</td>
							</tr>
							<tr>
								<td>
									" . $GLOBALS[lib_common]->make_input_box("", "userfile", "file", "size='30' onChange='pre_view_client()' class='designer_text'", "") . "
								</td>
							</tr>
							<tr>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($pp_img_src, "pp_img_src", "text", "size=48 class='designer_text'", "") . "
								</td>
							</tr>
							<tr>
								<td>
									����ũ��(���� x ����) : " . $GLOBALS[lib_common]->make_input_box($pp_img_width, "real_width", "text", "size=4 readonly", "text-align:center;border-style:none;background-color:f3f3f3") . " x " . $GLOBALS[lib_common]->make_input_box($pp_img_height, "real_height", "text", "size=4 readonly", "text-align:center;border-style:none;background-color:f3f3f3") . "<br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan=4><hr size=1></td></tr>
	";
}
$option_array = array("absmiddle"=>"�����", "left"=>"����", "right"=>"������");
$option_name = array();
for ($i=0; $i<=7; $i++) $option_name[] = $i;
$P_form_img = "
<table width=100% cellpadding=2 cellspacing=0 border=0>
	$upload_img_form
	<tr>
		<td width=70>���� x ����</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($pp_img_width, "pp_img_width", "text", "size=4 class='designer_text'", '') . " x " . $GLOBALS[lib_common]->make_input_box($pp_img_height, "pp_img_height", "text", "size=4 class='designer_text'", '') . "</td>
		<td width=70>���Ĺ��</td>
		<td>" . $GLOBALS[lib_common]->get_list_boxs_array($option_array, "pp_img_align", $pp_img_align, 'Y', "class=designer_select", ":: ���� ::") . "</td>
	<tr>
	<tr>
		<td>�׵θ�����</td>
		<td>" . $GLOBALS[lib_common]->make_list_box("pp_img_border", $option_name, $option_name, "", $pp_img_border, "class=designer_select") . "</td>
		<td>��Ÿ�Ӽ�</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($pp_img_etc, "pp_img_etc", "text", "size=50 maxlength=200 class='designer_text'", '') . "</td>
	<tr>
</table>
";
?>