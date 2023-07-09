<?
$exp_banner_option = explode($GLOBALS[DV][ct2], $service_item_info[item_option]);
$P_script_1 = "
<script>
	excepts = '';
	enable_child_id('{$exp_banner_option[0]}', document.getElementsByTagName('tr'), excepts);
</script>
";
$P_input_form = "
<script language='javascript1.2'>
<!--
	function verify_submit_banner(form) {
		if (form.serial_service_item.value == '') {
			alert('상품을 선택하세요.');
			form.serial_service_item.focus();
			return false;
		}
		if (UPLOADFILE.style.display == 'block') {
			if (form.upload_file_1.value == '') {
				if (typeof(form.saved_upload_file_1) != 'undefined') {
					if (form.saved_upload_file_1.value == '') {
						alert('파일을 첨부 하세요.');
						return false;
					}
				} else {
					alert('파일을 첨부 하세요.');
					return false;
				}
			}
		}
		if (TITLE1.style.display == 'block') {
			if (form.title.value == '') {
				alert('타이틀을 입력하세요.');
				form.title.focus();
				return false;
			}
		}
		if (CONTENTS.style.display == 'block') {
			if (form.contents.value == '') {
				alert('내용을 입력하세요.');
				form.contents.focus();
				return false;
			}
		}
		if (LINKURL.style.display == 'block') {
			if (form.link_url.value == '') {
				alert('링크 주소를 입력하세요.');
				form.link_url.focus();
				return false;
			}
		}
	}
//-->
</script>
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title>{$IS_icon[form_title]} 배너위치</td>
		<td class=input_form_value>
			$service_item_info[name]
			<input type=hidden name=serial_service_item value='$service_item_info[serial_num]'>
		</td>
	</tr>
	<tr id='UPLOADFILE' style='display:none'>
		<td class=input_form_title>{$IS_icon[form_title]} 업로드파일</td>
		<td class=input_form_value>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 1, $banner_info[upload_files], "size=40 class=designer_text", "{$DIRS[service_upload]}banner/") . "<br>(.jpg .gif 파일만 가능)</td>
				</tr>
			</table>												
		</td>
	</tr>
	<tr id='TITLE1' style='display:none'>
		<td class=input_form_title>{$IS_icon[form_title]} 타이틀</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[title], "title", "text", "size=50 class=designer_text", '') . "
		</td>
	</tr>
	<tr id='CONTENTS' style='display:none'>
		<td class=input_form_title>{$IS_icon[form_title]} 내용</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[contents], "contents", "textarea", "rows=3 cols=40 class=designer_textarea", "width:100%") . "
		</td>
	</tr>
	<tr id='LINKURL' style='display:none'>
		<td class=input_form_title>{$IS_icon[form_title]} 링크주소</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[link_url], "link_url", "text", "size=60 class=designer_text", "width:100%") . "
		</td>
	</tr>
</table>
$P_script_1
";

if ($proc_mode == "add_user") {
	$banner_info[serial_member] = $user_info[serial_num];
	$banner_info[owner_name] = $user_info[name];
	$banner_info[owner_phone_mobile] = eregi_replace("[^0-9]", '', $user_info[phone_mobile]);
	$banner_info[owner_email] = $user_info[email];
} else {
	$link_sch_member = "{$DIRS[member_root]}sch_member.php?nm_serial_num=serial_member&nm_name=owner_name&nm_email=owner_email&nm_phone_mobile=owner_phone_mobile";
	$P_serial_member_box_onclick = " onclick=\"open_window_mouse('$link_sch_member', 700, 450)\"";	
	$P_serial_member_sch_btn = "<input type=button value='회원검색' onclick=\"open_window_mouse('$link_sch_member', 700, 450)\" class='designer_button'>";
}


$P_input_form_owner = "
<script language='javascript1.2'>
<!--
	function verify_submit_banner_owner(form) {
		if (form.owner_name.value == '') {
			alert('광고주명을 입력하세요.');
			form.owner_name.focus();
			return false;
		}
		if (form.owner_phone_mobile.value == '') {
			alert('광고주 휴대폰 번호를 입력하세요.');
			form.owner_phone_mobile.focus();
			return false;
		}
		if (form.owner_email.value == '') {
			alert('광고주 이메일 주소를 입력하세요.');
			form.owner_email.focus();
			return false;
		}
	}	
//-->
</script>
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title>{$IS_icon[form_title]} 회원번호</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[serial_member], "serial_member", "text", "size=5 class=designer_text readonly{$P_serial_member_box_onclick}", '') . "
			$P_serial_member_sch_btn
		</td>
	</tr>
	<tr>
		<td width=100 class=input_form_title>{$IS_icon[form_title]} 성명</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[owner_name], "owner_name", "text", "size=20 class=designer_text", '') . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title>{$IS_icon[form_title]} 휴대폰</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($GLOBALS[lib_common]->get_format("phone", $banner_info[owner_phone_mobile], '-'), "owner_phone_mobile", "text", "size=20 class=designer_text", '') . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title>{$IS_icon[form_title]} 이메일</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[owner_email], "owner_email", "text", "size=50 class=designer_text", '') . "
		</td>
	</tr>
</table>
";
?>