<?
##########################################################################
##  프로그램명 : insiter(인사이터 - 메일링) v1.00
##  프로그램등록번호 : 2002-01-23-3677
##  저작권자 : 이주한
##  대한민국 컴퓨터 프로그램 보호법 제 23조 제1항 및 동법시행령 제16조의 규정에 의해 보호됨.
##########################################################################
##  최초 개발 완료일: 2002. 1. 20
##  2차 수정일 : 2002. 12. 17
##  개발사 : 밸리게이트(VALLEYGATE / 305-14-73405)
##  홈페이지 : http://www.ohmysite.co.kr)
##  책임개발자 : 이주한
##########################################################################
##
##  카피라이트 공지
##  ----------------------------------------------------------------------
##  본 프로그램은 무료 프로그램이 아닙니다. 본 프로그램은 국제법 및 대한민국
##  법률에 의하여 저작권을 보호받고 있는 상용 소프트웨어 입니다. 본 프로그램
##  에 대한, 재판매, 수정판매, 무단 배포등은 형사상의 불법행위입니다.
##  또한, 오마이사이트의 동의 없이 본 프로그램에 대한 임의적인 부분 수정 및
##  변경, 삭제 또한 불법행위로 간주됩니다.
##
##  기술적 지원 공지
##  ----------------------------------------------------------------------
##  본 프로그램의 정식 구입자는 1 Account 사용권한이 주어진 것이며 오마이사이트로부터 기술적인 지원을 받을 수
##  있습니다. 단, 본 화일을 임의적으로 수정을 하거나, 변경이 되었을 경우에는
##  기술적인 지원에 추가 비용이 청구될수 있으며, 기술적 지원에 어려움을 겪을 
##  수 있습니다.
##  프로그램에 대한 자세한 문의 혹은 제휴상담은 0505-823-2323 이나 help@ohmysite.co.kr 로 주시기 바랍니다.
##
##########################################################################

// 헤더, 세션선언부 (기존 사이트에 탑재시, 필요에 따라 수정 될 수 있음)
$GLOBALS[w_gmdate] = gmdate("D, d M Y H:i:s") . " GMT"; // 현재시각 설정
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $GLOBALS[w_gmdate]);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
$vg_mailing_session_save_dir = "{$vg_mailing_dir_site_root}_session";	// 세선선언부
session_save_path($vg_mailing_session_save_dir);
session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
session_start();

$GLOBALS[w_time] = time();	// 현재 시간(리눅스타임스탬프)
define("VG_MAILING_INCLUDE", "YES");

// 디렉토리 설정부
$vg_mailing_dir_info = array();
$vg_mailing_dir_info[root] = "{$vg_mailing_dir_site_root}tools/mailing/";	// 프로그램 루트 디렉토리 ($vg_mailing_dir_site_root 는 본 파일을 인클루드 하기 전에 설정해줌)
$vg_mailing_dir_info['include'] = $vg_mailing_dir_info[root] . "include/";
$vg_mailing_dir_info[images] = $vg_mailing_dir_info[root] . "images/";
$vg_mailing_dir_info[contents] = $vg_mailing_dir_info[root] . "contents_file/";

// DB연결 및 기존 사이트 설정파일 연동
include "{$vg_mailing_dir_info[root]}db.inc.php";

// 공용라이브러리객체생성
include "{$vg_mailing_dir_site_root}include/library_common.class.php";
$lh_common = $GLOBALS[lib_common] = new library_common();

// 전용라이브러리객체생성
include "{$vg_mailing_dir_info['include']}library_vg_mailing.class.php";
$lh_vg_mailing = new library_vg_mailing();

// 인코딩 라이브러리 객체 생성
include "{$vg_mailing_dir_site_root}include/library_fix.class.php";
$lib_fix = new library_fix();

// 사이트 정보 추출
$site_info = $lib_fix->get_site_info();

// 사용자정의 함수
@include "{$vg_mailing_dir_info['include']}user_function.inc.php";

// 주요 변수 정의부
$vg_mailing_setup = array("send_pack"=>100, "send_term"=>3, "default_name"=>"고객", "divider"=>';', "test_email"=>$site_info[site_email], "send_email"=>$site_info[site_email], "send_name"=>$site_info[site_name]);	// 설정정보
$vg_mailing_inc = array('C'=>"포함", 'B'=>"별도");
$vg_mailing_field_name = array("name"=>"name", "email"=>"email");

// 공통파일 설정부
$vg_mailing_file[mail_form] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=send_mail_form.php";
$vg_mailing_file[history_list] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=history.php";
$vg_mailing_file[history_view] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=history_view.php";
$vg_mailing_file[die_msg] = "{$vg_mailing_dir_info['include']}skin_die.html";

if ($_SESSION[user_id] != '') {
	$vg_mailing_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
} else {
	$vg_mailing_user_info[user_level] = 8;
}
$auth_method_array = array(array('L', '1', $vg_mailing_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) $lh_common->die_msg("권한이 없습니다.", $vg_mailing_file[die_msg]);
?>