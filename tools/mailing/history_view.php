<?
$sh_info = $lh_common->get_data($vg_tax_db_tables[history], "sh_serial", $_GET[sh_serial]);
echo($sh_info[sh_contents]);
echo("<br><br><b>&nbsp;+ 송신 메일기록 +</b><br>&nbsp;<textarea rows='20' cols='60' style='width:98%'>$sh_info[sh_receivers]</textarea><br><br><a href='javascript:history.back()'>[돌아가기]</a>");
?>