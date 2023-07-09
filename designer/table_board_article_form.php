<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다

$is_saved_subject = $is_saved_sign_date = $is_saved_upload = $is_saved_page_block = $is_link_method = $is_saved_comment = "none";
$input_disable = '';

$board_info = $lib_fix->get_board_info($board_name);
if ($cpn > 0) {																											// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "게시물정보") {																		// 게시물 정보인 경우만 설정을 불러온다.
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
					$use_thumb = $exp_1[4];
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
				$user_define_text = $exp_1[1];
				$saved_user_define_img = $exp_1[2];
			break;
		}
		$exp_pp_fld = explode($GLOBALS[DV][ct4], $exp[3]);
		$item_index = $exp_pp_fld[0];
		switch ($article_item) {
			case "subject" :
				$saved_recent_icon = $exp_pp_fld[1];
				$recent_icon_time = $exp_pp_fld[2];
				$saved_reply_icon = $exp_pp_fld[3];
				$saved_notice_icon = $exp_pp_fld[4];
				$saved_private_icon = $exp_pp_fld[5];
				$saved_common_icon = $exp_pp_fld[6];
			break;
			case "page_block" :
				$page_block_left = $exp_pp_fld[1];
				$page_block_right = $exp_pp_fld[2];
				$page_block_space = $exp_pp_fld[9];
				$saved_page_block_pre_block = $exp_pp_fld[3];
				$saved_page_block_pre_page = $exp_pp_fld[4];
				$saved_page_block_next_page = $exp_pp_fld[5];
				$saved_page_block_next_block = $exp_pp_fld[6];
				$page_block_link_page = $exp_pp_fld[7];
				$page_block_page_var_name = $exp_pp_fld[8];
			break;
			case "total_comment" :
				$comment_table = $exp_pp_fld[1];
				$relation_table = $exp_pp_fld[2];
				$relation_serial_get_name = $exp_pp_fld[3];
			break;
		}
		$exp_link_info = explode($GLOBALS[DV][ct4], $exp[6]);
		$pp_link_target = $exp_link_info[0];
		$pp_link_nw = $exp_link_info[1];
		$pp_link_etc = $exp_link_info[2];
		$pp_link_rollover = $exp_link_info[3];
		$link_field = $exp_link_info[4];
		$link_field_part = $exp_link_info[5];
		$link_method = $exp_link_info[6];
		$user_link = $exp_link_info[7];
		$origin_img_name = $exp_link_info[8];

		$exp_tag_both = explode($GLOBALS[DV][ct4], $exp[12]);
		$tag_open = $exp_tag_both[0];
		$tag_close = $exp_tag_both[1];
	} else {	// 게시물 정보외의 다른 항목이었던 경우 기본값 설정부
		$exp = '';
		$T_article_item = "asc_num";
		$prt_type = 'T';
		$prt_type_file = 'A';
		$link_field = 'X';
		$pp_link_nw = "name,10,10,300,200,1,0,1,0";
		$nw_property_default = " disabled";
		$format_date = 'Y-m-d';
		$size_method = "A";
		$user_define_text = "[파일다운로드]";
		$page_block_left = '[';
		$page_block_right= ']';
		$comment_table = "TCBOARD_comment";
		$relation_table = "TCBOARD_{$board_info[name]}";
		$relation_serial_get_name = "serial_num";
	}
} else {		// 항목 추가인경우 기본값 설정부
	$T_article_item = "asc_num";
	$prt_type = 'T';
	$prt_type_file = 'A';
	$link_field = 'X';
	$pp_link_nw = "name,10,10,300,200,1,0,1,0";
	$nw_property_default = " disabled";
	$format_date = 'Y-m-d';
	$sosujum = '0';
	$size_method = "A";
	$user_define_text = "[파일다운로드]";
	$page_block_left = '[';
	$page_block_right= ']';
	$comment_table = "TCBOARD_comment";
	$relation_table = "TCBOARD_{$board_info[name]}";
	$relation_serial_get_name = "serial_num";
}

