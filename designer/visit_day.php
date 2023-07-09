<?
require "header_nosub.inc.php";
?>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' bgcolor='#ECE9D8'>
		<table border='0' cellpadding='5' cellspacing='0' width='100%'>
			<tr>
				<td height='30'><font color='#CC0000'><b>일일 방문자 상세 현황</b></font></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='3' bgcolor='#CABE8E'></td>
	</tr>
	<tr>
		<td width='100%'>
<?
$exp = explode($GLOBALS[DV][ct1], $site_info[referer_sites]);
$exp_num = sizeof($exp);
for ($i=0; $i<$exp_num; $i++) {
	$exp_1 = explode($GLOBALS[DV][ct2], $exp[$i]);
	if (trim($exp[$i]) == '') continue;
	$referer_url = '';
	$exp_2 = explode($GLOBALS[DV][ct3], $exp_1[1]);
	for ($j=0; $j<sizeof($exp_2); $j++) {
		$referer_url .= "vi_referer like '%" . trim($exp_2[$j]) . "%' or ";
	}
	$referer_url = substr($referer_url, 0, -4);
	$query = "select count(vi_id) from $DB_TABLES[visit] where ({$referer_url}) and vi_date='$dt'";
	$result = $GLOBALS[lib_common]->querying($query);
	$search_engine_count = mysql_result($result, 0, 0);
	$tag_referer .= "
					<td>
						<table cellpadding=3 cellspacing=1 border=0 bgcolor=f3f3f3 width=100%>
							<tr>
								<td align=center bgcolor=#ECE9D8 >{$exp_1[0]}</td>
							</tr>
							<tr>
								<td align=center bgcolor=ffffff >$search_engine_count</td>
							</tr>
						</table>
					</td>			
	";
}

echo ("
			<br>
			<table width=100% cellpadding=4 cellspacing=1 border=0 bgcolor=ECE9D8>
				<tr bgcolor=F8F5F0>
					<td colspan='$exp_num'>검색엔진별 접속현황</td>
				</tr>
				<tr align=center bgcolor=F8F5F0>
					$tag_referer					
				</tr>
			</table>
");
?>			
		</td>
	</tr>
	<tr>
		<td width='100%' height='16' align='center'></td>
	</tr>
		<tr>
			<td width='100%'>
						
<?
$ppa = 20;
$ppb = 10;
$query = "select * from $DB_TABLES[visit] where vi_date='$dt' ";
$query_ppb = str_replace("select *", "select count(vi_id)", $query);
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $ppa, $ppb, $_GET[page], '', '', "{$DIRS[designer_root]}images/");
$list_info = $lib_insiter->get_visit_list($query, $ppb_link[1][0], $ppa, $_GET[page], '', 9);
$total_list = $ppb_link[1][0];
if (!$dt) $dt = date("Y-m-d");
?>
			<table width=100%>
				<tr>
					<td width=50%> 일별 시간대 방문자 현황 </td>
					<td width=50% align=right>건수 : <? echo $total_list ?></td>
				</tr>
			</table>
			<table width=100% cellpadding=4 cellspacing=1 border=0 bgcolor=ECE9D8>
				<tr bgcolor=F8F5F0>
					<td width=60>ID</td>
					<td width=50>시간</td>
					<td width=100>IP 주소</td>
					<td>접속 경로</td>
					<td width=100>Browser</td>
					<td width=100>OS</td>
				</tr>
				<? echo($list_info); ?>
			</table>
			<table width=100%>
				<tr>
					<td width=50%>&nbsp;</td>
					<td width=50% align=right>
<? echo($ppb_link[0]) ?>
					</td>
				</tr>
			</table>
					</td>
				</tr>
			</table>

<? include "footer.inc.php"; ?>