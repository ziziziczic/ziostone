<?
// ����
include "header.inc.php";
$colspan = '10';
$search_item_array = array("A"=>"���հ˻�", "name"=>"Ÿ��Ʋ", "file_name"=>"���ϸ�", "tag_header;tag_body;tag_body_in;tag_body_out;tag_contents_out"=>"�±�", "memo"=>"�޸�");
$search_item_array_date = array("create_date"=>"������", "last_modify_date"=>"������");
$option_boxs = array();
if (trim($site_info[page_types]) != '') $T_user_page_type = "\n{$site_info[page_types]}";	// ������ �з�
$design_file_menu_array = array(''=>":: �������з� ::") + $GLOBALS[lib_common]->parse_property($T_page_type . $T_user_page_type, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($design_file_menu_array, "SCH_type", $_GET[SCH_type], 'N', "class='designer_select'");
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"date");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "create_date";			// �Ⱓ�˻� �⺻ �ʵ�
if ($_SESSION[dfg] != '') $T_sub_query[] = "design_file_group='$_SESSION[dfg]'";
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("fid", "thread", "name");
$sort_sequence = array("desc", "asc", "asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[design];
$query = "select * from {$DB_TABLES[design_files]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_page_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>��</b> - {$ppb_link[1][0]}P</font></td>
					<td>$design_group</td>
					<td align=right>
						$P_search_box
					</td>
				</tr>
			</table>
";
$P_contents = "
<script language='javascript1.2'>
<!--
	function view_page_type(type) {
		document.location.href = '{$PHP_SELF}?view_page_type=' + type;
	}
	function openAddCateWin(file_name) {
		target_link = 'page_input_form.php?parent_design_file=' + file_name + '&view_page_type=$_GET[SCH_type]&sort=$sort&sequence=$sequence';
		cateSetupWindow = window.open(target_link, 'cateSetupWindow', 'scrollbars=yes, resizables=yes,width=700,height=500,resizable=no,mebar=no,left=0,top=0').focus();
	}

	function openModifyCateWin(file_name) {
		target_link = 'page_input_form.php?view_page_type=$_GET[page_type]&design_file=' + file_name;
		cateSetupWindow = window.open(target_link, 'cateSetupWindow', 'scrollbars=yes, resizables=yes,width=700,height=500,resizable=no,mebar=no,left=0,top=0').focus();
	}
	function verify_delete(design_file) {
		if (confirm('�ѹ� ���� �������� ������ �� �����ϴ�. ������ �����Ͻðڽ��ϱ�?')) {
			form = document.frm_delete;
			form.mode.value = 'delete';
			form.design_file.value = design_file;
			form.submit();
		}
	}

	function verify() {
		if (confirm('��ü �ʱ�ȭ�� ����Ͻø� ��� ������ �������� �Խ����� �����Ǹ�\\n\\n������������ ���� �� �� �����ϴ�.\\n\\n������� �Ͻðڽ��ϱ�?')) {
			form = document.frm_delete;
			form.mode.value = 'default';
			form.submit();
		}
		return;
	}
//-->
</script>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' align='center'>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align='center'>
					<td class=list_form_title width='40' height='30'>��ȣ</td>
					<td class=list_form_title align='center'>�̸�(����������)</td>
					<td class=list_form_title width=90>���ϸ�</td>
					<td class=list_form_title width=80>��Ų</td>
					<td class=list_form_title width=80>�޴�</td>
					<td class=list_form_title width=40>����</td>
					<td class=list_form_title width=40>HITS</td>
					<td class=list_form_title width=63>������</td>
					<td class=list_form_title width=40>����</td>
					<td class=list_form_title width=125>����</td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
				$list_info
				$ppb_link[0]
			</table>
		</td>
	</tr>
	<form name=frm_delete method=post action='page_manager.php'>
		<input type='hidden' name='mode' value=''>
		<input type='hidden' name='design_file' value=''>
		<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	</form>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));
echo($P_contents);
include "footer.inc.php";
?>