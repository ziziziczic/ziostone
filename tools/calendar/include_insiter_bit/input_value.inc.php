<input type='hidden' name='input_method' value='1'>
<input type='hidden' name='is_new_window' value='Y'>
<?
include_once "{$root}tools/calendar/library.inc.php";

if ($article_value[etc_1] != "") {	// ����� ���� ������ �ش� ������ ����
	$CD_saved_date = getdate($article_value[etc_1]);
	$year2 = $CD_saved_date[year];
	$month2 = $CD_saved_date[mon];
	$day2 = $CD_saved_date[mday];
} else {		// ������, get ������ �Ѿ�°��� �����ϰ� �׵� ������ ���糯¥ �������� ������.
	if ($year2 == "") $year2 = $CD_today[year];
	if ($month2 == "") $month2 = $CD_today[mon];
	if ($day2 == "") $day2 = $CD_today[mday];
}

$CD_select_tag_year = "<select name='input_year'>";
for ($CD_i=$CD_start_year; $CD_i<=$CD_end_year; $CD_i++) {
	if ($CD_i == $year2) $is_selected = " selected";
	else $is_selected = "";
	$CD_select_tag_year .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
}
$CD_select_tag_year .= "</select>";

$CD_select_tag_month = "<select name='input_month'>";
for ($CD_i=1; $CD_i<=12; $CD_i++) {
	if ($CD_i == $month2) $is_selected = " selected";
	else $is_selected = "";
	$CD_select_tag_month .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
}
$CD_select_tag_month .= "</select>";

$CD_select_tag_day = "<select name='input_day'>";
for ($CD_i=1; $CD_i<=31; $CD_i++) {
	if ($CD_i == $day2) $is_selected = " selected";
	else $is_selected = "";
	$CD_select_tag_day .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
}
$CD_select_tag_day .= "</select>";

echo($CD_select_tag_year . "�� " . $CD_select_tag_month . "�� " . $CD_select_tag_day . "�� ");
?>