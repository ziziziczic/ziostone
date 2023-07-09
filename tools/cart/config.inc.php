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
	$vg_cart_session_save_dir = "{$vg_cart_dir_site_root}_session";
	session_save_path($vg_cart_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}
// 상수정의
define("VG_CART_INCLUDE", "YES");

// 장바구니 이름
$vg_cart_name = "cart";
$vg_cart_var_select_serials_name = "list_select";	// 선택상자 이름.

// DB 필드매칭
$vg_cart_match[serial_num] = "serial_num";
$vg_cart_match[name] = "subject";
$vg_cart_match[price] = "email";
$vg_cart_match[quantity] = "homepage";
$vg_cart_match[option1] = "etc_1";
$vg_cart_match[option2] = "etc_2";
$vg_cart_match[option3] = "etc_3";
$vg_cart_match[option_div] = ':';

// 디렉토리 설정부
$vg_cart_dir_info = array();
$vg_cart_dir_info[root] = "{$vg_cart_dir_site_root}tools/{$vg_cart_name}/";	// 프로그램 루트 디렉토리 ($vg_cart_dir_site_root 는 본 파일을 인클루드 하기 전에 설정해줌)
$vg_cart_dir_info['include'] = $vg_cart_dir_info[root] . "include/";
$vg_cart_dir_info[images] = $vg_cart_dir_info[root] . "images/";

// DB연결 및 기존 사이트 설정파일 연동
include_once "{$vg_cart_dir_site_root}db.inc.php";

// 공통파일 설정부
$vg_cart_file[search_addr] = "{$vg_cart_dir_site_root}member/zipsearch.php";
$vg_cart_file['list'] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=list.php";
$vg_cart_file[update] = "{$vg_cart_dir_info[root]}cart_update.php";
$vg_cart_file[order] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=cart_order_form.php";
$vg_cart_file[order_confirm] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=cart_order_confirm.php";
$vg_cart_file[order_complete] = '';	// 주문완료후 이동페이지 (값이 없으면 창닫기)
$vg_cart_file[order_list] = "{$vg_cart_dir_site_root}designer/order_list.php?";								// 관리자용
$vg_cart_file[order_detail] = "{$vg_cart_dir_site_root}designer/order_detail.php?";					// 관리자용


// 주요 변수 정의부
$vg_cart_setup = array("use_fix_date"=>'N', "use_bank"=>'Y', "use_card"=>'N', "use_cyber_money"=>'Y', "usable_cyber_money"=>"3000", "usable_card"=>"1000");	// 설정정보 변수
$vg_cart_var_name[total] = "vg_cart_{$vg_cart_name}_total";
$vg_cart_var_name[board_name] = "vg_cart_{$vg_cart_name}_board_name_";
$vg_cart_var_name[serial_num] = "vg_cart_{$vg_cart_name}_serial_num_";
$vg_cart_var_name[name] = "vg_cart_{$vg_cart_name}_name_";
$vg_cart_var_name[price] = "vg_cart_{$vg_cart_name}_price_";
$vg_cart_var_name[quantity] = "vg_cart_{$vg_cart_name}_quantity_";
$vg_cart_var_name[option1] = "vg_cart_{$vg_cart_name}_option1_";
$vg_cart_var_name[option2] = "vg_cart_{$vg_cart_name}_option2_";
$vg_cart_var_name[option3] = "vg_cart_{$vg_cart_name}_option3_";
$vg_cart_account = array("국민은행 350402-04-003788 이주한");
$vg_cart_order_state = array('A'=>"확인중", 'B'=>"준비중", 'C'=>"배송중", 'D'=>"배송완료");

$vg_db_tables = array("order_list"=>"VG_CART_order_list");

// 공용라이브러리객체생성
if ($GLOBALS[lib_common] == '') {
	include "{$vg_cart_dir_site_root}include/library_common.class.php";
	$lh_common = new library_common();
} else {
	$lh_common = $GLOBALS[lib_common];
}

// 전용라이브러리객체생성
include "{$vg_cart_dir_info['include']}library_vg_cart.class.php";
$lh_vg_cart = new library_vg_cart();

// 사용자정의 함수
@include "{$vg_cart_dir_info['include']}user_function.inc.php";

if ($_SESSION[user_id] != '') {
	$vg_cart_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
	$vg_cart_user_info[cyber_money] = vg_op_get_cyber_money($_SESSION[user_id]);
} else {
	$vg_cart_user_info[user_level] = 8;
}
?>