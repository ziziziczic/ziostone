<?
##########################################################################
##  ���α׷��� : insiter(�λ�����) v1.00
##  ���α׷���Ϲ�ȣ : 2002-01-23-3677
##  ���۱��� : ������
##  ���ѹα� ��ǻ�� ���α׷� ��ȣ�� �� 23�� ��1�� �� ��������� ��16���� ������ ���� ��ȣ��.
##########################################################################
##  ���� ���� �Ϸ���: 2002. 1. 20
##  2�� ������ : 2002. 12. 17
##  ���߻� : �븮����Ʈ(VALLEYGATE / 305-14-73405)
##  Ȩ������ : http://www.ohmysite.co.kr)
##  å�Ӱ����� : ������
##########################################################################
##
##  ī�Ƕ���Ʈ ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� ���α׷��� �ƴմϴ�. �� ���α׷��� ������ �� ���ѹα�
##  ������ ���Ͽ� ���۱��� ��ȣ�ް� �ִ� ��� ����Ʈ���� �Դϴ�. �� ���α׷�
##  �� ����, ���Ǹ�, �����Ǹ�, ���� �������� ������� �ҹ������Դϴ�.
##  ����, �����̻���Ʈ�� ���� ���� �� ���α׷��� ���� �������� �κ� ���� ��
##  ����, ���� ���� �ҹ������� ���ֵ˴ϴ�.
##
##  ����� ���� ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� �����ڴ� 1 Account �������� �־��� ���̸� �����̻���Ʈ�κ��� ������� ������ ���� ��
##  �ֽ��ϴ�. ��, �� ȭ���� ���������� ������ �ϰų�, ������ �Ǿ��� ��쿡��
##  ������� ������ �߰� ����� û���ɼ� ������, ����� ������ ������� ���� 
##  �� �ֽ��ϴ�.
##  ���α׷��� ���� �ڼ��� ���� Ȥ�� ���޻���� 0505-823-2323 �̳� help@ohmysite.co.kr �� �ֽñ� �ٶ��ϴ�.
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

// DB ���̺�� ����
$DB_TABLES = array();
$DB_TABLES[site_info] = "TCSYSTEM_site_info";															// ����Ʈ ����
$DB_TABLES[design_files] = "TCSYSTEM_design_files";												// ������ ���� ���
$DB_TABLES[design_history] = "TCSYSTEM_design_history";									// ������ ���� �����丮
$DB_TABLES[member] = "TCMEMBER";																				// ȸ������
$DB_TABLES[member_visit] = "TCMEMBER_login_log";												// ȸ���α�������
$DB_TABLES[member_visit_ranking] = "TCMEMBER_login_ranking";					// ȸ���α��μ���
$DB_TABLES[member_withdrawal] = "TCMEMBER_withdrawal";							// ȸ��Ż������
$DB_TABLES[member_stat_join] = "TCMEMBER_stat_join";										// ȸ��������Ȳ�м�
$DB_TABLES[member_stat_withdrawal] = "TCMEMBER_stat_withdrawal";		// ȸ��Ż����Ȳ�м�
$DB_TABLES[board] = "TCBOARD";																						// �Խ���
$DB_TABLES[board_list] = "TCSYSTEM_board_list";														// �Խ��Ǹ��
$DB_TABLES[popup] = "TCSYSTEM_popup";																		// �˾�â ���
$DB_TABLES[visit] = "TCSYSTEM_visit";																				// �湮�����м�
$DB_TABLES[visit_total] = "TCSYSTEM_visit_total";
$DB_TABLES[post] = "TCSYSTEM_post_table";																// �ּ�
$DB_TABLES[cyber_money] = "TCSYSTEM_cyber_money";										// ������
$DB_TABLES[tax_list] = "VG_TAX_tax_list";																		// ��꼭 ���
?>
