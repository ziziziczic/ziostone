var is_init = false;
var close_id = null;
var interval_id = null;
var which_color = null;
var selectionObj = null;
var default_source = '';
var text_area_name = document.all.field_name_input_box.value;
var obj_input_box = '';

function callColorPicker(tmpx, tmpy, d, e) {
	var x = (e.screenX) ? e.screenX : document.body.scrollLeft+event.clientX;
	var y = (e.screenY) ? e.screenY : document.body.scrollTop+event.clientY;
	x = x + tmpx;
	y = y + tmpy;
	select_color = showColorPicker(x, y, d);
	return select_color;
}

function showColorPicker(x,y,d) {
	var Selcol = showModalDialog("/designer/include/js/palbas.nwz",'','font-family:Verdana; font-size:12; dialogWidth:202px; dialogHeight:190px; dialogLeft:' + x + 'px; dialogTop:' + y + 'px; status:no; help:no; scroll:no'); 
	if(Selcol != '') {
		var valid_color = /[0-9a-fA-F]{6}/;
		if (! valid_color.test (Selcol)) return;
		return Selcol;
	}
}

function EditorGetElement(tagName, start) {
	while (start && start.tagName != tagName) {
		start = start.parentElement;
	}
	return start;
}

function CSelection() {
	this.m_selection = null;
	this.GetSelection = get_selection;
	this.PutSelection = put_selection;
}

function get_selection() {
	if ( this.m_selection != null ) { 
		if( this.m_selection.type != "Control" ) {
			if( ObjInsiteEditor.document.body.createTextRange().inRange( this.m_selection ) == true ) this.m_selection.select();
		} else this.m_selection.select();
	}
}

function put_selection() {
	this.m_selection = ObjInsiteEditor.document.selection.createRange();
	this.m_selection.type = ObjInsiteEditor.document.selection.type;
}

function OnDocumentComplete() {
	if (ObjInsiteEditor.document.readyState != "complete" ) return true;
	obj_input_box = eval("document.all." + text_area_name);

	if(is_init == false ) {
		is_init = true;
		ObjInsiteEditor.document.designMode="On";
		selectionObj = new CSelection();

		if(document.all.editor_yn[1].checked == true ) {
			document.all.ObjInsiteEditor.style.display = "none";
			document.all.insite_toolbar.style.display = "none";
			obj_input_box.style.display = "block";
		} else {
			var src = "";
			src = obj_input_box.value;
			ObjInsiteEditor.document.open("text/html");
			ObjInsiteEditor.document.write( src );
			ObjInsiteEditor.document.close();
			ObjInsiteEditor.document.oncontextmenu = new Function("return false;");
		}
	}
	return true;
}

function OnChangeEditorYN() {
	if( document.all.editor_yn[0].checked == true ) {
		ObjInsiteEditor.document.open("text/html");
		ObjInsiteEditor.document.write(obj_input_box.value);
		ObjInsiteEditor.document.close();
		ObjInsiteEditor.document.oncontextmenu = new Function("return false;");
		document.all.ObjInsiteEditor.style.display = "block";
		document.all.insite_toolbar.style.display = "block";
		obj_input_box.style.display = "none";
		selectionObj.m_selection = null;
		document.all.ObjInsiteEditor.focus();
	} else if( document.all.editor_yn[1].checked == true ) {
		obj_input_box.value = ObjInsiteEditor.document.body.innerHTML;
		document.all.ObjInsiteEditor.style.display = "none";
		document.all.insite_toolbar.style.display = "none";
		obj_input_box.style.display = "block";
		obj_input_box.focus();
	}
}

function submit_editor(form_name) {
	form = eval('document.' + form_name);
	if(form.editor_yn[0].checked == true) {
		obj_input_box.value = ObjInsiteEditor.document.body.innerHTML;	// html 편집모드 이면 에디터 내용을 textarea 에 넣는다.
	}
	return true;
}

function buttonover(td) {
	td.borderColorDark = "white";
	td.borderColorLight = "gray";
	td.style.cursor = "hand";
}

function buttonout(td) {
	td.borderColorDark = "#EBEBEB";
	td.borderColorLight = "#EBEBEB";
	td.style.cursor = "auto";
}

function buttondown(td) {
	td.borderColorDark = "gray";
	td.borderColorLight = "white";
}

