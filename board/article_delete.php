<?
/*----------------------------------------------------------------------------------
 * 제목 : 인사이트 게시물 삭제 프로그램
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */

include "../include/verify_input.inc.php";	// 비정상적인 입력 방지

$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$board_info = $lib_fix->get_board_info($_POST[board]);
$board_name = "{$DB_TABLES[board]}_{$board_info[name]}";

$article_value = $GLOBALS[lib_common]->get_data($board_name, "serial_num", $article_num);
$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "delete");
if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("비밀번호가 틀렸거나 삭제할 수 있는 권한이 없습니다.");

$article_fid = $article_value[fid];
$article_thread = $article_value[thread];
$reply_delete = false;

if ($input_method == "1") include "user_input_comment.inc.php";	// 사용자 입력 폼설정

	######### 삭제하고자 하는 글이 답변글을 하나라도 달고 있으면 삭제할 수 없도록 한다. ##########

if(!$reply_delete) {
	$query = "SELECT thread FROM $board_name WHERE fid = $article_fid AND length(thread) = length('$article_thread')+1 AND locate('$article_thread',thread) = 1 ORDER BY thread DESC LIMIT 1";
	$result = $GLOBALS[lib_common]->querying($query);
	$rows = mysql_num_rows($result);
	if($rows) $GLOBALS[lib_common]->alert_url("답변글이 있는 게시물입니다. 답변글을 먼저 삭제해 주세요.");
}

$saved_files = explode(";", $article_value[user_file]);
for ($i=0; $i<sizeof($saved_files); $i++) {
	$saved_file = "{$DIRS[design_root]}upload_file/$board_info[name]/$saved_files[$i]";
	if (file_exists($saved_file) && ($saved_files[$i] != "")) unlink($saved_file);		
}
if ($user_input_query != "") {
	include "user_input_query.inc.php";	// 사용자 쿼리설정
} else {
	$query = "DELETE FROM $board_name WHERE fid=$article_fid AND thread = '$article_thread'";
}
$result = $GLOBALS[lib_common]->querying($query, "게시물 삭제 쿼리 수행중 에러발생");

// 처리후 이동할 페이지 및 수행 할 스크립트 설정
$after_msg = "정상적으로 삭제 되었습니다.";
$change_vars = array("design_file"=>'');
$move_page_link_tail = $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
if ($after_db_msg == 'Y') {
	echo("
		<script language='javascript1.2'>
			<!--
				alert('$after_msg');
			//-->
		</script>
	");
}
if ($after_db_script == '') {
	$move_page_link = "{$root}{$site_info[index_file]}?design_file={$board_info[list_page]}&{$move_page_link_tail}";
	$GLOBALS[lib_common]->alert_url('', 'E', $move_page_link);
} else {
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = str_replace("%LINK%", $move_page_link_tail, $after_db_script);
	echo("
		<script language='javascript1.2'>
			<!--
				$after_db_script
			//-->
		</script>
	");	
}
?>