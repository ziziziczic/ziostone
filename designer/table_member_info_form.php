<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다
if ($cpn > 0) {																											// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "회원정보") {																			// 게시물 정보인 경우만 설정을 불러온다.
		$article_item = $T_article_item = $exp[1];										// 기존 선택된 필드항목
		$exp_1 = explode($GLOBALS[DV][ct4], $exp[2]);
		$prt_type = $exp_1[0];
		switch ($prt_type) {				// 출력형태별 전용속성
			case 'T' :									// 텍스트
				// 텍스트 속성 불러옴
				$define_property = array("face", "size", "color");
				$pp_font = $GLOBALS[lib_common]->parse_property($exp_1[2], ' ', '=', $define_property);
				$pp_font_face = $pp_font[face];
				$pp_font_size = $pp_font[size];
				$pp_font_color = $pp_font[color];
				$pp_font_etc = $pp_font[etc];
				$max_string = $exp_1[1];
			break;
			case 'H' :								// HTML 태그
				$max_string = $exp_1[1];
			break;
			case 'F' :								// 파일
				$prt_type_file = $exp_1[1];
				if ($prt_type_file != 'F') {	// 이미지나 아이콘인경우
					// 이미지 속성 불러옴
					$define_property = array("width", "height", "border", "align");
					$pp_img = $GLOBALS[lib_common]->parse_property($exp_1[2], ' ', '=', $define_property);
					$pp_img_width = $pp_img[width];
					$pp_img_height = $pp_img[height];
					$pp_img_align = $pp_img[align];
					$pp_img_border = $pp_img[border];
					$pp_img_etc = $pp_img[etc];
					$size_method = $exp_1[3];
				} else {
					$max_string = $exp_1[4];
				}
			break;
			case 'N' :								// 숫자
				$sosujum = $exp_1[1];
			break;
			case 'D' :								// 날짜
				$format_date = $exp_1[1];
			break;
			case 'C' :								// 코드값
				$code_define = str_replace(chr(92).n, '
', $exp_1[1]);
			break;
			case 'U' :								// 사용자정의
				$saved_user_define_img = $exp_1[2];
				$user_define_text = $exp_1[3];
			break;
		}
		$exp_pp_fld = explode($GLOBALS[DV][ct4], $exp[3]);
		$item_index = $exp_pp_fld[0];

		$exp_tag_both = explode($GLOBALS[DV][ct4], $exp[12]);
		$tag_open = $exp_tag_both[0];
		$tag_close = $exp_tag_both[1];
	}
}

if ($T_article_item == '') $T_article_item = "id";
if ($prt_type == '') $prt_type = 'T';
if ($prt_type_file == '') $prt_type_file = 'A';
if ($sosujum == '') $sosujum = '0';
if ($format_date == '') $format_date = 'Y-m-d';
if ($size_method == '') $size_method = 'A';
if ($user_define_text == '') $user_define_text = "사용자정의문자";

$T_code_user_level = array();
$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
while (list($key, $value) = each($user_level_list)) {
	$T_code_user_level[] = trim("{$key}{$GLOBALS[DV][ct2]}{$value}");
}
$code_user_level = implode("\\n", $T_code_user_level);

if ($DIRS[shop_root] != '') $P_buy_cnt = "<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "buy_cnt") . "구매회수</td>";

$P_member_item = "
<table width='100%' cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "id") . "아이디</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "name") . "이름</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "passwd") . "비밀번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "passwd_re") . "비밀번호확인</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "gender") . "성별</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "homepage") . "홈페이지</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "introduce") . "메모</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "hobby") . "취미</td>					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "nick_name") . "닉네임</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "messenger") . "메신저주소</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=C", "", "mailing") . "메일링</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "job_kind") . "직종</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "recommender") . "추천인</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=F", "", "upload_file") . "업로드파일</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "admin_memo") . "관리메모</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "group_1") . "그룹1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "group_2") . "그룹2</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "sido") . "시도</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "gugun") . "구군</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_1") . "분류1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_2") . "분류2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_3") . "분류3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_1") . "기타1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_2") . "기타2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_3") . "기타3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_4") . "기타4</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_5") . "기타5</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_6") . "기타6</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "email") . "이메일주소</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "birth_day") . "생년월일</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "post") . "우편번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "address") . "주소</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "jumin_number") . "주민번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", '') . "<font color=999999>사용자</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone") . "전화번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone_mobile") . "휴대폰번호</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone_fax") . "팩스번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=C", "", "user_level") . "사용자레벨</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "visit_num") . "방문회수</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "cyber_money") . "적립금</td>
					$P_buy_cnt
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_company") . "회사명</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_number") . "사업자번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_ceo") . "대표자</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_cond") . "업태</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_item") . "종목</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_address") . "소재지</td>
					<td width=20></td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($article_item_user, "article_item_user", "text", "size=10 class='designer_text'", '', '') . "
						" . $GLOBALS[lib_common]->make_input_box($item_index, "item_index", "text", "size=3 maxlength=1class='designer_text'", '', '') . "
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_member_item = $lib_insiter->w_get_img_box($IS_thema_window, $P_member_item, $IS_input_box_padding, array("title"=>"<b>항목선택</b>"));

