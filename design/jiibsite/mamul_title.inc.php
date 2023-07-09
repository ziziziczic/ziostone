<?
if ($category1 == "1톤정보") $category_title = "<img src='design/jiibsite/images/title_1_ton.gif' border=0>";
else if ($category1 == "2.5톤정보") $category_title= "<img src='design/jiibsite/images/title_2_ton.gif' border=0>";
else if ($category1 == "5톤정보") $category_title= "<img src='design/jiibsite/images/title_5_ton.gif' border=0>";
else if ($category1 == "8톤이상정보") $category_title= "<img src='design/jiibsite/images/title_8_ton.gif' border=0>";
else if ($category1 == "11톤정보") $category_title= "<img src='design/jiibsite/images/title_11_ton.gif' border=0>";
else if ($category1 == "승합및기타정보") $category_title= "<img src='design/jiibsite/images/title_etc_ton.gif' border=0>";
else if ($category1 == "택배정보") $category_title= "<img src='design/jiibsite/images/title_takbae.gif' border=0>";
if ($category2 == "지방권") $category_title= "<img src='design/jiibsite/images/title_jibang.gif' border=0>";
if ($category3 == "추천") $category_title= "<img src='design/jiibsite/images/title_recomm.gif' border=0>";
if ($category1 == "" && $category2 == "" && $category3 == "") $category_title= "<img src='design/jiibsite/images/title_all_ton.gif' border=0>";
echo($category_title);
?>	