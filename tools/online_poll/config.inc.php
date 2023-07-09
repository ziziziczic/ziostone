<?
if (INSITER_INCLUDE != "YES") {
	// 헤더 선언부
	$GLOBALS[w_gmdate] = gmdate("D, d M Y H:i:s") . " GMT"; // 현재시각 설정
	$GLOBALS[w_time] = time();	// 현재 시간(리눅스타임스탬프)
	$GLOBALS[JS_CODE] = array();		// 자바스크립트 코드값을 저장한다.(인자값없이 한번만 나오면 되는 함수들을 저장하고 맨 아래쪽에 출력)

	header("Expires: 0"); // rfc2616 - Section 14.21
	header("Last-Modified: " . $GLOBALS[w_gmdate]);
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
	header("Pragma: no-cache"); // HTTP/1.0

	// 세선선언부(기존 사이트에 탑재시, 필요에 따라 수정 될 수 있음)
	$VG_OP_session_save_dir = "{$VG_OP_dir_site_root}_session";
	session_save_path($VG_OP_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}

// 상수정의
define("VG_OP_INCLUDE", "YES");

// 디렉토리 설정부
$VG_OP_dir_info = array();
$VG_OP_dir_info[root] = "{$VG_OP_dir_site_root}tools/online_poll/";	// 프로그램 루트 디렉토리 ($VG_OP_dir_site_root 는 본 파일을 인클루드 하기 전에 설정해줌)
$VG_OP_dir_info['include'] = $VG_OP_dir_info[root] . "include/";
$VG_OP_dir_info[images] = $VG_OP_dir_info[root] . "images/";
$VG_OP_dir_info[skin] = $VG_OP_dir_info[root] . "skin/";
$VG_OP_dir_info[upload_file] = $VG_OP_dir_info[root] . "upload_file/";
$VG_OP_dir_info[etc] = $VG_OP_dir_info[root] . "etc/";
$VG_OP_dir_info[user_define] = $VG_OP_dir_info[root] . "user_define/";

// DB연결 및 기존 사이트 설정파일 연동
if ($root == '') $root = "../../";
include_once "{$VG_OP_dir_info['include']}db.inc.php";
include_once "{$root}/config.inc.php";	

// 공통파일 설정부
$VG_OP_file['list'] = "{$VG_OP_dir_info[root]}?VG_OP_file_name=list.php";

// 주요 변수 정의부
$VG_OP_setup = array("admin_id"=>$site_info[site_id], "method"=>array('R'=>"라디오", 'C'=>"체크상자"), "q_num"=>10);	// 1차분류

// 공용라이브러리객체생성
//include "{$VG_OP_dir_info['include']}library_common.class.php";
//$lh_common = new library_common();
$lh_common = $lib_common;

// 전용라이브러리객체생성
include "{$VG_OP_dir_info['include']}library_vg_op.class.php";
$lh_vg_op = new library_vg_op();

// 사용자정보매칭 (레벨 : 관리자 1 / 고급 2~6 / 일반 7)
$VG_OP_user_info = array("serial_num"=>$user_info[serial_num], "id"=>$user_info[id], "name"=>$user_info[name], "level"=>$user_info[user_level]); // array(일련번호 / 아이디 / 레벨 / 기타)
$VG_OP_user_level = '7';
$VG_OP_admin_level = '1';

// 사용자정의 함수
@include "{$VG_OP_dir_info[user_define]}user_function.inc.php";
?>