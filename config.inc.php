<?
##########################################################################
##
##  프로그램명 : insiter(인사이터) v2.10
##  프로그램등록번호 : 2002-01-23-3677
##  저작권자 : 이주한
##  대한민국 컴퓨터 프로그램 보호법 제 23조 제1항 및 동법시행령 제16조의 규정에 의해 보호됨.
##########################################################################
##  최초 개발 완료일 : 2002. 1. 20
##	 상용버전 완료일: 2006. 3. 4
##  개발사 : 밸리게이트(VALLEYGATE / 305-14-73405)
##  홈페이지 : http://wams.kr)
##  책임개발자 : 이주한
##########################################################################
##
##  카피라이트 공지
##  ----------------------------------------------------------------------
##  본 프로그램은 무료 프로그램이 아닙니다. 본 프로그램은 국제법 및 대한민국
##  법률에 의하여 저작권을 보호받고 있는 상용 소프트웨어 입니다. 본 프로그램
##  에 대한, 재판매, 수정판매, 무단 배포등은 형사상의 불법행위입니다.
##
##  기술적 지원 공지
##  ----------------------------------------------------------------------
##  본 프로그램의 정식 구입자는 1 Account 사용권한이 주어진 것이며 밸리게이트로부터 기술적인 지원을 받을 수
##  있습니다. 단, 본 프로그램을 임의적으로 수정을 하거나, 변경이 되었을 경우에는
##  기술적인 지원에 추가 비용이 청구될수 있으며, 기술적 지원에 어려움을 겪을 
##  수 있습니다.
##  프로그램에 대한 자세한 문의 혹은 제휴상담은 0505-823-2323 이나 help@ohmysite.co.kr 로 주시기 바랍니다.
##
##########################################################################

define("INSITER_INCLUDE", "YES");

// 관리자 디렉토리명
$GLOBALS[admin_dir_name] = "designer";

// 경로정의
$DIRS = array();
$DIRS[images] = "{$root}images/";
$DIRS[designer_root] = "{$root}{$GLOBALS[admin_dir_name]}/";
$DIRS[design_root] = "{$root}design/";
$DIRS[upload_root] = "{$DIRS[design_root]}upload_file/";
$DIRS[member_root] = "{$root}member/";
$DIRS[board_root] = "{$root}board/";
$DIRS[template] = "{$root}template/";
$DIRS[include_root] = "{$root}include/";
$DIRS[user_define] = "{$DIRS[include_root]}user_define/";
$DIRS[tools_root] = "{$root}tools/";
$DIRS[user_root] = "{$root}user_dir/";

// 사용자파일경로
$DIRS[member_img] = "{$DIRS[user_root]}member/";
$DIRS[popup_img] = "{$DIRS[user_root]}popup/";

// 디자인파일 분할코드 정의
$GLOBALS[DV][dv] = "|";
$GLOBALS[DV][tdv] = "l";

// 설정값 분할 코드 정의
$GLOBALS[DV][ct1] = "\n";
$GLOBALS[DV][ct2] = ';';
$GLOBALS[DV][ct3] = ',';
$GLOBALS[DV][ct4] = '~';
$GLOBALS[DV][ct5] = ':';
$GLOBALS[DV][ct6] = '-';
$GLOBALS[DV][ct7] = '!';

//@extract($HTTP_GET_VARS);
//@extract($HTTP_POST_VARS);

ini_set("session.cache_expire", 60*24);				// 세션 유효기간 : 분 (1시간) 
ini_set("session.gc_maxlifetime", 3600*24);		// 세션 가비지 컬렉션 : 초(1시간) 
session_save_path("{$root}_session");
$PU_host = parse_url("http://{$_SERVER[HTTP_HOST]}");
session_set_cookie_params(0,"/", ".{$PU_host[host]}");
session_start();

$GLOBALS[w_time] = time();	// 현재 시간(리눅스타임스탬프)
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

// 공용 라이브러리 객체 생성
include "{$root}include/library_common.class.php";
$lib_common = new library_common();
$GLOBALS[lib_common] = $lib_common;

// 전용 라이브러리 객체 생성
include "{$root}include/library_insiter.class.php";
$lib_insiter = new library_insiter();

// 인코딩 라이브러리 객체 생성
include "{$root}include/library_fix.class.php";
$lib_fix = new library_fix();

// 사이트 정보 추출
$site_info = $lib_fix->get_site_info();
if ($_GET[design_file] != '') $site_page_info = $lib_fix->get_site_page_info($_GET[design_file]);	// 페이지 정보 추출
$site_info[life_month_cookie] = 12;
$site_info[cnt_history] = 7;
$site_info[directory_permission] = 0707;
$S_auth_method = array('A'=>"자동인증", 'P'=>"수동인증");		// 회원인증방식

