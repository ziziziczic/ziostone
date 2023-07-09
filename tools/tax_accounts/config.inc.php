<?
##########################################################################
##  프로그램명 : insiter(인사이터 - 세금계산서) v1.00
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
	$vg_tax_session_save_dir = "{$vg_tax_dir_site_root}_session";
	session_save_path($vg_tax_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}
// 상수정의
define("VG_TAX_INCLUDE", "YES");

// 주요 변수 정의부
$vg_tax_setup = array("dir_name"=>"tax_accounts", "tax_ppa"=>10, "tax_ppb"=>10, "buyer_ppa"=>10, "buyer_ppb"=>10, "use_buyer_id"=>'Y');	// 설정정보
$vg_tax_setup[tax_inc] = 'B';					// 부가세 포함여부 기본값 (계산서 발급시 수정가능)
$vg_tax_biz_info = array("name"=>"밸리게이트", "number"=>"3051473405", "ceo"=>"이주한", "address"=>"서울특별시 영등포구 대림2동 993-2번지 301호", "cond"=>"컴퓨터운용관련소매", "type"=>"소프트웨어개발판매,전자상거래", "default_email"=>"help@ohmysite.co.kr");
$vg_tax_pay = array('A'=>"영수", 'B'=>"청구");
$vg_tax_inc = array('C'=>"포함", 'B'=>"별도");

// 디렉토리 설정부
$vg_tax_dir_info = array();
$vg_tax_dir_info[root] = "{$vg_tax_dir_site_root}tools/{$vg_tax_setup[dir_name]}/";	// 프로그램 루트 디렉토리 ($vg_tax_dir_site_root 는 본 파일을 인클루드 하기 전에 설정해줌)
$vg_tax_dir_info['include'] = $vg_tax_dir_info[root] . "include/";
$vg_tax_dir_info[images] = $vg_tax_dir_info[root] . "images/";

// DB연결 및 기존 사이트 설정파일 연동
include "{$vg_tax_dir_info[root]}db.inc.php";

// 공통파일 설정부
$vg_tax_file[tax_view] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_view.php";
$vg_tax_file[tax_input_form] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_list.php";
$vg_tax_file[tax_list] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_list.php";
$vg_tax_file[buyer_list] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=buyer_list.php";
$vg_tax_file[skin_die] = "{$vg_tax_dir_info['include']}skin_die.html";
$vg_tax_file[skin_mail] = "{$vg_tax_dir_info['include']}skin_mail.html";


// 공용라이브러리객체생성
if ($GLOBALS[lib_common] == '') {
	include "{$vg_tax_dir_site_root}include/library_common.class.php";
	$lh_common = new library_common();
} else {
	$lh_common = $GLOBALS[lib_common];
}

// 전용라이브러리객체생성
include "{$vg_tax_dir_info['include']}library_vg_tax.class.php";
$lh_vg_tax = new library_vg_tax();

// 사용자정의 함수
@include "{$vg_tax_dir_info['include']}user_function.inc.php";

if ($_SESSION[user_id] != '') {
	$vg_tax_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
} else {
	$vg_tax_user_info[user_level] = 8;
}
?>