function command(obj) {
	if( selectionObj.m_selection != null )
		selectionObj.GetSelection();

	if( obj.tagName == "SELECT" ) {
		if( obj.id == "insite_edit" ) {
			if( obj.options[obj.selectedIndex].text == "전체선택" ) {
				ObjInsiteEditor.document.execCommand("SelectAll");
			} else if( obj.options[obj.selectedIndex].text == "잘라내기" ) {
				ObjInsiteEditor.document.execCommand("Cut");
			} else if( obj.options[obj.selectedIndex].text == "붙여넣기" ) {
				ObjInsiteEditor.document.execCommand("Paste");
			} else if( obj.options[obj.selectedIndex].text == "지우기" ) {
				ObjInsiteEditor.document.execCommand("Delete");
			} else if( obj.options[obj.selectedIndex].text == "복사" ) {
				ObjInsiteEditor.document.execCommand("Copy");
			}
			obj.options[0].selected = true;
		} else if( obj.id == "insite_font" ) {
			if( obj.options[obj.selectedIndex].text != "Times" ) {
				ObjInsiteEditor.document.execCommand("FontName", null, obj.options[obj.selectedIndex].text);
			} else if( obj.options[obj.selectedIndex].text == "Times" ) {
				ObjInsiteEditor.document.execCommand("FontName", null, "Times New Roman");
			}			
			obj.options[0].selected = true;
		} else if( obj.id == "insite_fontsize" ) {
			ObjInsiteEditor.document.execCommand("FontSize", null, obj.options[obj.selectedIndex].value);
			obj.options[0].selected = true;
		}
	} else {
		if( obj.id == "insite_bold" ) {
			ObjInsiteEditor.document.execCommand("Bold");
		} else if( obj.id == "insite_italic" ) {
			ObjInsiteEditor.document.execCommand("Italic");
		} else if( obj.id == "insite_underline" ) {
			ObjInsiteEditor.document.execCommand("Underline");
		} else if( obj.id == "insite_fontcolor" ) {
			which_color = obj.id;
			color_click();
		} else if( obj.id == "insite_fontbgcolor" ) {
			which_color = obj.id;
			color_click();
		} else if( obj.id == "insite_tablebgcolor" ) {
			which_color = obj.id;
			color_click();
		} else if( obj.id == "insite_left" ) {
			ObjInsiteEditor.document.execCommand("JustifyLeft");
		} else if( obj.id == "insite_center" ) {
			ObjInsiteEditor.document.execCommand("JustifyCenter");
		} else if( obj.id == "insite_right" ) {
			ObjInsiteEditor.document.execCommand("JustifyRight");
		} else if( obj.id == "insite_numlist" ) {
			ObjInsiteEditor.document.execCommand("InsertOrderedList");
		} else if( obj.id == "insite_itemlist" ) {
			ObjInsiteEditor.document.execCommand("InsertUnorderedList");
		} else if( obj.id == "insite_outdent" ) {
			ObjInsiteEditor.document.execCommand("Outdent");
		} else if( obj.id == "insite_indent" ) {
			ObjInsiteEditor.document.execCommand("Indent");
		} else if( obj.id == "insite_table" ) {
			make_table();
		} else if( obj.id == "insite_anchor" ) {
			var anchor = EditorGetElement("A", eval(ObjInsiteEditor).document.selection.createRange().parentElement());
			var link = prompt("링크할 주소를 입력하세요. (예: http://www.ohmysite.co.kr)", anchor ? anchor.href : "http://");
			if (link && link != "http://") {
				if (ObjInsiteEditor.document.selection.type == "None") {
					var range = ObjInsiteEditor.document.selection.createRange();
					range.pasteHTML('<A HREF="' + link + '"></A>');
					range.select();
				} else {
					ObjInsiteEditor.document.execCommand("CreateLink", "", link);
				}
			}
		}
	}
	buttonout(obj);
	document.all.ObjInsiteEditor.focus();
}


function make_table() {
	insite_cellsdiv.style.left = event.clientX + document.body.scrollLeft - 10;
	insite_cellsdiv.style.top = event.clientY + document.body.scrollTop;

	var collTD = insite_cellstable.all;

	for( i=0 ; i < collTD.length ; i++ ) {
		if( collTD(i).tagName == "TD" && collTD(i).id != "xy_display" )
			collTD(i).bgColor = "";
	}
	start_timeout(document.all.insite_cellstable);
	insite_cellsdiv.style.visibility = "visible";
}