if ($T_article_item == '') $T_article_item = "asc_num";
if ($prt_type == '') $prt_type = 'T';
if ($prt_type_file == '') $prt_type_file = 'A';
if ($sosujum == '') $sosujum = '0';
if ($link_field == '') $link_field = 'X';
if ($pp_link_nw == '') $pp_link_nw = "name,10,10,300,200,1,0,1,0";
if ($nw_property_default == '') $nw_property_default = " disabled";
if ($format_date == '') $format_date = 'Y-m-d';
if ($size_method == '') $size_method = 'A';
//if ($user_define_text == '') $user_define_text = "[파일다운로드]";
//if ($page_block_left == '') $page_block_left = '[';
//if ($page_block_right == '') $page_block_right= ']';

if ($pp_default[color] != '') {
	$P_script = "
		c1 = '$pp_default[color]';
	";
}

$P_form_input = "
	<table width='100%'>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", '', "desc_num") . "<b>내림번호</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", '', "asc_num") . "<b>오름번호</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", '', "serial_num") . "<b>일련번호</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "subject") . "<b>제목</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "writer_name") . "<b>작성자</b></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "email") . "<b>이메일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "homepage") . "<b>홈페이지</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=D", '', "sign_date") . "<b>작성일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "comment") . "<b>내용1~2</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "phone") . "<b>전화번호</b></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=F_U", '', "user_file") . "<b>업로드파일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", '', "file_size") . "<b>파일크기</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "category") . "<b>분류1~6</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "etc") . "<b>기타1~3</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "type") . "<b>게시물유형</b></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T", '', "writer_id") . "<b>아이디</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=X", '', "page_block") . "<b>페이지링크</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", '', "count") . "<b>조회수</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T", '', "user_ip") . "<b>ip</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_N", '', "total_article") . "<b>총게시물수</b></td>	
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_N", '', "total_comment") . "<b>덧글수</b></td>	
			<td></td>
			<td></td>
			<td></td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item_user", "text", "size=10 class='designer_text'", '', '') . "
				" . $GLOBALS[lib_common]->make_input_box($item_index, "item_index", "text", "size=3 maxlength=1 class='designer_text'", '', '') . "
			</td>
		</tr>
	</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>입력항목선택</b>"));

include "./include/pp_form_font.inc.php";
$FL_upload_image = 'N';
include "{$DIRS[designer_root]}include/pp_form_img.inc.php";

$P_form_input_property = "
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
							<tr><td><hr size=1></td></tr>
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
												" . $GLOBALS[lib_common]->make_input_box($size_method, "size_method", "radio", "class='designer_radio'", '', "H") . "고정비율&nbsp;&nbsp;&nbsp;
												" . $GLOBALS[lib_common]->make_input_box($use_thumb, "use_thumb", "checkbox", "class='checkbox'", '', "Y") . "썸네일사용
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
												" . $GLOBALS[lib_common]->make_input_box($max_string, "code_define", "textarea", "cols=70 rows=5 class='designer_textarea'", '') . "
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
												" . $GLOBALS[lib_common]->make_input_box($user_define_text, "user_define_text", "text", "size='30' class='designer_text'", '') . "
											</td>
										</tr>
										<tr>
											<td width=77>이미지</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box("", "user_define_img", "file", "size='60' class='designer_text'", "") . "<br>
												" . $GLOBALS[lib_common]->make_input_box($saved_user_define_img, "saved_user_define_img", "text", "size=48 class='designer_text'", '') . "
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
$P_form_input_property = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_property, $IS_input_box_padding, array("title"=>"<b>출력속성정의</b>"));

$option_name = array();
for ($i=0; $i<=200; $i=$i+5) $option_name[] = $i;

