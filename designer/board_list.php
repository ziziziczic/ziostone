<?
require "header.inc.php";

$colspan = '9';
$T_sub_query = array();
if ($_SESSION[dfg] != '') $T_sub_query[] = "design_file_group='$_SESSION[dfg]'";
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("alias");
$sort_sequence = array("asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[board];
$query = "select * from {$DB_TABLES[board_list]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_board_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}
$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>�Խ��Ǹ��</b> - {$ppb_link[1][0]} Boards</font></td>
					<td>$design_group</td>
				</tr>
			</table>
";
$P_contents = "
<script language='javascript1.2'>
<!--
function verify_delete(board_name) {
	if (confirm('�Խ��� ���α׷��� ��� �Խù��� �����˴ϴ�.\\n������������ ������ �� �����ϴ�.\\n\\n�Խ����� �����Ͻ÷��� Ȯ�� ��ư�� �����ʽÿ�')) {
		document.location.href = 'board_manager.php?board_name=' + board_name + '&mode=delete';
	}
}
//-->
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' height='16' align='center'>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align=center>
					<td class=list_form_title width=40 height=30>��ȣ</td>
					<td class=list_form_title>�̸�</td>
					<td class=list_form_title width=70>DB Table</td>
					<td class=list_form_title width=100>������ID</td>
					<td class=list_form_title width=90>����</td>
					<td class=list_form_title width=70>�Խù�</td>
					<td class=list_form_title width=80>������</td>
					<td class=list_form_title width=100>������</td>
					<td class=list_form_title width=65>����</td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
				$list_info
				$ppb_link[0]
			</table>
		</td>
	</tr>	
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));


$help_msg = "
������ '����' : �ش�Խ��� '���������'�� ������ ����ȭ������ �̵�
������ '����' : ���� ȭ�麸�� (����ȭ�� ����� '������ ������ �����ϴ�' ��� ������ ��� �Խ��� ��Ų�� �ٽ� ������ �ּ���.
������ '���ø�' : �ش� �Խ��� �������� �ٸ� Ȩ���������� �״�� ��� �� �� �ֵ��� �մϴ�. {$DIRS[template]} ���� �� ���丮���� ���� �˴ϴ�.
���� '�Ӽ�' : �Խ����� Ÿ��Ʋ, �� ���������Ӽ� �ϰ� ����, ���͸��ܾ�, �з�(category), �����ܵ��� ���� �մϴ�.
���� '����' : �Խ����� DB ���̺� �� ����, �Խù����� ��� ���� �մϴ�.
<font color=red>�� �Խ����� �����Ͻø� Ȩ������ ��� ��Ȱ���� ���� �� �ֽ��ϴ�. Ȯ������ ������� ���� �������� ������.</font>
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_contents</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td></td>
	</tr>$P_table_form_help
</table>
");
include "footer.inc.php";
?>