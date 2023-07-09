<?
##########################################################################
##  프로그램명 : insiter(인사이터) v1.00
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

$SESS_DBHOST = "localhost";
$SESS_DBNAME = "krstonecokr";
$SESS_DBUSER = "krstonecokr";

if (!$SESS_DBH = mysql_connect($SESS_DBHOST, $SESS_DBUSER, "kr!@stone*04")) {
	echo "<li>Can't connect to $SESS_DBHOST as $SESS_DBUSER";
	echo "<li>MySQL Error: ", mysql_error();
	die;
}
if (!mysql_select_db($SESS_DBNAME, $SESS_DBH)) {
	echo "<li>Unable to select database $SESS_DBNAME";
	die;
}

// DB 테이블명 정의
$DB_TABLES = array();
$DB_TABLES[site_info] = "TCSYSTEM_site_info";															// 사이트 정보
$DB_TABLES[design_files] = "TCSYSTEM_design_files";												// 디자인 파일 목록
$DB_TABLES[design_history] = "TCSYSTEM_design_history";									// 디자인 파일 히스토리
$DB_TABLES[member] = "TCMEMBER";																				// 회원정보
$DB_TABLES[member_visit] = "TCMEMBER_login_log";												// 회원로그인정보
$DB_TABLES[member_visit_ranking] = "TCMEMBER_login_ranking";					// 회원로그인순위
$DB_TABLES[member_withdrawal] = "TCMEMBER_withdrawal";							// 회원탈퇴정보
$DB_TABLES[member_stat_join] = "TCMEMBER_stat_join";										// 회원가입현황분석
$DB_TABLES[member_stat_withdrawal] = "TCMEMBER_stat_withdrawal";		// 회원탈퇴현황분석
$DB_TABLES[board] = "TCBOARD";																						// 게시판
$DB_TABLES[board_list] = "TCSYSTEM_board_list";														// 게시판목록
$DB_TABLES[popup] = "TCSYSTEM_popup";																		// 팝업창 목록
$DB_TABLES[visit] = "TCSYSTEM_visit";																				// 방문객통계분석
$DB_TABLES[visit_total] = "TCSYSTEM_visit_total";
$DB_TABLES[post] = "TCSYSTEM_post_table";																// 주소
$DB_TABLES[cyber_money] = "TCSYSTEM_cyber_money";										// 적립금
$DB_TABLES[tax_list] = "VG_TAX_tax_list";																		// 계산서 목록
?>