$P_form_input_special = "
						<table width='100%' border='0' cellspacing='0' cellpadding='3' >
							<tr height=1><td></td></tr>
							<tr id='SUBJECT' style='display:{$is_saved_subject}'>
								<td>
									<table width=100% cellpadding=3 cellspacing=0 border=0>
										<tr>
											<td>원글아이콘</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("common_icon", 1, $saved_common_icon, "size=25 class='designer_text'", '/') . "
											</td>
										</tr>
										<tr>
											<td>답변글아이콘</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("reply_icon", 1, $saved_reply_icon, "size=25 class='designer_text'", '/') . "
											</td>
										</tr>
										<tr>
											<td>공지글아이콘</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("notice_icon", 1, $saved_notice_icon, "size=25 class='designer_text'", '/') . "
											</td>
										</tr>
										<tr>
											<td width=83>최근글아이콘</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("recent_icon", 1, $saved_recent_icon, "size=25 class='designer_text'", '/') . "
												" . $GLOBALS[lib_common]->make_list_box("recent_icon_time", $option_name, $option_name, $recent_icon_time, '', "class='designer_select'", "") . " 시간보임
											</td>
										</tr>
										<tr>
											<td>비밀글아이콘</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("private_icon", 1, $saved_private_icon, "size=25 class='designer_text'", '/') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='PAGE_BLOCK' style='display:{$is_saved_page_block}'>
								<td>
									<table width=100% cellpadding=3 cellspacing=0 border=0>
										<tr>
											<td height='25' colspan=4>
												<table width=100% cellpadding=3 cellspacing=0 border=0>
													<tr>
														<td width=100>페이지링크</td>
														<td>
															 왼쪽 " . $GLOBALS[lib_common]->make_input_box($page_block_left, "page_block_left", "text", "size=3 class='designer_text'", "") . "
															 오른쪽 " . $GLOBALS[lib_common]->make_input_box($page_block_right, "page_block_right", "text", "size=3 class='designer_text'", "") . "
															 사이 " . $GLOBALS[lib_common]->make_input_box($page_block_space, "page_block_space", "text", "size=3 class='designer_text'", "") . "
														</td>
													</tr>
													<tr>
														<td>이전페이지블럭</td>
														<td>
															" . $GLOBALS[lib_common]->get_file_upload_box("page_block_pre_block", 1, $saved_page_block_pre_block, "size=25 class='designer_text'", '/') . "
														</td>
													</tr>
													<tr>
														<td>이전페이지버튼</td>
														<td>
															" . $GLOBALS[lib_common]->get_file_upload_box("page_block_pre_page", 1, $saved_page_block_pre_page, "size=25 class='designer_text'", '/') . "
														</td>
													</tr>
													<tr>
														<td>다음페이지버튼</td>
														<td>
															" . $GLOBALS[lib_common]->get_file_upload_box("page_block_next_page", 1, $saved_page_block_next_page, "size=25 class='designer_text'", '/') . "
														</td>
													</tr>
													<tr>
														<td>다음페이지블럭</td>
														<td>
															" . $GLOBALS[lib_common]->get_file_upload_box("page_block_next_block", 1, $saved_page_block_next_block, "size=25 class='designer_text'", '/') . "
														</td>
													</tr>
													<tr>
														<td>링크파일명</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($page_block_link_page, "page_block_link_page", "text", "size=30 class='designer_text'", "") . "
														</td>
													</tr>
													<tr>
														<td>페이지변수명</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($page_block_page_var_name, "page_block_page_var_name", "text", "size=30 class='designer_text'", "") . "
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='COMMENT' style='display:{$is_saved_comment}'>
								<td>
									<table width=100% cellpadding=3 cellspacing=0 border=0>
										<tr>
											<td height='25' colspan=4>
												<table width=100% cellpadding=3 cellspacing=0 border=0>
													<tr>
														<td>덧글 저장테이블</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($comment_table, "comment_table", "text", "size=30 class='designer_text'", "") . "
														</td>
													</tr>
													<tr>
														<td>원글 테이블이름</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($relation_table, "relation_table", "text", "size=30 class='designer_text'", "") . "
														</td>
													</tr>
													<tr>
														<td>원글 번호변수명</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($relation_serial_get_name, "relation_serial_get_name", "text", "size=30 class='designer_text'", "") . "
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
";
$P_form_input_special = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_special, $IS_input_box_padding, array("title"=>"<b>필드별 전용 속성</b>"));