function coloring(td) {
	var i, rowNum, columnNum;
	rowNum = getRowNum(td);
	columnNum = getColumnNum(td);

	xy_display.innerHTML = columnNum + " * " + (11-rowNum);

	var collTD = insite_cellstable.all;

	for( i=0 ; i < collTD.length ; i++ ) {
		if( collTD(i).tagName == "TD" && collTD(i).id != "xy_display" && getRowNum(collTD(i)) >= rowNum && getColumnNum(collTD(i)) <= columnNum ) {
			collTD(i).bgColor = "orange";
		} else {
			collTD(i).bgColor = "";
		}
	}
}

function selectXY(td) {
	var NumRows = 11-getRowNum(td);
	var NumCols = getColumnNum(td);
	var strTable = "<TABLE border=1 cellspacing=0 bordercolor ='black' style='border-collapse:collapse;width:560px'>\n";

	var widthCols = Math.ceil(100/getColumnNum(td))-1;
	var CellAttrs = "width='" + widthCols + "%'";
	
	var i = 0, j = 0;
	for( i = 0 ; i < NumRows ; i++ ) {
		strTable += "<TR>\n";
		for( j = 0 ; j < NumCols ; j++ ) {
			strTable += "<TD " + CellAttrs + ">&nbsp;</TD>\n";
		}		
		strTable += "</TR>\n";
	}
	strTable += "</TABLE>\n";

	var Range = null;
	if( selectionObj.m_selection != null ) {
		selectionObj.GetSelection();
		Range = selectionObj.m_selection;
	} else {
		Range = ObjInsiteEditor.document.selection.createRange();
		Range.type = ObjInsiteEditor.document.selection.type;
	}
	
	if( Range.type != "Control" && ObjInsiteEditor.document.body.createTextRange().inRange( Range ) == true ) Range.pasteHTML( strTable );
	else if( Range.type == "Control" ) {
		Range.execCommand("Delete");
		ObjInsiteEditor.document.selection.createRange().pasteHTML( strTable );
	}
	close_div(insite_cellsdiv);
}

function getRowNum(td) {
	var gap = td.sourceIndex - base.sourceIndex;
	var row;
	if( Math.round(gap/11) - gap/11 < 0 ) row = Math.round(gap/11) + 1;
	else row = Math.round(gap/11);
	return row;
}

function getColumnNum(td) {
	return (td.sourceIndex - base.sourceIndex)%11;
}

function close_div(obj) {
	obj.style.visibility = "hidden";
	clearTimeout(close_id);
}

function color_click(td) {
	if( selectionObj.m_selection != null ) selectionObj.GetSelection();
	get_color = callColorPicker(-50, -50, 1, event);
	if( which_color == "insite_fontcolor" ) {
		ObjInsiteEditor.document.execCommand( "ForeColor", false, get_color);
	} else if( which_color == "insite_fontbgcolor" ) {
		ObjInsiteEditor.document.execCommand( "BackColor", false, get_color);
	} else if( which_color == "insite_tablebgcolor" ) {
		table_color(get_color);
	}
	which_color = "";
}

function table_color(bgColor) {
	if( ObjInsiteEditor.document.selection.type == "None" || ObjInsiteEditor.document.selection.type == "Text" ) {
		var selectedTD;
		if( (selectedTD = isintd( ObjInsiteEditor.document.selection.createRange().parentElement() ) ) != null ) {
			selectedTD.bgColor = bgColor;
		}
	} else if( ObjInsiteEditor.document.selection.type == "Control" ) {
		if( ObjInsiteEditor.document.selection.createRange().item(0).tagName == "TABLE" ) {
			ObjInsiteEditor.document.selection.createRange().item(0).bgColor = bgColor;
		}
	}
}

function isintd(obj) {
	var i;
	for( i=0 ; i < 100 ; i++ ) {
		if( obj.tagName == "TD" ) return obj;
		else if( obj.tagName == "TABLE" || obj.tagName == "BODY" || obj.tagName == null ) return null;
		else obj = obj.parentElement;
	}
	return null;
}

function start_timeout(table) {
	if( close_id != null ) clearTimeout(close_id);
	if( table.id == "insite_cellstable" ) close_id=setTimeout("close_div(document.all.insite_cellsdiv)",1500);
}

function clear_timeout() {
	clearTimeout(close_id);
	close_id = null;
}

function deactivate_handler() {
	if( is_init )
		selectionObj.PutSelection();
}

function force_editmode() {
	if( is_init == false ) OnDocumentComplete();
	else clearInterval( interval_id );
}