// 사용자정보 추출
if ($_SESSION[user_id] != '') $user_info = $lib_fix->get_user_info($_SESSION[user_id]);
else $user_info[user_level] = 8;
$user_level_alias = $lib_insiter->get_level_alias($site_info[user_level_alias]);
$S_user_state = array('A'=>"활성", 'W'=>"인증대기", 'X'=>"활동중지");
$S_user_state_msg = array('W'=>"회원님께서는 인증 대기중인 상태 입니다.\\n\\n관리자에게 문의해 주십시오", 'X'=>"회원님께서는 관리자에 의해 사용중지된 상태 입니다.\\n\\n관리자에게 문의해 주십시오");

// 시스템 변수 설정
$GLOBALS[VI] = array();
$GLOBALS[VI][admin_level_user] = 1;			// 사용자 모드에서의 관리자 레벨
$GLOBALS[VI][admin_level_admin] = 1;		// 관리자 모드에서의 관리자 레벨
if ($site_page_info[default_file_dir] != '') $GLOBALS[VI][default_file_dir] = $site_page_info[default_file_dir];	// 기본 업로드 디렉토리
else $GLOBALS[VI][default_file_dir] = $site_info[default_file_dir];
$GLOBALS[VI][deny_ext] = array("php", "php3", "php4", "html", "htm", "phtml", "xhtml");
$GLOBALS[VI][img_ext] = array("gif", "jpg");
$GLOBALS[VI][flash_ext] = array("swf");
$GLOBALS[VI][allow_ext] = array("xls", "doc", "pdf", "ppt", "gif", "jpg", "swf", "hwp", "hgl", "zip", "tar", "tgz", "gz");
$GLOBALS[VI][mail_form] = "{$DIRS[tools_root]}form_mail/design/form_1/index.html";
$GLOBALS[VI][default_cm] = 1000;	// 추천인적립 기본액수
$GLOBALS[VI][ppa] = 20;
$GLOBALS[VI][ppb] = 10;
$GLOBALS[VI][ppa_cm] = 20;
$GLOBALS[VI][ppb_cm] = 10;
$GLOBALS[VI][default_index_file] = "index.html";
$GLOBALS[VI][default_err_msg_admin] = "<br><br><br><center><font color=red>접근권한이 없습니다. 귀하의 접속 아이피 주소 $_SERVER[REMOTE_ADDR] 기록되었음</font></center>";
$GLOBALS[VI][default_err_msg] = "로그인후 이용하세요.";
$GLOBALS[VI][die_skin] = "{$DIRS[admin]}skin/die.html";
$GLOBALS[VI][thema] = $IS_thema;
$GLOBALS[VI][DD_search_field] = "A{$GLOBALS[DV][ct2]}통합검색{$GLOBALS[DV][ct1]}subject{$GLOBALS[DV][ct2]}제목{$GLOBALS[DV][ct1]}writer_name{$GLOBALS[DV][ct2]}작성자{$GLOBALS[DV][ct1]}comment_1{$GLOBALS[DV][ct2]}내용";
$GLOBALS[VI][sec_char] = array("name"=>"OO", "phone"=>"*** - **** - ****", "email"=>"*******", "homepage"=>"******.**.**");
$GLOBALS[VI][login_term] = 60*0.1; // 로그인 로그 생성간격 (초 단위)
$GLOBALS[VI][state_cm] = array('R'=>"미반영", 'F'=>"반영");
$GLOBALS[VI][html_br_method] = "auto";																	// html br 출력정책 (auto 자동으로 nl2br, noto 수동)
$GLOBALS[VI][ip_block_move_url] = "http://www.jiibsite.co.kr";
$GLOBALS[VI][protocol] = "http";			// 프로토콜(보안인증서등)
$IS_withdrawal_question = array('A'=>"서비스장애와 오류", 'B'=>"유용한 정보의 부족", 'C'=>"고객서비스 불만", 'D'=>"복잡한 구성으로인한 불편", 'E'=>"기타");

// 이메일 전송 정보
$send_mail_etc_info[contents_etc] = "<hr>고객을 먼저 생각하는 기업!!, 최상의 정보로 고객님께 먼저 다가갑니다.";
$send_mail_etc_info[default_adver_file] = "http://jiibsite.net/share/adver/default.html?site_url={$_SERVER[HTTP_HOST]}";

// 사용자정의 함수
include "{$DIRS[include_root]}user_define/user_function.inc.php";

// 쇼핑몰관련 설정
if ($DIRS[shop_root] != '') include "{$DIRS[shop_root]}shop.inc.php";

// ip 차단 (관리자는 해당없음)
if ($site_info[ip_block] != '' && $user_info[user_level] > 1) {
	if ($lib_insiter->ip_block(explode($GLOBALS[DV][ct1], trim($site_info[ip_block])), $_SERVER[REMOTE_ADDR]) == "BLOCK") $GLOBALS[lib_common]->alert_url('', 'E', $GLOBALS[VI][ip_block_move_url], "document");
}
?>