<?
/****************************************************
	 DB 연동형, 1차 분류 선택에 따른 2차 분류 선택상자 출력 프로그램
****************************************************/
include "../../db.inc.php";
$query = "select $_GET[fld_code] from $_GET[table_name] where {$_GET[selected_fld_name]}='{$_GET[selected_value]}'{$_GET[sub_query]}";
$result = mysql_query($query);
$total_cnt = mysql_num_rows($result);
if ($total_cnt > 0) {
	$JS_options = "
		newOption = document.createElement('OPTION');																				// 출력할 option 요소를 만든다.
		newOption.text = ':: $_GET[box_title] ::';																																// text 구성
		newOption.value = '';																																			// value 구성
		document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.add(newOption);						// 현재 선택된 카테고리 리스트의 다음 리스트에 만들어진 option 요소를 추가한다.
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
		var optionCount = document.{$_GET[form_name]}.{$_GET[reset_obj_name]}.length;						// 제거해야할 select의 option 태그의 수를 얻어온다.
		for (var i=0; i<optionCount; i++) {																																	// 모든 option 태그를 제거한다.
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