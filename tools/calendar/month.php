<?
$is_include = 'Y';
//$root = ...  인클루드되지 않고 단독으로 사용될 경우 루트경로 설정

include "library.inc.php";

if ($is_include != 'Y') {
	$CD_header = "<html><head>$html_header</head></html><body>";
	$CD_footer = "</body></html>";
} else {
	$CD_header = "<script src='{$CD_root}javascript.js'></script>";
}

// 보여줄 월을 설정함(설정되지 않았으면 오늘에 해당되는 달을 설정)
if (!$CD_year) $CD_year = $CD_today[year];
if (!$CD_month) $CD_month = $CD_today[mon];
if (!$CD_day) $CD_day = $CD_today[mday];

$CD_print_subject = "Y";									// 일일 일정 표시여부
$CD_tag = show_calendar($CD_today, $CD_year, $CD_month, $CD_day, "0", $CD_print_subject);

$CD_select_tag_year = "<select name='CD_year' onchange=\"change_year(this, '$PHP_SELF?$_SERVER[QUERY_STRING]')\">";
for ($CD_i=$CD_start_year; $CD_i<=$CD_end_year; $CD_i++) {
	if ($CD_i == $CD_year) $is_selected = " selected";
	else $is_selected = "";
	$CD_select_tag_year .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
}
$CD_select_tag_year .= "</select>";

$_SERVER[QUERY_STRING] = ereg_replace("&CD_year=[0-9]*", "", $_SERVER[QUERY_STRING]);
$_SERVER[QUERY_STRING] = ereg_replace("&CD_month=[0-9]*", "", $_SERVER[QUERY_STRING]);
$CD_select_tag_month = "<select name='CD_month' onchange=\"change_month(this, '$PHP_SELF?$_SERVER[QUERY_STRING]')\">";
for ($CD_i=1; $CD_i<=12; $CD_i++) {
	if ($CD_i == $CD_month) $is_selected = " selected";
	else $is_selected = "";
	$CD_select_tag_month .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
}
$CD_select_tag_month .= "</select>";

echo("
$CD_header
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td><img src='{$CD_root}images/month_{$CD_month}.gif' border=0></td>
					<td align=right>
						<table cellpadding=3 cellspacing=0 border=0>
							<tr>
								<td><img src='{$CD_root}images/icon_dot_semina.gif' border=0 align='absmiddle'></td>
								<td>선택</td>
								<td>$CD_select_tag_year 년</td>
								<td>$CD_select_tag_month 월</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>$CD_tag</td>
	</tr>
</table>
$CD_footer
");
?>