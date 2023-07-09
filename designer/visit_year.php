<?
require "header_nosub.inc.php";
?>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' bgcolor='#ECE9D8'>
		<table border='0' cellpadding='5' cellspacing='0' width='100%'>
			<tr>
				<td height='30'><font color='#CC0000'><b>년별 방문자 현황</b></font></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height='3' bgcolor='#CABE8E'></td>
	</tr>
	<tr>
		<td width='100%' height='16' align='center'></td>
	</tr>
		<tr>
			<td width='100%'>
				

<table width=100% cellpadding=4 cellspacing=1 border=0 bgcolor=ECE9D8>
  <tr bgcolor=F8F5F0>
    <td rowspan=2 width=80>년-월</td>
    <td colspan=7>브라우저(Browser)</td>
    <td colspan=9>OS</td>
  </tr>
  <tr bgcolor=F8F5F0 align=center>
    <td>MSIE 4</td>
    <td>MSIE 5</td>
    <td>MSIE 5.5</td>
    <td>MSIE 6</td>
    <td>Nets</td>
    <td>기타</td>
	 <td><font color='#CC3333'><b>총계</b></font></td>
    <td>Win 95</td>
    <td>Win 98</td>
    <td>Win ME</td>
    <td>Win 2K</td>
    <td>NT 4.0</td>
    <td>NT 5.0</td>
    <td>Linux</td>
    <td>Unix</td>
    <td>기타</td>
  </tr>
<?
$sum_brower_msie40  = 0;
$sum_brower_msie50  = 0;
$sum_brower_msie55  = 0;
$sum_brower_msie60  = 0;
$sum_brower_netscape  = 0;
$sum_brower_etc  = 0;

$sum_os_windows_95  = 0;
$sum_os_windows_98  = 0;
$sum_os_windows_me  = 0;
$sum_os_windows_2k  = 0;
$sum_os_windows_nt40  = 0;
$sum_os_windows_nt50  = 0;
$sum_os_linux  = 0;
$sum_os_unix  = 0;
$sum_os_etc  = 0;

$sum_total = 0;

