/*
*/

window.onerror=null;
popWin = null;
var x = 0;
var y = 0;

function init() {
	if (navigator.appName == "Netscape") {
		window.document.captureEvents(Event.MOUSEMOVE);
	}
	window.document.onmousemove = mouseMove;
}

function mouseMove(e) {
	if (navigator.appName == "Netscape") {
		x = e.pageX + 30;
		y = e.pageY + 35;
	} else {
		x = event.screenX;
		y = event.screenY - 10;
	}
}
//195, 155
function calpopup(el,  url, width, height) {
	popWin=window.open(url, el ,"height="+width+",width="+height+",scrollbars=no,titlebar=no,resizable=no,screenX="+x+",left="+x+",screenY="+y+",top="+y);
	setTimeout("popWin.focus()",250);
}
function modalpopup( el, url, width, height )
{
  modal = showModalDialog(url ,el, "font-family:Verdana; font-size:12; dialogWidth:"+width+"px; dialogHeight:"+height+"px; dialogLeft:"+x+"px; dialogTop:"+y+"px; scroll:no; status:no; resizable:yes;");
  if(modal != "")
  {
     //rngcol.style.backgroundColor = Selcol;
     document.all.calinput.style.backgroundColor = modal;
  }
  return;

}
function modalpopup2( el, url, width, height )
{
  modal = showModalDialog(url ,el, "font-family:Verdana; font-size:12; dialogWidth:"+width+"px; dialogHeight:"+height+"px; dialogLeft:"+x+"px; dialogTop:"+y+"px; scroll:no; status:no; resizable:yes;");
}

function Open_daily(wdname){
	window.open(wdname,'','toolbar=no,status=no,width=600,height=430,directories=no,scrollbars=no,location=no,resizable=no,menubar=no');
}

function Open_todo(wdname){
	window.open(wdname,'','toolbar=no,status=no,width=600,height=300,directories=no,scrollbars=no,location=no,resizable=no,menubar=no');
}

function Open_event(wdname){
	window.open(wdname,'','toolbar=no,status=no,width=600,height=180,directories=no,scrollbars=no,location=no,resizable=no,menubar=no');
}

function Close_calpopup(){
	if (popWin != null)
	if (!popWin.closed) {
	popWin.close();
	popWin = null;
	}
}
