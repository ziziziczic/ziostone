<?
##########################################################################
##
##  ���α׷��� : insiter(�λ�����) v2.10
##  ���α׷���Ϲ�ȣ : 2002-01-23-3677
##  ���۱��� : ������
##  ���ѹα� ��ǻ�� ���α׷� ��ȣ�� �� 23�� ��1�� �� ��������� ��16���� ������ ���� ��ȣ��.
##########################################################################
##  ���� ���� �Ϸ��� : 2002. 1. 20
##	 ������ �Ϸ���: 2006. 3. 4
##  ���߻� : �븮����Ʈ(VALLEYGATE / 305-14-73405)
##  Ȩ������ : http://wams.kr)
##  å�Ӱ����� : ������
##########################################################################
##
##  ī�Ƕ���Ʈ ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� ���α׷��� �ƴմϴ�. �� ���α׷��� ������ �� ���ѹα�
##  ������ ���Ͽ� ���۱��� ��ȣ�ް� �ִ� ��� ����Ʈ���� �Դϴ�. �� ���α׷�
##  �� ����, ���Ǹ�, �����Ǹ�, ���� �������� ������� �ҹ������Դϴ�.
##
##  ����� ���� ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� �����ڴ� 1 Account �������� �־��� ���̸� �븮����Ʈ�κ��� ������� ������ ���� ��
##  �ֽ��ϴ�. ��, �� ���α׷��� ���������� ������ �ϰų�, ������ �Ǿ��� ��쿡��
##  ������� ������ �߰� ����� û���ɼ� ������, ����� ������ ������� ���� 
##  �� �ֽ��ϴ�.
##  ���α׷��� ���� �ڼ��� ���� Ȥ�� ���޻���� 0505-823-2323 �̳� help@ohmysite.co.kr �� �ֽñ� �ٶ��ϴ�.
##
##########################################################################

define("INSITER_INCLUDE", "YES");

// ������ ���丮��
$GLOBALS[admin_dir_name] = "designer";

// �������
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

// ��������ϰ��
$DIRS[member_img] = "{$DIRS[user_root]}member/";
$DIRS[popup_img] = "{$DIRS[user_root]}popup/";

// ���������� �����ڵ� ����
$GLOBALS[DV][dv] = "|";
$GLOBALS[DV][tdv] = "l";

// ������ ���� �ڵ� ����
$GLOBALS[DV][ct1] = "\n";
$GLOBALS[DV][ct2] = ';';
$GLOBALS[DV][ct3] = ',';
$GLOBALS[DV][ct4] = '~';
$GLOBALS[DV][ct5] = ':';
$GLOBALS[DV][ct6] = '-';
$GLOBALS[DV][ct7] = '!';

//@extract($HTTP_GET_VARS);
//@extract($HTTP_POST_VARS);

ini_set("session.cache_expire", 60*24);				// ���� ��ȿ�Ⱓ : �� (1�ð�) 
ini_set("session.gc_maxlifetime", 3600*24);		// ���� ������ �÷��� : ��(1�ð�) 
session_save_path("{$root}_session");
$PU_host = parse_url("http://{$_SERVER[HTTP_HOST]}");
session_set_cookie_params(0,"/", ".{$PU_host[host]}");
session_start();

$GLOBALS[w_time] = time();	// ���� �ð�(������Ÿ�ӽ�����)
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

// ���� ���̺귯�� ��ü ����
include "{$root}include/library_common.class.php";
$lib_common = new library_common();
$GLOBALS[lib_common] = $lib_common;

// ���� ���̺귯�� ��ü ����
include "{$root}include/library_insiter.class.php";
$lib_insiter = new library_insiter();

// ���ڵ� ���̺귯�� ��ü ����
include "{$root}include/library_fix.class.php";
$lib_fix = new library_fix();

// ����Ʈ ���� ����
$site_info = $lib_fix->get_site_info();
if ($_GET[design_file] != '') $site_page_info = $lib_fix->get_site_page_info($_GET[design_file]);	// ������ ���� ����
$site_info[life_month_cookie] = 12;
$site_info[cnt_history] = 7;
$site_info[directory_permission] = 0707;
$S_auth_method = array('A'=>"�ڵ�����", 'P'=>"��������");		// ȸ���������

// ��������� ����
if ($_SESSION[user_id] != '') $user_info = $lib_fix->get_user_info($_SESSION[user_id]);
else $user_info[user_level] = 8;
$user_level_alias = $lib_insiter->get_level_alias($site_info[user_level_alias]);
$S_user_state = array('A'=>"Ȱ��", 'W'=>"�������", 'X'=>"Ȱ������");
$S_user_state_msg = array('W'=>"ȸ���Բ����� ���� ������� ���� �Դϴ�.\\n\\n�����ڿ��� ������ �ֽʽÿ�", 'X'=>"ȸ���Բ����� �����ڿ� ���� ��������� ���� �Դϴ�.\\n\\n�����ڿ��� ������ �ֽʽÿ�");