$i=0;
$k=0;
$job_year = $fr_year;
do {
    $brower_msie40  = 0;
    $brower_msie50  = 0;
    $brower_msie55  = 0;
    $brower_msie60  = 0;
    $brower_netscape  = 0;
    $brower_etc  = 0;

    $os_windows_95  = 0;
    $os_windows_98  = 0;
    $os_windows_me  = 0;
    $os_windows_2k  = 0;
    $os_windows_nt40  = 0;
    $os_windows_nt50  = 0;
    $os_linux  = 0;
    $os_unix  = 0;
    $os_etc  = 0;

    $query = " select vi_time, vi_user_agent from $DB_TABLES[visit] where substring(vi_date,1,4)='$job_year' ";
    $result = mysql_query($query) or die(mysql_error());
    while($row=mysql_fetch_array($result)) {
        $vi_user_agent = strtolower($row[vi_user_agent]);
        if(ereg("msie 4.0", $vi_user_agent))            { $brower_msie40++;   $sum_brower_msie40++; }
        elseif(ereg("msie 5.0", $vi_user_agent))        { $brower_msie50++;   $sum_brower_msie50++; }
        elseif(ereg("msie 5.5", $vi_user_agent))        { $brower_msie55++;   $sum_brower_msie55++; }
        elseif(ereg("msie 6.0", $vi_user_agent))        { $brower_msie60++;   $sum_brower_msie60++; }
        elseif(ereg("x11", $vi_user_agent))             { $brower_netscape++; $sum_brower_netscape++; }
        else                                            { $brower_etc++;      $sum_brower_etc++; }

        if(ereg("windows 95", $vi_user_agent))          { $os_windows_95++;   $sum_os_windows_95++; }
        elseif(ereg("windows 98", $vi_user_agent))      { $os_windows_98++;   $sum_os_windows_98++; }
        elseif(ereg("windows me", $vi_user_agent))      { $os_windows_me++;   $sum_os_windows_me++; }
        elseif(ereg("windows 2k", $vi_user_agent))      { $os_windows_2k++;   $sum_os_windows_2k++; }
        elseif(ereg("windows nt 4.0", $vi_user_agent))  { $os_windows_nt40++; $sum_os_windows_nt40++; }
        elseif(ereg("windows nt 5.0", $vi_user_agent))  { $os_windows_nt50++; $sum_os_windows_nt50++; }
        elseif(ereg("linux", $vi_user_agent))           { $os_linux++;        $sum_os_linux++; }
        elseif(ereg("unix", $vi_user_agent))            { $os_unix++;         $sum_os_unix++; }
        else                                            { $os_etc++;          $sum_os_etc++; }

        $vi_time[(int)substr($row[vi_time],0,2)]++;

        $sum_total++;
    }

    $class = ($i++ % 2) ? "onmouseover" : "onmouseout";
	 $brower_total = $brower_msie40 + $brower_msie50 + $brower_msie55 + $brower_msie60 + $brower_netscape + $brower_etc;
    echo "
    <tr align=center class='$class'>
        <td width=80><a href='visit_month.php?fr_month=$job_year-01&to_month=$job_year-12'>$job_year</a></td>
        <td>$brower_msie40</td>
        <td>$brower_msie50</td>
        <td>$brower_msie55</td>
        <td>$brower_msie60</td>
        <td>$brower_netscape</td>
        <td>$brower_etc</td>
		  <td><font color='#CC3333'>$brower_total</font></td>
        <td>$os_windows_95</td>
        <td>$os_windows_98</td>
        <td>$os_windows_me</td>
        <td>$os_windows_2k</td>
        <td>$os_windows_nt40</td>
        <td>$os_windows_nt50</td>
        <td>$os_linux</td>
        <td>$os_unix</td>
        <td>$os_etc</td>
    </tr>";

    $k++;
    $next_year  = mktime (0,0,0, 01 , 01, substr($job_year,0,4)+1);
    $job_year=date("Y", $next_year);
} while($job_year <= $to_year);
$sum_brower_total = $sum_brower_msie40 + $sum_brower_msie50 + $sum_brower_msie55 + $sum_brower_msie60 + $sum_brower_netscape + $sum_brower_etc;
echo "
    <tr align=center bgcolor=F8F5F0>
        <td>소 계</td>
        <td>$sum_brower_msie40</td>
        <td>$sum_brower_msie50</td>
        <td>$sum_brower_msie55</td>
        <td>$sum_brower_msie60</td>
        <td>$sum_brower_netscape</td>
        <td>$sum_brower_etc</td>
		  <td><font color='#CC3333'><b>$sum_brower_total</b></font></td>
        <td>$sum_os_windows_95</td>
        <td>$sum_os_windows_98</td>
        <td>$sum_os_windows_me</td>
        <td>$sum_os_windows_2k</td>
        <td>$sum_os_windows_nt40</td>
        <td>$sum_os_windows_nt50</td>
        <td>$sum_os_linux</td>
        <td>$sum_os_unix</td>
        <td>$sum_os_etc</td>
    </tr>";

if($sum_total)
    echo "
    <tr align=center bgcolor=F8F5F0>
        <td>비 율 (%)</td>
        <td>".number_format($sum_brower_msie40/$sum_total*100, 1)."</td>
        <td>".number_format($sum_brower_msie50/$sum_total*100, 1)."</td>
        <td>".number_format($sum_brower_msie55/$sum_total*100, 1)."</td>
        <td>".number_format($sum_brower_msie60/$sum_total*100, 1)."</td>
        <td>".number_format($sum_brower_netscape/$sum_total*100, 1)."</td>
        <td>".number_format($sum_brower_etc/$sum_total*100, 1)."</td>
		  <td>&nbsp;</td>
        <td>".number_format($sum_os_windows_95/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_windows_98/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_windows_me/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_windows_2k/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_windows_nt40/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_windows_nt50/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_linux/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_unix/$sum_total*100, 1)."</td>
        <td>".number_format($sum_os_etc/$sum_total*100, 1)."</td>
    </tr>";
?>
</table>

