<?
if ($_GET[category_1] == 'A' && $_GET[category_2] == '') $P_title_img = "title_g.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'A') $P_title_img = "title_g_01.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'B') $P_title_img = "title_g_02.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'C') $P_title_img = "title_g_03.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'D') $P_title_img = "title_g_04.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'E') $P_title_img = "title_g_05.gif";
else $P_title_img = "title_g.gif";
echo("<img src='images/title/{$P_title_img}' border=0>");
?>