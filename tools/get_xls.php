<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
if ($user_info[user_level] > $GLOBALS[VI][admin_level_admin]) $GLOBALS[lib_common]->die_msg("실행 할 수 없는 기능 입니다.");

header("Content-type: application/vnd.ms-excel; charset=euc-kr"); 
header("Content-Disposition: attachment; filename=$filename"); 
header("Expires: 0"); 
header("Content-Description: PHP4 Generated Data"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Pragma: public");

$query = stripslashes($_GET[query]);																														// GET방식으로 넘어온 query값을 받는다. 
$result = $GLOBALS[lib_common]->querying($query);

$field_name = array();
$title_name_set = '';
while (list($key, $value) = each($_GET)) {																											// GET방식으로 넘어온 값중 키가 DBF_로 시작되는 값들을 각 항목의 타이틀로 지정
	if (substr($key, 0, 4) == "DBF_" && $value != '') {
		$title_name_set .= "<td bgcolor=#C7C7C7><b>$value</b></td>";
		$field_name[] = substr($key, 4);																														// 필드이름 저장
	}
}

// 모든 필드값을 불러오는 설정인경우
if ($_GET[all_field] == 'Y') {
	while ($field = mysql_fetch_field($result)) {
		$title_name_set .= "<td bgcolor=#C7C7C7><b>$field->name</b></td>";
		$field_name[] = $field->name;																															// 필드이름 저장
	}
}

while ($record_value = mysql_fetch_array($result)) {
	$field_set = '';
	for ($i=0; $i<sizeof($field_name); $i++) {																											// 필드이름의 갯수만큼 반복
		$field_value = $record_value[$field_name[$i]];
		if (ereg("^[0-9]{10}$", $field_value)) $field_value = date("Y-m-d H:i:s", $field_value);		// 필드값이 유닉스타임스템프인경우 '년월일시분초'로 변환
		$field_set .= "<td>$field_value</td>";
	}
	$record_set .= "<tr>$field_set</tr>";
}

echo("
<table width='100%' cellpadding='0' cellspacing='0' border='1'>
	<tr height='25' align='center'>
		$title_name_set
	</tr>
	$record_set
</table>
");
?>