$option_name_link = array("기본링크", "링크없음", "고정주소", "작성자필드값", "이메일필드값", "홈페이지필드값", "제목필드값", "내용필드값", "분류필드값", "게시물유형필드값", "전화번호필드값", "기타필드값");
$option_value_link = array('D', 'X', 'U', 'name', 'email', 'homepage', 'subject', 'comment', 'category', 'type', 'phone', 'etc');

$option_name_link_1 = array("제목(내용열람)", "파일링크", "확대사진", "롤오버", "다운로드", "갤러리", "아웃룩", "폼메일");
$option_value_link_1 = array("S", "L", "B", "R", "D", "G", "O", "F");

include "./include/pp_form_link.inc.php";

$P_form_link = "
						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td>
									<table cellpadding=2 cellspacing=0 border=0>
										<tr>
											<td width=80>링크설정</td>
											<td>
												" . $GLOBALS[lib_common]->make_list_box("link_field", $option_name_link, $option_value_link, '', $link_field, "onchange='select_link_field()' class=designer_select", '') . "
												" . $GLOBALS[lib_common]->make_input_box($link_field_part, "link_field_part", "text", "size='1' class='designer_text'", '', '') . "
											</td>
											<td>
												<table cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>
															" . $GLOBALS[lib_common]->make_list_box("link_method", $option_name_link_1, $option_value_link_1, '', $link_method, "onchange='select_link_method()' style='display:{$is_link_method}'class=designer_select", '') . "
														</td>
														<td>&nbsp;</td>
														<td>
															" . $GLOBALS[lib_common]->make_input_box($origin_img_name, "origin_img_name", "text", "size='10' class='designer_text'", '') . "
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>고정링크</td>
											<td colspan=3>
												" . $GLOBALS[lib_common]->make_input_box($user_link, "user_link", "text", "size='60' class='designer_text'", '', "U") . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									$P_pp_form_link
								</td>
							</tr>
						</table>
";
$P_form_link = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_link, $IS_input_box_padding, array("title"=>"<b>링크설정</b>"));

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