// �ý��� ���� ����
$GLOBALS[VI] = array();
$GLOBALS[VI][admin_level_user] = 1;			// ����� ��忡���� ������ ����
$GLOBALS[VI][admin_level_admin] = 1;		// ������ ��忡���� ������ ����
if ($site_page_info[default_file_dir] != '') $GLOBALS[VI][default_file_dir] = $site_page_info[default_file_dir];	// �⺻ ���ε� ���丮
else $GLOBALS[VI][default_file_dir] = $site_info[default_file_dir];
$GLOBALS[VI][deny_ext] = array("php", "php3", "php4", "html", "htm", "phtml", "xhtml");
$GLOBALS[VI][img_ext] = array("gif", "jpg");
$GLOBALS[VI][flash_ext] = array("swf");
$GLOBALS[VI][allow_ext] = array("xls", "doc", "pdf", "ppt", "gif", "jpg", "swf", "hwp", "hgl", "zip", "tar", "tgz", "gz");
$GLOBALS[VI][mail_form] = "{$DIRS[tools_root]}form_mail/design/form_1/index.html";
$GLOBALS[VI][default_cm] = 1000;	// ��õ������ �⺻�׼�
$GLOBALS[VI][ppa] = 20;
$GLOBALS[VI][ppb] = 10;
$GLOBALS[VI][ppa_cm] = 20;
$GLOBALS[VI][ppb_cm] = 10;
$GLOBALS[VI][default_index_file] = "index.html";
$GLOBALS[VI][default_err_msg_admin] = "<br><br><br><center><font color=red>���ٱ����� �����ϴ�. ������ ���� ������ �ּ� $_SERVER[REMOTE_ADDR] ��ϵǾ���</font></center>";
$GLOBALS[VI][default_err_msg] = "�α����� �̿��ϼ���.";
$GLOBALS[VI][die_skin] = "{$DIRS[admin]}skin/die.html";
$GLOBALS[VI][thema] = $IS_thema;
$GLOBALS[VI][DD_search_field] = "A{$GLOBALS[DV][ct2]}���հ˻�{$GLOBALS[DV][ct1]}subject{$GLOBALS[DV][ct2]}����{$GLOBALS[DV][ct1]}writer_name{$GLOBALS[DV][ct2]}�ۼ���{$GLOBALS[DV][ct1]}comment_1{$GLOBALS[DV][ct2]}����";
$GLOBALS[VI][sec_char] = array("name"=>"OO", "phone"=>"*** - **** - ****", "email"=>"*******", "homepage"=>"******.**.**");
$GLOBALS[VI][login_term] = 60*0.1; // �α��� �α� �������� (�� ����)
$GLOBALS[VI][state_cm] = array('R'=>"�̹ݿ�", 'F'=>"�ݿ�");
$GLOBALS[VI][html_br_method] = "auto";																	// html br �����å (auto �ڵ����� nl2br, noto ����)
$GLOBALS[VI][ip_block_move_url] = "http://www.jiibsite.co.kr";
$GLOBALS[VI][protocol] = "http";			// ��������(������������)
$IS_withdrawal_question = array('A'=>"������ֿ� ����", 'B'=>"������ ������ ����", 'C'=>"������ �Ҹ�", 'D'=>"������ ������������ ����", 'E'=>"��Ÿ");

// �̸��� ���� ����
$send_mail_etc_info[contents_etc] = "<hr>���� ���� �����ϴ� ���!!, �ֻ��� ������ ���Բ� ���� �ٰ����ϴ�.";
$send_mail_etc_info[default_adver_file] = "http://jiibsite.net/share/adver/default.html?site_url={$_SERVER[HTTP_HOST]}";

// ��������� �Լ�
include "{$DIRS[include_root]}user_define/user_function.inc.php";

// ���θ����� ����
if ($DIRS[shop_root] != '') include "{$DIRS[shop_root]}shop.inc.php";

// ip ���� (�����ڴ� �ش����)
if ($site_info[ip_block] != '' && $user_info[user_level] > 1) {
	if ($lib_insiter->ip_block(explode($GLOBALS[DV][ct1], trim($site_info[ip_block])), $_SERVER[REMOTE_ADDR]) == "BLOCK") $GLOBALS[lib_common]->alert_url('', 'E', $GLOBALS[VI][ip_block_move_url], "document");
}
?>