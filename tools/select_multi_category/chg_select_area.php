<?
/****************************************************
	 DB ������, 1�� �з� ���ÿ� ���� 2�� �з� ���û��� ��� ���α׷�
****************************************************/
include "../../db.inc.php";
$query = "select $_GET[fld_code] from $_GET[table_name] where {$_GET[selected_fld_name]}='{$_GET[selected_value]}'{$_GET[sub_query]}";
$result = mysql_query($query);
$total_cnt = mysql_num_rows($result);
if ($total_cnt > 0) {
	$JS_options = "
		newOption = document.createElement('OPTION');																				// ����� option ��Ҹ� �����.
		newOption.text = ':: $_GET[box_title] ::';																																// text ����
		newOption.value = '';																																			// value ����
		document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.add(newOption);						// ���� ���õ� ī�װ� ����Ʈ�� ���� ����Ʈ�� ������� option ��Ҹ� �߰��Ѵ�.
	";
	while ($value = mysql_fetch_array($result)) {
		$JS_options .= "
			newOption = document.createElement('OPTION');
			newOption.text = '{$value[$_GET[fld_name]]}';
			newOption.value = '{$value[$_GET[fld_code]]}';
			document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.add(newOption);
		";
	}
	echo("
		var optionCount = document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.length;						// �����ؾ��� select�� option �±��� ���� ���´�.
		for (var i=0; i<optionCount; i++) {																																	// ��� option �±׸� �����Ѵ�.
			document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.remove(0);
		}
		$JS_options
		document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.disabled = false;
		document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.value = '$_GET[selected_value_next]';
	");
} else {
	echo("
		document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.disabled = true;
	");
}
?>