echo("
<script language='javascript1.2'>
<!--
	var msg, c1;
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_prt = 'T', chk_prt_id='', chk_prt_value='';
	$P_script

	function del_image(item) {
		var form = eval(document.frm);
		switch (item) {
			case 'recent' :
				form.saved_recent_icon.value = '';
			break;
			case 'reply' :
				form.saved_reply_icon.value = '';
			break;
			case 'notice' :
				form.saved_notice_icon.value = '';
			break;
			case 'private' :
				form.saved_private_icon.value = '';
			break;
			case 'page_block_pre_block' :
				form.saved_page_block_pre_block.value = '';
			break;
			case 'page_block_pre_page' :
				form.saved_page_block_pre_page.value = '';
			break;
			case 'page_block_next_page' :
				form.saved_page_block_next_page.value = '';
			break;
			case 'page_block_next_block' :
				form.saved_page_block_next_block.value = '';
			break;
			case 'upload_file_img' :
				form.saved_upload_file_img.value = '';
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
		excepts = ['SUBJECT', 'PAGE_BLOCK', 'COMMENT'];
		enable_child_id(chk_prt_id, document.getElementsByTagName('tr'), excepts);
	}
	
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
		switch (chk_fld_value) {
			case 'subject' :
				SUBJECT.style.display='block';
				PAGE_BLOCK.style.display='none';
				COMMENT.style.display='none';
			break;
			case 'page_block' :
				PAGE_BLOCK.style.display='block';
				SUBJECT.style.display='none';
				COMMENT.style.display='none';
			break;
			case 'total_comment' :
				PAGE_BLOCK.style.display='none';
				SUBJECT.style.display='none';
				COMMENT.style.display='block';
			break;
			default :
				PAGE_BLOCK.style.display='none';
				SUBJECT.style.display='none';
				COMMENT.style.display='none';
			break;
		}
		form.article_item_user.value = chk_fld_value;
		if (chk_fld_value == 'comment' || chk_fld_value == 'user_file' || chk_fld_value == 'category' || chk_fld_value == 'etc') form.item_index.disabled = false;
		else form.item_index.disabled = true;
		//if (chk_fld_id == 'C') form.code_define.disabled = true;
		if (chk_fld_value == 'category' || chk_fld_value == 'type') form.code_define.disabled = true;
		else form.code_define.disabled = false;
	}

	function select_link_field() {
		form = document.frm;
		option_count = eval(form.link_method.length);	// 제거해야할 select의 option 태그의 수를 얻어온다.
		form.link_method.style.display = 'none';
		form.origin_img_name.style.display = 'none';
		form.link_field_part.disabled = true;
		form.link_method.disabled = true;
		form.user_link.disabled = true;
		lfsi = form.link_field.selectedIndex;
		if (lfsi == 1) {	// 링크없음일때.
			form.link_field_part.disabled = true;
			form.pp_link_target.disabled = true;
			form.pp_link_nw.disabled = true;
			form.pp_link_etc.disabled = true;
			form.pp_link_rollover.disabled = true;
		} else {
			form.pp_link_target.disabled = false;
			form.pp_link_nw.disabled = false;
			form.pp_link_etc.disabled = false;
			form.pp_link_rollover.disabled = false;
		}
		switch (lfsi) {
			case 0 :	// 기본링크
				form.link_field_part.disabled = false;
				form.link_method.disabled = false;
				form.link_method.style.display = 'block';
				form.origin_img_name.style.display = 'block';
				select_link_method();
			break;
			case 2 :	// 고정주소
				form.user_link.disabled = false;
			break;
			default :				
				if (lfsi == 7 || lfsi == 8 || lfsi == 11) form.link_field_part.disabled = false;
				else form.link_field_part.disabled = true;
				form.link_method.style.display = 'none';
				form.origin_img_name.style.display = 'none';
			break;
		}	
		is_nw_check(form);
	}

	function select_link_method() {
		form = document.frm;
		if (form.link_method.value == 'S' || form.link_method.value == 'O' || form.link_method.value == 'F' || form.link_method.value == 'G') form.link_field_part.disabled = true;
		else form.link_field_part.disabled = false;
		if (form.link_method.value != 'R') form.origin_img_name.disabled = true;
		else form.origin_img_name.disabled = false;
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
		if (form.link_field_part.disabled == false && form.link_field_part.value == '') {
			alert('링크 필드 번호를 입력하세요');
			form.link_field_part.focus();
			return false;			
		}
		form.submit();
	}
//-->
</script>
<form method='post'  name='frm' action='table_board_article_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit();'>
<input type=hidden name=design_file value=$design_file>
<input type=hidden name=index value=$index>
<input type=hidden name=current_line value=$current_line>
<input type=hidden name=cpn value=$cpn>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<tr>
		<td>
			$P_form_input
		</td>
	</tr>
</table>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<tr>
		<td>
			$P_form_input_property
		</td>
	</tr>
</table>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<tr>
		<td>
			$P_form_input_special
		</td>
	</tr>
</table>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<tr>
		<td>
			$P_form_link
		</td>
	</tr>
</table>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
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
</table>
</form>
<script language='javascript1.2'>
<!--
	inverter();
	inverter_2();
	select_link_field();
	//select_link_method();
	is_nw_check(form);
//-->
</script>
");
include "footer_sub.inc.php";
?>