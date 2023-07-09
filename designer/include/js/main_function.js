function DeleteContent(key){
	if(key == "header")
		if(document.head_footer.header.value == "머리글을 입력해주세요.")
			document.head_footer.header.value = "";
	if(key == "footer")
		if(document.head_footer.footer.value == "바닥글을 입력해주세요.")
			document.head_footer.footer.value = "";
	if(key == "title")
		if(document.title_input.title.value == "타이틀을 입력해주세요.")
			document.title_input.title.value = "";
}


  var msg;

  function addorg (p)
    {
      document.fo_cs.msg.value += p;
      if (document.fo_cs.msg.focus)
        setTimeout ("msgFocus()", 500);
    }
  function add (p)
    {
      addorg ("/"+p+"/");
    }

  function callColorPicker(tmpx,tmpy,d)
    {
      var x = event.screenX - event.clientX - document.body.scrollLeft;
      var y = event.screenY - event.clientY - document.body.scrollTop;

      x = x + tmpx;
      y = y + tmpy;

      showColorPicker(x,y,d);
      return;
    }

function showColorPicker(x,y,d)
  {
	var Selcol = showModalDialog("../js/palbas.nwz","","font-family:Verdana; font-size:12; dialogWidth:202px; dialogHeight:162px; dialogLeft:" + x + "px; dialogTop:" + y + "px; status:no; help:no; scroll:no"); 
    if(Selcol != "")
    {
		var valid_color = /[0-9a-fA-F]{6}/;
		if (! valid_color.test (Selcol))
        return;
		if(d==1)	  {
			  document.tc_body.bcolor.style.backgroundColor = Selcol;
			  document.tc_body.bgcolor.value = Selcol; 
		} else {
			  document.fo_cs.bcolor.style.backgroundColor = Selcol;
			  document.fo_cs.bgcolor.value = Selcol; 
		}
	}
    return;
}

function send_table(form)
{
if(form.row.value==""){
	alert("테이블을 생성하려면 꼭 Row(줄) 값을 입력해야 합니다.");
	form.row.focus();
	return;
	}

if(form.col.value==""){
	alert("테이블을 생성하려면 꼭 Col(칸) 값을 입력해야 합니다.");
	form.col.focus();
	return;
	}
form.submit();

}


function tc_show_layer(lname, flag)
{
  var layer = (navigator.appName == 'Netscape') ? document.layers[lname] : document.all[lname];
  if (lname == '')
    return;
  if (navigator.appName == 'Netscape')
    layer.visibility = (flag == 0) ? 'show' : 'hide';
  else
    layer.style.visibility = (flag == 0) ? 'visible' : 'hidden';
}


// 디폴트인풋 자바스크립트 
// 디자인파일 보기위한 새창열기 자바스크립트 


function design_open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
  toolbar_str = toolbar ? 'yes' : 'no';
  menubar_str = menubar ? 'yes' : 'no';
  statusbar_str = statusbar ? 'yes' : 'no';
  scrollbar_str = scrollbar ? 'yes' : 'no';
  resizable_str = resizable ? 'yes' : 'no';
   
  window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str).focus();
 
}

function code_delete()
{
	window.location.href="design_save.php3?where=main&field=code_delete&code=<?echo($code)?>&design_name=<?echo($design_name)?>";
}

function delete_ok() {
//	var ms;
if(jumpy.example.value==""){
	alert("삭제할 페이지를 선택해 주세요.");
	jumpy.example.focus();
	return;
	}
	
	if ( confirm ('현재 페이지를 삭제합니다.')) {
     code_delete() }
		return false 
}

function new_name_saved() {
	window.location.href="new_code_saved.php3?new_code=<?echo($new_code_name)?>&code=<?echo($code)?>&design_name=<?echo($design_name)?>";

}

function sendit() {

if(new_name_form.new_name.value==""){
	alert("새이름으로 저장될 페이지 이름을 입력해주세요.");
	new_name_form.new_name.focus();
	return;
	}
new_name_form.submit();
}

function send_new_code() {

if(make_page_form.make_page.value==""){
	alert("새로 만들 페이지 이름을 입력해주세요.");
	make_page_form.make_page.focus();
	return;
	}
make_page_form.submit();
}

function design_delete()
{
	<?
	if ($design_name) $dname = "&design_name=" . $design_name;
	if ($code) $dcode = "&code=" . $code;
	?>
	var dsl = design_select_name_form.design_select_name.value + "<?echo("$dname$dcode")?>";
	window.location.href="design_select_delete.php3?selected_design_name=" + dsl;
}

function design_delete_ok() {
	if(design_select_name_form.design_select_name.value=="") {
		alert("삭제하려는 디자인 이름을 선택해주세요.");
		design_select_name_form.design_select_name.focus();
	   return;
	} else {
		if(confirm ('주의 : 현재 디자인을 삭제합니다.')) 
		{
		design_delete();
//		design_select_name_form.submit();
		} else { return false;}
	}
}

function design_make_check() {
	if(design_new_name_form.design_new_name.value=="") {
		alert("생성할 디자인 이름을 입력해주세요.");
		design_new_name_form.design_new_name.focus();
	   return;
	}
	design_new_name_form.submit();
}

function design_select_check() {
	if(design_select_name_form.design_select_name.value=="") {
		alert("디자인 이름을 선택해주세요.");
		design_select_name_form.design_select_name.focus();
	   return;
	}
	design_select_name_form.submit();
}

function not_code() {
	alert("현재 작업중인 파일이 없거나 지금 가져온 페이지가 있습니다.\n\n먼저 페이지를 선택하거나 새로운 페이지를 만들어주세요.");
	return;
}

function new_name_ok() {
	if(design_select_name_form.design_select_name.value=="") {
		alert("디자인 이름을 선택해주세요.");
		design_select_name_form.design_select_name.focus();
	   return;
	}
	design_select_name_form.submit();
}
