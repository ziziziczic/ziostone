<?
if ($_GET[category_1] == 'A' && $_GET[category_2] == '') $P_title_img = "title_k_01.gif";
else if ($_GET[category_1] == 'B' && $_GET[category_2] == '') $P_title_img = "title_k_02.gif";
else if ($_GET[category_1] == 'C' && $_GET[category_2] == '') $P_title_img = "title_k_03.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'A') $P_title_img = "title_k_01_01.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'B') $P_title_img = "title_k_01_02.gif";
else if ($_GET[category_1] == 'A' && $_GET[category_2] == 'C') $P_title_img = "title_k_01_03.gif";
else if ($_GET[category_1] == 'B' && $_GET[category_2] == 'C') $P_title_img = "title_k_02_01.gif";
else if ($_GET[category_1] == 'B' && $_GET[category_2] == 'A') $P_title_img = "title_k_02_02.gif";
else if ($_GET[category_1] == 'B' && $_GET[category_2] == 'D') $P_title_img = "title_k_02_03.gif";
else if ($_GET[category_1] == 'C' && $_GET[category_2] == 'E') $P_title_img = "title_k_03_01.gif";
else if ($_GET[category_1] == 'C' && $_GET[category_2] == 'F') $P_title_img = "title_k_03_02.gif";
else if ($_GET[category_1] == 'C' && $_GET[category_2] == 'G') $P_title_img = "title_k_03_03.gif";
else $P_title_img = "title_k.gif";
echo("<img src='images/title/{$P_title_img}' border=0>");
?>