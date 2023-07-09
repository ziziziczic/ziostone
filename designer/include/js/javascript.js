function MM_preloadImages() { //v3.0
  var d=document; if (d.images){ if (!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if (!d) d=document; if ((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if (!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if (!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if (!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_jumpMenu_window(targ,selObj,restore){ //v3.0
	if (selObj.value == '') return;
	window.open(selObj.options[selObj.selectedIndex].value, 'window_quick', 'top=0,left=0,width=900,height=700,resizable=yes,scrollbars=yes,menubar=yes');
	if (restore) selObj.selectedIndex=0;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
	if (selObj.value == '') return;
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_showHideBoards() { //v6.0
  var i,p,v,obj,args=MM_showHideBoards.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='block')?'block':(v=='none')?'none':v; }
    obj.display=v; }
}

function open_zip_window(ref, w_width, w_height) {
	var window_left = 50;
	var window_top = 50;
	if (w_width == '') w_width = 550;
	if (w_height == '') w_height = 550;
	window.open(ref,'zip_window','width=' + w_width + ',height=' + w_height + ',status=no,resizable=yes,scrollbars=yes,top=' + window_top + ',left=' + window_left + '').focus();
}

function open_window_mouse(ref, w_width, w_height, x_control, y_control) {
	var x = (event.pageX) ? event.pageX : document.body.scrollLeft+event.clientX;
	var y = (event.pageY) ? event.pageY : document.body.scrollTop+event.clientY;
	if (typeof(x_control) != "undefined") x = x + x_control;
	if (typeof(y_control) != "undefined") y = y + y_control;
	window.open(ref,'OWM','width=' + w_width + ',height=' + w_height + ',status=no,resizable=yes,scrollbars=yes,top=' + y + ',left=' + x + '').focus();
}

function open_window(ref, left, top, width, height) {
	window.open(ref,'OWM','width=' + width + ',height=' + height + ',status=no,resizable=yes,scrollbars=yes,top=' + top + ',left=' + left + '').focus();
}

//name : 객체이름, len: 최대길이, gb: 입력여부체크
function chkTxarea(name, len, gb) {
	var form = document.forms[0];
	var obj = eval("form."+ name);
	var j = 0;
	var k = 0;
	var tempStr;
	var tempStr2;
	obj.value = ltrim(obj.value);
	for(var i = 0; i < obj.value.length; i++  )	{
		tempStr = obj.value.charCodeAt(i);
		tempStr2 = tempStr.toString();
		if (tempStr2.length >= 5) j++;		//한글
		else k++;												//영문
	}
	var ln = k+(j*2);
	if (gb == "D" && ln == 0) {
		alert("내용을 입력하세요.");
		obj.focus();
		obj.select();
		return false;
	}
	if (ln > len) {
		alert(len+"Byte 이내로 입력하세요. (현재 "+ ln +" Byte)");
		obj.focus();
		obj.select();
		return false;
	} else {
		return true;
	}
}

function coloring_box(obj, color) {
	if (color == '') color = "#EDFBFF;";
	obj.style.background = color;
}

function focus_msg(obj, msg, color) {
	if (msg != '') alert(msg);
	if (color != '') coloring_box(obj, color);
	obj.focus();
}

function ck_number(obj) {
	x = no_comma(obj.value);
	if (isNaN(x)) {
		alert("숫자만 입력 하세요.");
		obj.value = obj.defaultValue;
		obj.focus();
	} else {
		obj.value = number_format(x);
	}
}

// , 를 없앤다.
function no_comma(data) {
	var tmp = '';
	var comma = ',';
	var i;
	for (i=0; i<data.length; i++) {
		if (data.charAt(i) != comma) tmp += data.charAt(i);
	}
	return tmp;
}

function number_format(data) {
	data = new String(data);
	var tmp = '';
	var number = '';
	var cutlen = 3;
	var comma = ',';
	var i;
	len = data.length;
	mod = (len % cutlen);
	k = cutlen - mod;
	for (i=0; i<data.length; i++) {
		number = number + data.charAt(i);
		if (i < data.length - 1) {
			k++;
			if ((k % cutlen) == 0) {
				number = number + comma;
				k = 0;
			}
		}
	}
	return number;
}

function check_number(value, min, max) {
	reg_express = new RegExp('^[0-9]{' + min + ',' + max + '}$');
	if (!reg_express.test(value)) return false;
}

function check_digit(checkval) {
	val = new String(checkval);
	len = val.length;
	for (idx=0; idx<len; idx++) {
		if (val.charAt(idx) != '0' && val.charAt(idx) != '1' && val.charAt(idx) != '2' && val.charAt(idx) != '3' && val.charAt(idx) != '4' && val.charAt(idx) != '5' && val.charAt(idx) != '6' && val.charAt(idx) != '7' && val.charAt(idx) != '8' && val.charAt(idx) != '9' )  return false;
	}
	return true;
}

function social_no_chk(socialno) {
	if ( socialno.length != 13 ) return false;
	lastid	= parseFloat(socialno.substring(12,13));
	value0 	= parseFloat(socialno.substring(0,1))	* 2;
	value1 	= parseFloat(socialno.substring(1,2))	* 3;
	value2 	= parseFloat(socialno.substring(2,3))	* 4;
	value3 	= parseFloat(socialno.substring(3,4))	* 5;
	value4 	= parseFloat(socialno.substring(4,5))	* 6;
	value5 	= parseFloat(socialno.substring(5,6))	* 7;
	value6 	= parseFloat(socialno.substring(6,7))	* 8;
	value7 	= parseFloat(socialno.substring(7,8))	* 9;
	value8 	= parseFloat(socialno.substring(8,9))	* 2;
	value9 	= parseFloat(socialno.substring(9,10))  * 3;
	value10	= parseFloat(socialno.substring(10,11)) * 4;
	value11	= parseFloat(socialno.substring(11,12)) * 5;
	value12 = 0;
	value12 = value0+value1+value2+value3+value4+value5+value6+value7+value8+value9+value10+value11+value12;
	li_mod = value12 % 11;
	li_minus = 11 - li_mod;
	li_last = li_minus % 10;
	if (li_last != lastid) return false;
 	return true;
}

function multi_select(form, new_name, name, divider) {
	multi_value = divider;
	T_name = eval("form." + name);
	T_new_name = eval("form." + new_name);
	select_flag = 0;						
	for (var i=0; i<T_new_name.length; i++) {
		if (T_new_name.options[i].selected && T_new_name.options[i].value != '') {
			multi_value += T_new_name.options[i].value + divider;
			select_flag = 1;
		}
	}						
	if (select_flag == 1) T_name.value = multi_value;
	else T_name.value = '';
}

function multi_check(form, new_name, name, divider) {
	multi_value = divider;
	frm_els = form.elements;
	cnt = frm_els.length ;
	nm_cnt = new_name.length;
	select_flag = 0;
	for (i=0; i<cnt; ++i) {
		if (frm_els[i].type == 'checkbox' && frm_els[i].name.substring(0, nm_cnt) == new_name) {
			if (frm_els[i].checked && frm_els[i].value != '') multi_value += frm_els[i].value + divider;
			select_flag = 1;
		}
	}
	T_name = eval("form." + name);
	if (select_flag == 1) T_name.value = multi_value;
	else T_name.value = '';
}

function submit_radio_check(form, name, input_type) {
	frm_els = form.elements;
	cnt = frm_els.length ;
	select_flag = 0;
	for (i=0; i<cnt; ++i) {
		if (frm_els[i].type == input_type && frm_els[i].name == name) {
			if (frm_els[i].checked && frm_els[i].value != '') select_flag = 1;
		}
	}
	return select_flag;
}

function get_radio_value(obj) {
	cnt = obj.length;
	if (cnt > 1) {
		for (i=0; i<cnt; ++i) {
			if (obj[i].checked) return obj[i].value;
		}
	} else {
		if (obj.checked) return obj.value;
	}
}

function callColorPicker(tmpx, tmpy, d, e, str_btn, str_input) {
	var x = (e.screenX) ? e.screenX : document.body.scrollLeft+event.clientX;
	var y = (e.screenY) ? e.screenY : document.body.scrollTop+event.clientY;
	x = x + tmpx;
	y = y + tmpy;
	showColorPicker(x, y, d, str_btn, str_input);
	return;
}

function showColorPicker(x, y, d, str_btn, str_input) {
	var Selcol = showModalDialog('/designer/include/js/palbas.nwz','','font-family:Verdana; font-size:12; dialogWidth:202px; dialogHeight:190px; dialogLeft:' + x + 'px; dialogTop:' + y + 'px; status:no; help:no; scroll:no'); 
	if (Selcol != '') {
		var valid_color = /[0-9a-fA-F]{6}/;
		if (! valid_color.test (Selcol)) return;
		if (d == 1) {
			//c1 = Selcol;
			btn = eval(str_btn);
			input_box = eval(str_input);
			btn.style.backgroundColor = Selcol;
			input_box.style.backgroundColor = Selcol;
			input_box.value = Selcol; 
		}
	}
	return;
}

// 지정한 id 값이 설정된 엘리먼트를 보이게 또는 보이지 않게 하는 함수
// 활용 : enable_child_id('FIRSTTABLE', document.getElementsByTagName('table'), '')
function enable_child_id(parent_id, layer_child, excepts, reverse) {
	if (typeof(excepts) == "undefined") excepts = '';											// 제외목록이 없으면 널.
	if (typeof(parent_id) != "undefined") enables = parent_id.split('_');	// 선택된 입력상자의 id 값으로 보여줄 레이어 들을 배열로 저장
	else enables = '';
	for (i=0; i<layer_child.length; i++) {																		// 넘어온 레이어 개수만큼 반복
		if (layer_child[i].id == '') continue;																		// 아이디가 없으면 건너뜀.
		T_flag_excepts = 'N';
		for (k=0; k<excepts.length; k++) {																	// 제외목록 처리
			if (layer_child[i].id == excepts[k]) {
				T_flag_excepts = 'Y';
				break;
			}
		}
		if (T_flag_excepts == 'Y') continue;
		T_flag = 'N';
		for(j=0; j<enables.length; j++) {																		// 보여줄 id 값들만큼 반복
			if (enables[j] == layer_child[i].id) {																// 레이어 id 와 동일 하면 출력 아니면 출력안함.
				T_flag = 'Y';
				break;
			}
		}
		if (reverse != 'Y') {
			if (T_flag == 'Y') layer_child[i].style.display = 'block';
			else layer_child[i].style.display = 'none';
		} else{
			if (T_flag == 'Y') layer_child[i].style.display = 'none';
			else layer_child[i].style.display = 'block';
		}
	}
}

function disable_child_radio(parent_id, obj_child) {
	enables = parent_id.split('_');
	for (i=0; i<obj_child.length; i++) {		// 하위 라디오 개수만큼 반복
		T_flag = 'N';
		for(j=0; j<enables.length; j++) {	// 선택(상위)된 입력상자의 아이디를 _ 로 분리(아이디 값에 활성화 시킬 하위 라디오의 값이 _ 구분자로 설정되어 있어야함)
			if (enables[j] == obj_child[i].value) {
				T_flag = 'Y';
				break;
			}
		}
		if (T_flag == 'Y') obj_child[i].disabled = false;
		else  obj_child[i].disabled = true;
	}
}

function deletePrevCate(form, obj) {	// 상위 카테고리가 변경될때 하위 카테고리 리스트를 삭제하는 함수
	var optionCount = eval('document.createInsiteForm.categoryList_' + depth + '.length');	// 제거해야할 select의 option 태그의 수를 얻어온다.
	for (var i=0; i<optionCount; i++) {
		eval('document.createInsiteForm.categoryList_' + depth + '.remove(0)');	// 모든 option 태그를 제거한다.
	}
}

function select_category_1(form, obj_name, obj_parent, form_name, category_2_title) {		// 상위 카테고리 리스트의 항목을 선택할때 하위 카테고리 항목을 보여주는 함수
	obj = eval('form.' + obj_name);
	optionCount = obj.length;																		// 제거해야할 select의 option 태그의 수를 얻어온다.
	for (i=0; i<optionCount; i++) obj.remove(0);								// 모든 option 태그를 제거한다.
	newOption = document.createElement('OPTION');					// 출력할 option 요소를 만든다.
	newOption.text = category_2_title;													// text 구성
	newOption.value = '';																				// value 구성
	obj.add(newOption);																				// 현재 선택된 카테고리 리스트의 다음 리스트에 만들어진 option 요소를 추가한다.
	if (obj_parent.value == '') return false;
	temp1 = obj_parent.selectedIndex;
	temp2 = obj_parent.options[temp1].value;
	SELECTOPTION = eval('option_name_' + form_name + '_' + temp2);
	SELECTVALUE = eval('option_value_' + form_name + '_' + temp2);
	for (var k=0; k<SELECTVALUE.length; k++) {								// 새로 나타날 하위 카테고리 목록수만큼 반복
		newOption = document.createElement('OPTION');				// 출력할 option 요소를 만든다.
		newOption.text = SELECTOPTION[k];											// text 구성
		newOption.value = SELECTVALUE[k];											// value 구성			
		obj.add(newOption);																			// 현재 선택된 카테고리 리스트의 다음 리스트에 만들어진 option 요소를 추가한다.
	}
}

// 마우스 클릭시 레이어 메뉴 펼쳐지게 하는 함수 (아래2개)
var select_obj;
function open_mouse_layer(name, status) {
	var obj = document.all[name];
	if (status == 'visible') {
		if (select_obj) {
			select_obj.style.visibility = 'hidden';
			select_obj = null;
		}
		select_obj = obj;
		var x = (event.pageX) ? event.pageX : document.body.scrollLeft+event.clientX;
		var y = (event.pageY) ? event.pageY : document.body.scrollTop+event.clientY;								
		obj.style.left = x + 20;
		obj.style.top = y - 15;
	} else {
		select_obj = null;		
	}
	obj.style.visibility = status;
}

function get_layer_tag(name, layer_contents, width, height) {
	layer_header = "<div id='" + name + "' align='center' valign='middle' style='width=" + width + ";height=" + height + ";visibility:hidden; position:absolute; left:0; top:0; z-index:1'><table width=100% height=100% border=0 bgcolor=CCCCCC cellpadding=3 cellspacing=1>";
	layer_footer = "</table></div>";
	document.writeln(layer_header+layer_contents+layer_footer);
}

/*
*기능:특정 문자 변환
*@param text:원본 문자
*@param oldstr:찾는문자
*@param newstr:대체하는 문자
*@return 변환된 문자열
*/
function str_replace(text, oldstr, newstr){
	cnt = text.length;
	retValue = "";
	for(i=0; i < cnt; i++){
		if (text.charAt(i) == oldstr) retValue += newstr;
		else retValue += text.charAt(i);
	}
	return retValue;
}

function image_preview(form, obj_file, obj_name_img, width, height) {
	obj_image = eval("form." + obj_name_img);
	obj_image.src = obj_file.value;
	if (width != '') obj_image.width = width;
	if (height != '') obj_image.height = height;
}

// 특정 입력상자를 체크상태에 따라 활성 또는 쓰기가능 으로 변경하는 함수
// header_cnt 체크상자 name 앞에 쓰이는 헤더 글자수, 헤더 이후의 name 값은 대상 입력상자명과 동일해야함.
function chk_box_enable(form, obj, header_cnt, mode) {
	obj_name = obj.name;
	obj_name_cnt = obj_name.length;
	obj_target_name = obj_name.substring(header_cnt, obj_name_cnt);
	obj_target = eval('form.' + obj_target_name);
	if (obj.checked == true) {		// 체크된경우
		if (mode == 'D') {					// 비활성 모드
			obj_target.disabled = false;
			obj_target.style.background = 'ffffff';
		} else {										// 읽기전용 모드
			obj_target.readOnly = false;
			obj_target.style.background = 'ffffff';
		}
	} else {
		if (mode == 'D') {					// 비활성 모드
			obj_target.disabled = true;
			obj_target.style.background = 'fafafa';
		} else {										// 읽기전용 모드
			obj_target.readOnly = true;
			obj_target.style.background = 'fefefe';
		}
	}
}

// 날짜 범위 형식이 맞는지 확인
function verify_date_term(form, str) {
	if (str == '') return true;
	reg_express = new RegExp('^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})~([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$');
	if (!reg_express.test(str)) {
		alert('기간 지정 형식이 맞지 않습니다.');
		form.reset();
		return false;
	} else {
		return true;
	}
}

////////////////////////////////////////////////////
// 입력필드에 공백이 있는지 체크
var errmsg = '';
var errfld;

// 필드 검사
function check_field(fld, msg, color_ok, color_error) {
	if (color_ok == '') color_ok = "#EDFBFF";
	if (color_error == '') color_error = "#FFFFFF";
	if ((fld.value = trim(fld.value)) == '') error_field(fld, msg, color_error);
	else fld.style.background = color_ok;
	return;
}

// 필드 오류 표시
function error_field(fld, msg, color) {
	if (color == '') color = "#FFFFFF";
    if (msg != '') errmsg += msg + "\n";
    if (!errfld) errfld = fld;
    fld.style.background = color;
}

// 전화번호, 휴대폰과 같이 여러 필드값을 교차 검사할 때 사용
function check_field_array(objs, msg, color_ok, color_error) {
	if (color_ok == '') color_ok = "#EDFBFF";
	if (color_error == '') color_error = "#FFFFFF";
	flag_i = false;
	for (i=0; i<objs.length; i++) {
		flag_j = false;
		for (j=0; j<objs[i].length; j++) {
			if (objs[i][j].value == '') {					// 2차 오브젝트에 공백값이 있으면 에러표시
				flag_j = true;
				break;
			}
		}
		if (flag_j == false) flag_i = true;			// 공백값이 없는경우 (통과)
	}
	if (flag_i == false) {										// 2차 오브젝트 그룹 모두가 문제가 있는 경우
		if (msg != '') errmsg += msg + "\n";
		for (i=0; i<objs.length; i++) {
			flag_j = false;
			for (j=0; j<objs[i].length; j++) {
				if (!errfld) errfld = objs[i][j];				// 포커스될 필드
				objs[i][j].style.background = color_error;
			}
		}
	} else {
		for (i=0; i<objs.length; i++) {
			flag_j = false;
			for (j=0; j<objs[i].length; j++) {
				objs[i][j].style.background = color_ok;
			}
		}
	}
}

function trim(s) {
	var t = '';
	var from_pos = to_pos = 0;
	for (i=0; i<s.length; i++) {
		if (s.charAt(i) == ' ') {
			continue;
		} else  {
			from_pos = i;
			break;
		}
	}
	for (i=s.length; i>=0; i--) {
		if (s.charAt(i-1) == ' ') {
			continue;
		} else {
			to_pos = i;
			break;
		}
	}	
	t = s.substring(from_pos, to_pos);
	return t;
}

// E-Mail 검사
function email_check(email) {
    if (email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1) return false;
    else return true;
}

// 주민등록번호 검사
function jumin_check(j1, j2) {
	if (j1.value.length<6 || j2.value.length<7) return false;
	var sum_1 = 0;
	var sum_2 = 0;
	var at=0;
	var juminno= j1.value + j2.value;
	sum_1 = (juminno.charAt(0)*2)+
						(juminno.charAt(1)*3)+
						(juminno.charAt(2)*4)+
						(juminno.charAt(3)*5)+
						(juminno.charAt(4)*6)+
						(juminno.charAt(5)*7)+
						(juminno.charAt(6)*8)+
						(juminno.charAt(7)*9)+
						(juminno.charAt(8)*2)+
						(juminno.charAt(9)*3)+
						(juminno.charAt(10)*4)+
						(juminno.charAt(11)*5);
	sum_2=sum_1%11;
	if (sum_2 == 0) {
		at = 10;
	} else {
		if (sum_2 == 1) at = 11;
		else at = sum_2;
	}
	att = 11 - at;
	if (juminno.charAt(12) != att) return false;
	return true
}

// 쿠키 입력
function set_cookie(name, value, expirehours) {
	var today = new Date();
	today.setTime(today.getTime() + (60*60*1000*expirehours));
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// 쿠키 얻음
function get_cookie(name) {
	var find_sw = false;
	var start, end;
	var i = 0;
	for (i=0; i<= document.cookie.length; i++) {
		start = i;
		end = start + name.length;
		if (document.cookie.substring(start, end) == name) {
			find_sw = true
			break
		}
	}
	if (find_sw == true) {
	start = end + 1;
	end = document.cookie.indexOf(";", start);
	if (end < start) end = document.cookie.length;
		return document.cookie.substring(start, end);
	}
	return '';
}

// 쿠키 지움
function delete_cookie(name) {
	var today = new Date();
	today.setTime(today.getTime() - 1);
	var value = getCookie(name);
	if (value != '') document.cookie = name + "=" + value + "; path=/; expires=" + today.toGMTString();
}

// 같은 레코드에 있는 입력값을 변경 또는 체크 하는 함수
function chg_same_idx_obj(obj_source_name, obj_target_name, idx, mode) {
	obj_source = document.getElementsByName(obj_source_name);
	obj_target = document.getElementsByName(obj_target_name);
	switch (mode) {
		case 'V' :
			obj_target[idx].value = obj_source[idx].value;
		break;
		case 'C' :
			obj_target[idx].checked = true;
		break;
	}
}

// 선택(체크)된 레코드 이외의 레코드의 입력상자를 비활성화 시키는 함수
function disable_other_idx_obj(checkbox_name, target_boxs) {
	obj_checkbox = document.getElementsByName(checkbox_name);
	cnt = obj_checkbox.length;
	cnt_target_boxs = target_boxs.length;
	for (i=0; i<cnt_target_boxs; i++) {
		obj_taret_box = document.getElementsByName(target_boxs[i]);
		cnt_obj_target_box = obj_taret_box.length;
		for (j=0; j<cnt_obj_target_box; j++) {
			if (obj_checkbox[j].checked == true) continue;
			obj_taret_box[j].disabled = true;
		}
	}
}

// 목록등의 다중 체크상자를 일괄선택, 반전, 선택취소 하는 함수
function chg_checkbox_state(checkbox_name, mode) {
	obj_checkbox = document.getElementsByName(checkbox_name);
	cnt = obj_checkbox.length;
	for (i=0; i<cnt; i++) {
		switch (mode) {
			case 'C' :
				obj_checkbox[i].checked = true;
			break;
			case 'N' :
				obj_checkbox[i].checked = false;
			break;
			case 'R' :
				if (obj_checkbox[i].checked == false) obj_checkbox[i].checked = true;
				else obj_checkbox[i].checked = false;
			break;
		}
	}
}