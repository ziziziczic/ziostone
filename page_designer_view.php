<?
/*----------------------------------------------------------------------------------
 * 제목 : 인사이트 디자이너 메인메뉴 프로그램
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
$root = "./";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$auth_method_array = array(array('L', 1, $user_info[user_level], 'E'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) {
	$prev_url_encode = urlencode($_SERVER[HTTP_REFERER]);
	$GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);
}
include "{$DIRS[designer_root]}page_designer_view.php";
?>