include "./include/pp_form_font.inc.php";

$FL_upload_image = 'N';
include "{$DIRS[designer_root]}include/pp_form_img.inc.php";

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$P_form_input_print_type = "
						<table width='100%' border='0' cellspacing='0' cellpadding='5' >
							<tr>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-T_LY-M", '', 'T') . "일반글자
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-M", '', 'H') . "HTML태그
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-F", '', 'F') . "파일
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-N", '', 'N') . "숫자
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-D", '', 'D') . "날짜
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-C", '', 'C') . "코드값
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-U", '', 'U') . "사용자정의
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-X", '', 'X') . "고정
								</td>
							</tr>
							<tr id='LY-T' style='display:none'>
								<td>
									$P_pp_form_font
								</td>
							</tr>
							<tr><td><hr size=1></td</tr>
							<tr id='LY-M' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77 height=25>글자수제한</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($max_string, "max_string", "text", "size='3' maxlength='3'{$input_disable}class='designer_text'", "") . " 500byte이내
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-F' style='display:none'>
								<td>
									<table border=0 cellpadding=0 cellspacing=0 width=100%>
										<tr>
											<td width=70>출력형태</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'A') . "자동(실제보기)
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'F') . "파일명
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'I') . "파일아이콘
											</td>
										</tr>
										<tr><td>이미지속성</td><td><hr size=1></td></tr>
										<tr>
											<td height='25'>크기지정방식</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($size_method, "size_method", "radio", "class='designer_radio'", '', "A") . "상한비율
												" . $GLOBALS[lib_common]->make_input_box($size_method, "size_method", "radio", "class='designer_radio'", '', "H") . "고정비율
											</td>
										</tr>
										<tr>
											<td colspan=2>
												$P_form_img
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-C' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=120>코드값매칭<br>코드;출력값[줄바꿈]</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($code_define, "code_define", "textarea", "cols=70 rows=5 class='designer_textarea'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-U' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>문자(html)</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($user_define_text, "user_define_text", "text", "size='60' class='designer_text'", '') . "
											</td>
										</tr>
										<tr>
											<td width=77>이미지</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("user_define_img", 0, $saved_user_define_img, "size='60' class='designer_text'") . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-N' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>소숫점자리수</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($sosujum, "sosujum", "text", "size='5' class='designer_text'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-D' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>날짜형식</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($format_date, "format_date", "text", "size='20' class='designer_text'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
";
$P_form_input_print_type = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_print_type, $IS_input_box_padding, array("title"=>"<b>출력속성 정의</b>"));

$help_msg = "
	회원정보 삽입 화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var msg, c1;
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_prt = 'T', chk_prt_id='', chk_prt_value='';

	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {	 // 선택된 필드 정보 저장
			if (form.article_item[i].checked) {
				chk_fld = form.article_item[i];
				chk_fld_id = form.article_item[i].id;
				chk_fld_value = form.article_item[i].value;
			}
		}
		disable_child_radio(chk_fld_id, form.prt_type);	// 선택된 필드에 따른 출력 속성 제한
		form.article_item_user.value = chk_fld_value;
		if (chk_fld_value == 'upload_file') form.item_index.disabled = false;
		else form.item_index.disabled = true;
		//if (chk_fld_id == 'C') form.code_define.disabled = true;
		//else form.code_define.disabled = false;

		// 선택항목 기본값 변환
		form.code_define.value = form.code_define.defaultValue;
		switch (chk_fld_value) {
			case 'user_level' :
				if (form.code_define.value == '') form.code_define.value = '$code_user_level';
			break;
		}
	}

	function inverter_2() {
		form = document.frm;
		for (i=0; i<form.prt_type.length; i++) {
			if (form.prt_type[i].checked) {
				chk_prt = form.prt_type[i];
				chk_prt_id = form.prt_type[i].id;
				chk_prt_value = form.prt_type[i].value;
			}
		}
		enable_child_id(chk_prt_id, document.getElementsByTagName('tr'));
	}

	function verify_submit() {
		form = document.frm;
		if ((chk_fld.disabled == true) || (chk_fld_value == '')) {
			alert('입력할 항목을 선택하세요');
			return false;
		}
		if ((chk_prt == 'T') || (chk_prt.disabled == true) || (chk_prt_value == '')) {
			alert('출력 속성 항목을 선택하세요');
			return false;
		}
		if (form.item_index.disabled == false && form.item_index.value == '') {
			alert('항목 번호를 입력하세요');
			form.item_index.focus();
			return false;			
		}
		form.submit();
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_member_info_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>$P_member_item</td>
	</tr>
	<tr>
		<td>
			$P_form_input_print_type
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

<script language='javascript1.2'>
<!--
	inverter();
	inverter_2();
//-->
</script>
");
include "footer_sub.inc.php";
?>