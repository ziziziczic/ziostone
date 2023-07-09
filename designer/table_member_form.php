<?
/*----------------------------------------------------------------------------------
 * 제목 : 인사이트 게시판 항목 삽입 화면
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$_GET[form_line]]);
$saved_verify_input = explode("~", $exp[5]);

$P_table_member_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td>
			" . $GLOBALS[lib_common]->make_input_box("id", "", "checkbox", "checked disabled", "", "") . "아이디
			" . $GLOBALS[lib_common]->make_input_box("passwd", "", "checkbox", "checked disabled", "", "") . "비밀번호 (회원 아이디와 비밀번호는 항상 필수 입력)
		</td>
	</tr>
	<tr><td><hr size=1></td></tr>
	<tr> 
		<td>
			<table width='100%' cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[0], "verify_input_0", "checkbox", '', '', "name") . "이름</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[1], "verify_input_1", "checkbox", '', '', "gender") . "성별</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[2], "verify_input_2", "checkbox", '', '', "homepage") . "홈페이지</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[3], "verify_input_3", "checkbox", '', '', "introduce") . "메모</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[4], "verify_input_4", "checkbox", '', '', "hobby") . "취미</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[5], "verify_input_5", "checkbox", '', '', "nick_name") . "닉네임</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[6], "verify_input_6", "checkbox", '', '', "messenger") . "메신저주소</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[7], "verify_input_7", "checkbox", '', '', "mailing") . "메일링</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[8], "verify_input_8", "checkbox", '', '', "job_kind") . "직종</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[9], "verify_input_9", "checkbox", '', '', "recommender") . "추천인</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[10], "verify_input_10", "checkbox", '', '', "group_1") . "그룹1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[11], "verify_input_11", "checkbox", '', '', "group_2") . "그룹2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[12], "verify_input_12", "checkbox", '', '', "category_1") . "분류1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[13], "verify_input_13", "checkbox", '', '', "category_2") . "분류2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[14], "verify_input_14", "checkbox", '', '', "category_3") . "분류3</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[15], "verify_input_15", "checkbox", '', '', "etc_1") . "기타1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[16], "verify_input_16", "checkbox", '', '', "etc_2") . "기타2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[17], "verify_input_17", "checkbox", '', '', "etc_3") . "기타3</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[18], "verify_input_18", "checkbox", '', '', "email") . "이메일</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[19], "verify_input_19", "checkbox", '', '', "email_1") . "<font color=999999>이메일1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[20], "verify_input_20", "checkbox", '', '', "email_2") . "<font color=999999>이메일2</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[21], "verify_input_21", "checkbox", '', '', "birth_day") . "생년월일</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[22], "verify_input_22", "checkbox", '', '', "birth_1") . "<font color=999999>생년</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[23], "verify_input_23", "checkbox", '', '', "birth_2") . "<font color=999999>생월</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[24], "verify_input_24", "checkbox", '', '', "birth_3") . "<font color=999999>생일</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>								
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[25], "verify_input_25", "checkbox", '', '', "post") . "우편번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[26], "verify_input_26", "checkbox", '', '', "post_1") . "<font color=999999>우편1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[27], "verify_input_27", "checkbox", '', '', "post_2") . "<font color=999999>우편2</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[28], "verify_input_28", "checkbox", '', '', "address") . "주소</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[29], "verify_input_29", "checkbox", '', '', "jumin_number") . "주민번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[30], "verify_input_30", "checkbox", '', '', "jumin_number_1") . "<font color=999999>주민1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[31], "verify_input_31", "checkbox", '', '', "jumin_number_2") . "<font color=999999>주민2</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[32], "verify_input_32", "checkbox", '', '', "phone") . "전화번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[33], "verify_input_33", "checkbox", '', '', "phone_1") . "<font color=999999>전화1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[34], "verify_input_34", "checkbox", '', '', "phone_2") . "<font color=999999>전화2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[35], "verify_input_35", "checkbox", '', '', "phone_3") . "<font color=999999>전화3</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[36], "verify_input_36", "checkbox", '', '', "phone_mobile") . "휴대폰번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[37], "verify_input_37", "checkbox", '', '', "phone_mobile_1") . "<font color=999999>휴대폰1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[38], "verify_input_38", "checkbox", '', '', "phone_mobile_2") . "<font color=999999>휴대폰2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[39], "verify_input_39", "checkbox", '', '', "phone_mobile_3") . "<font color=999999>휴대폰3</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[40], "verify_input_40", "checkbox", '', '', "phone_fax") . "팩스번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[41], "verify_input_41", "checkbox", '', '', "phone_fax_1") . "<font color=999999>팩스1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[42], "verify_input_42", "checkbox", '', '', "phone_fax_2") . "<font color=999999>팩스2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[43], "verify_input_43", "checkbox", '', '', "phone_fax_3") . "<font color=999999>팩스3</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[44], "verify_input_44", "checkbox", '', '', "biz_company") . "회사명</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[45], "verify_input_45", "checkbox", '', '', "biz_number") . "사업자번호</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[46], "verify_input_46", "checkbox", '', '', "biz_number_1") . "<font color=999999>번호1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[47], "verify_input_47", "checkbox", '', '', "biz_number_2") . "<font color=999999>번호2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[48], "verify_input_48", "checkbox", '', '', "biz_number_3") . "<font color=999999>번호3</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[49], "verify_input_49", "checkbox", '', '', "biz_ceo") . "대표자</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[50], "verify_input_50", "checkbox", '', '', "biz_cond") . "업태</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[51], "verify_input_51", "checkbox", '', '', "biz_item") . "종목</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[52], "verify_input_52", "checkbox", '', '', "biz_address") . "소재지</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_member_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_member_form, $IS_input_box_padding, array("title"=>"<b>회원정보 필수 입력항목선택</b>"));

include "include/form_form_property.inc.php";

$help_msg = "
	회원가입폼 설정화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo ("
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_form_manager.php'>
	<input type='hidden' name='design_file' value='$design_file'>
	<input type='hidden' name='form_line' value='$form_line'>
	<input type='hidden' name='mode' value='$mode'>
	<tr>
		<td>
			$P_table_member_form
		</td>
	</tr>
	<tr>
		<td>
			$P_table_form_function
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'></a>
			<a href='javascript:parent.window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>