<?
if($sum_total) {
	echo "
        <br>
        <table width=100% cellpadding=4 cellspacing=1 border=0 bgcolor=ECE9D8>
          <tr bgcolor=F8F5F0>
            <td colspan=25>시간대별 접속 현황</td>
          </tr>
          <tr align=center height=22 bgcolor=F8F5F0>
            <td width=80>시간</td>";

            for($i=0;$i<24;$i++) {
                echo "<td>".substr("0$i", -2)."</td>";
            }

    echo "
          </tr>
          <tr height=22 align=center bgcolor=#ffffff>
            <td>접속</td>";

            for($i=0;$i<24;$i++) {
                echo "<td>".(int)$vi_time[$i]."</td>";
            }

    echo "
          </tr>
          <tr height=22 align=center bgcolor=F8F5F0>
            <td>비 율 (%)</td>";

            for($i=0;$i<24;$i++) {
					 
                echo "<td valign=bottom><table cellspacing=1 bgcolor=#CC9900 width=15 height=". floor($vi_time[$i]/$sum_total*100) . " border=0 cellpadding=0 cellspacing=0><tr><td></td></tr></table></td>";
            }
    echo "
          </tr>
        </table>";

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
	$query = "select count(vi_id) from $DB_TABLES[visit] where ({$referer_url}) and substring(vi_date,1,4) between '$fr_year' and '$to_year'";
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
					<td colspan='$exp_num'>사이트별 접속현황</td>
				</tr>
				<tr align=center bgcolor=F8F5F0>
					$tag_referer					
				</tr>
			</table>
");

    // 접속경로 상위 n건
    $max_referer_count = 100;

    echo "<br>
        <table width=100% cellpadding=4 cellspacing=1 border=0 bgcolor=ECE9D8>
          <tr bgcolor=F8F5F0>
            <td colspan=25>초기페이지 접속경로 상위 $max_referer_count 건</td>
          </tr>
          <tr bgcolor=F8F5F0>
            <td width=80>접속수</td>
            <td width=80>비율(%)</td>
            <td>접속경로</td>
          </tr>";

    $query = " select vi_referer, count(vi_referer) as vi_referer_count
             from $DB_TABLES[visit]
             where substring(vi_date,1,4) between '$fr_year' and '$to_year'
             group by vi_referer
             order by vi_referer_count desc limit $max_referer_count ";
    $result = mysql_query($query) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)) {
      $a_begin = $a_end = "";
      if($row[vi_referer]=="")
        $row[vi_referer]="직접 입력 or 북마크 or ???";
      else {
        $a_begin = "<a href='$row[vi_referer]' target=_new>";
        $a_end = "</a>";
      }

      $class = ($i++ % 2) ? "onmouseover" : "onmouseout";
      echo "
      <tr bgcolor=FFFFFF>
        <td align=center>$row[vi_referer_count]</td>
        <td align=center>".number_format($row[vi_referer_count]/$sum_total*100, 1)."</td>
        <td>$a_begin$row[vi_referer]$a_end</td>
      </tr>";
    }
    echo "</table>";

    // 접속 IP 상위 n건
    $max_remote_addr_count = 10;

    echo "<br>
        <table width=100% cellpadding=4 cellspacing=1 border=0 align=center bgcolor=ECE9D8>
          <tr bgcolor=F8F5F0>
            <td colspan=25>초기페이지 접속 IP 상위 $max_remote_addr_count 건</td>
          </tr>
          <tr bgcolor=F8F5F0>
            <td width=80>접속수</td>
            <td width=80>비율(%)</td>
            <td>IP Address</td>
          </tr>";

    $query = " select vi_remote_addr, count(vi_remote_addr) as vi_remote_addr_count
             from $DB_TABLES[visit]
             where substring(vi_date,1,4) between '$fr_year' and '$to_year'
             group by vi_remote_addr
             order by vi_remote_addr_count desc limit $max_remote_addr_count ";
    $result = mysql_query($query) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)) {
      $class = ($i++ % 2) ? "onmouseover" : "onmouseout";
      echo "
        <tr bgcolor=FFFFFF>
            <td align=center>$row[vi_remote_addr_count]</td>
            <td align=center>".number_format($row[vi_remote_addr_count]/$sum_total*100, 1)."</td>
            <td>&nbsp;$row[vi_remote_addr]</td>
        </tr>";
    }
    echo "</table>";
}
?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>