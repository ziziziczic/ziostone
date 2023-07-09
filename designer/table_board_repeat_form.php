<?
/*----------------------------------------------------------------------------------
 * 제목 : 인사이트 페이지 테이블 설정 화면
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0];
$line = $lib_fix->search_index($design, "테이블", $location);
$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
if (!strcmp("반복", $exp[9])) $table_is_repeat = true;

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
$line = $lib_fix->search_index($design, "줄", $location);
$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
if (!strcmp("반복", $exp[9])) $tr_is_repeat = true;

if ($table_is_repeat != "true") {
	if($tr_is_repeat == "true") $btn = "제거하기";
	else $btn = "설정하기";
	$msg_tr = "<a href='#' onclick='tr_repeat()'><font color='#FF3300'>$btn</font></a>";
} else {
	$msg_tr = "테이블 반복 제거후 사용 할 수 있습니다.";
}

if ($tr_is_repeat != "true") {
	if($table_is_repeat == "true") $btn = "제거하기";
	else $btn = "설정하기";
	$msg_table = "<a href='#' onclick='table_repeat()'><font color='#FF3300'>$btn</font></a>";
} else {
	$msg_table = "줄 반복 제거후 사용 할 수 있습니다.";
}

$P_form_input = "
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td height='30' width='120' align='right'>현재 줄 반복</td>
								<td align='center' width='40'>--></td>
								<td>
									$msg_tr
								</td>
							</tr>
							<tr> 
								<td height='30' align='right'>현재 테이블 반복</td>
								<td align='center' width='40'>--></td>
								<td>
									$msg_table
								</td>
							</tr>
						</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>게시물반복 위치설정</b>"));

$help_msg = "
	반복기능은 현재 선택되어있는 줄 또는 테이블을 출력될 게시물 수 만큼 반복해주는 기능입니다.<br>
	게시판을 만들 경우 게시물 목록수를 설정한후 줄 또는 테이블 반복을 반드시 설정하셔야 합니다.<br>
	설정을 마친후 디자인 화면에 나타난 반복 횟수가 설정한 만큼 되었는지 확인해 보십시오.
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--	
	function reload() {
		var form = eval(document.frm);
		form.reset();
	}
	function adjust_submit() {
		var form = eval(document.frm);
		form.action = form.action + '&adjust=Y';
		form.submit();
	}
	//테이블 반복
	function table_repeat() {
		window.location.href='table_designer_manager.php?design_file=$design_file&index=$index&mode=repeat&mode1=table';
	}

	//줄반복
	function tr_repeat() {
		window.location.href='table_designer_manager.php?design_file=$design_file&index=$index&mode=repeat&mode1=tr';
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			$P_form_input
		</td>
	</tr>	
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>