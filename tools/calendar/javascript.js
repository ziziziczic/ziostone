function change_month(selObj, url) {
	sel_CD_year = document.all.CD_year;
	select_year = sel_CD_year.options[sel_CD_year.selectedIndex].value;
	select_month = selObj.options[selObj.selectedIndex].value;
	document.location.href = url + "&CD_year=" + select_year + "&CD_month=" + select_month;
}

function change_year(selObj, url) {
	sel_CD_month = document.all.CD_month;
	select_month = sel_CD_month.options[sel_CD_month.selectedIndex].value;
	select_year = selObj.options[selObj.selectedIndex].value;
	document.location.href = url + "&CD_year=" + select_year + "&CD_month=" + select_month;
}
