<?
include "header_sub.inc.php";

require "{$DIRS[designer_root]}include/class.tree/class.tree.php";
$tree = new Tree("{$DIRS[designer_root]}include/class.tree");
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0];
$line = $lib_fix->search_index($design, "���̺�", $location);

// ���� ��ø���� �ʵ��� ����,����, ���� ���̺� �� ������ �Ǿ� �ִ��� �����Ѵ�.
// CFS => Current table Form Setup, PFS => Parent table Form Setup, ChFs => Child table Form Setup
$CFS = $lib_fix->search_current_form($design, $line[0], 4);
$PFS = $lib_fix->search_parent_form($design, $line[0]-1, "���̺�", 4);
$ChFS = $lib_fix->search_child_form($design, "���̺�", $line[0]+1, $line[1], 4);
if ((is_array($CFS) && is_array($PFS)) || (is_array($CFS) && is_array($ChFS)) || (is_array($PFS) && is_array($ChFS))) {
	die("�� �Ӽ��� ��ø�Ǿ� �ֽ��ϴ�. �������̺� : $CFS , �������̺� : $PFS , �������̺� : $ChFS , �� â�� �ݰ� �ǵ����⸦ �õ��� ���ʽÿ�.");
}	// ������ ���̺�(����, ����, ����)���� �ΰ� �̻��� ���� ���ÿ� ������ ����
?>
<script language='javascript1.2'>
<!--
function verify(link, mode) {
	switch (mode) {
		case 'object' :
			msg = '�����Ͻ� �׸��� �����մϴ�.';
		break;
	}
	if (confirm(msg)) {
		document.location.href = link;
	}
}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<tr valign='top'> 
		<td> 
			<table width='100%' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr>
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'><b>���̺� �����̳�</b></font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='100%' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>
					<td valign='top'>
<?
$tree_root  = $tree->open_tree ("���̺�����", "table_designer_view.php?design_file=$design_file&index=$index");

//$table_edit = $tree->add_folder ($tree_root, "���̾ƿ�����", "");
$tree->add_document($tree_root, "ǥ����(TABLE)", "page_designer_table_form.php", "design_file=$design_file&index=$index&current_line=$current_line","2","","");
$tree->add_document($tree_root, "������(TR)", "table_tr_form.php", "design_file=$design_file&index=$index&parent=table&depth1=table&depth2=modify","2","","");
$tree->add_document($tree_root, "ĭ����(TD)", "table_td_form.php", "design_file=$design_file&index=$index&parent=table&depth1=table&depth2=modify","2","","");

// ���̺� �ƹ� ������ �Ǿ� ���� ������ ���� ������ ��� ����� �����ش�.
if (($CFS == "CURRENT_NOT_FOUND") && ($PFS == "PARENT_NOT_FOUND") && ($ChFS == "CHILD_NOT_FOUND")) {
	$form_tag = $tree->add_folder ($tree_root, "�Խ���/�α���/ȸ������", "");
	$tree->add_document($form_tag, "�Խ��ǵ�����", "table_board_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_BOARD&form_line=$line[0]","2","","");
	$tree->add_document($form_tag, "�α�����������", "table_login_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_LOGIN&form_line=$line[0]","2","","");
	$tree->add_document($form_tag, "ȸ�����Ե�����", "table_member_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_MEMBER&form_line=$line[0]","2","","");
} else {	// ���̺� � ������ �Ǿ� �ִ� ���
	if (!is_array($ChFS)) {	// ���� �Ǵ� ���� ���̺� ����� �����Ǿ� ���� ��� ��� ���� ����, �������̺��� �Ұ�.
		if (is_array($CFS)) {
			$form_value = $CFS;
			$form_line = $line[0];
		} else {
			$form_value = $PFS;
			while (list($key, $value) = each($form_value)) $form_line = $value;	// �� ���������� ������ ���� ���Ѵ�.
		}
		if ($form_value[4] == "TC_BOARD") {	// ���� ���̺� �Խ��� ������ �Ǿ� �ִ� ���
			$exp = explode(':', $form_value[5]);
			$board = $tree->add_folder ($tree_root, "�Խ��ǵ�������", '');
			$tree->add_document($board, "�׸����", "table_board_article_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&board_name={$exp[0]}","2","","");
			$tree->add_document($board, "�Է»���", "table_board_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&form_type={$exp[1]}","2","","");
			$tree->add_document($board, "��ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");
			$tree->add_document($board, "��������", "table_board_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_BOARD&form_line=$form_line","2","","");
		} else if ($form_value[4] == "TC_MEMBER") {	// ���� ���̺� ȸ���� ������ �Ǿ� �ִ� ���
			$member = $tree->add_folder ($tree_root, "ȸ����������", "");
			$tree->add_document($member, "ȸ����������", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($member, "�Է»���", "table_member_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($member, "��ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=member","2","","");
			$tree->add_document($member, "��������", "table_member_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_MEMBER&form_line=$form_line","2","","");
		} else if ($form_value[4] == "TC_LOGIN") {	// ���� ���̺� �α����� ������ �Ǿ� �ִ� ���
			$login = $tree->add_folder ($tree_root, "�α��ε�������", "");
			$tree->add_document($login, "ȸ����������", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($login, "�Է»���", "table_login_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($login, "��ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=login","2","","");
			$tree->add_document($login, "��������", "table_login_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_LOGIN&form_line=$form_line","2","","");
		}
	}
}
$tree->add_document($tree_root, "��ư�ֱ�", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "����(TAG)�ֱ�", "{$root}table_tag_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "�׸��ֱ�", "table_image_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "�÷��óֱ�", "table_flash_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "�ܺ�����&���&������", "table_import_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
if($cpn != '0') $tree->add_document($tree_root, "<a href=javascript:verify('table_designer_manager.php?design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=delete_object','object')>�׸����</a>", "", "","4","","");
$template = $tree->add_folder ($tree_root, "���ø�����", '');
$tree->add_document($template, "�Խ����׸����", "table_board_article_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&board_name={$exp[0]}","2","","");
$tree->add_document($template, "�Խ����Է»���", "table_board_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&form_type={$exp[1]}","2","","");
$tree->add_document($template, "�Խ��ǹ�ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");
$tree->add_document($template, "�ݺ�����", "table_board_repeat_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");

$tree->add_document($template, "ȸ����������", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "ȸ���Է»���", "table_member_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "ȸ����ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=member","2","","");

$tree->add_document($template, "�α����Է»���", "table_login_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "�α��ι�ư����", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=login","2","","");

$tree->close_tree();
?>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr>
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?
include "footer_sub.inc.php";
?>