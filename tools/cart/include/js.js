// 전역 변수
var errmsg = "";
var errfld;

function non_select_disable(form, box_name) {
	frm_els = form.elements;
	cnt = frm_els.length ;
	nm_cnt = box_name.length;
	flag_disable = 'N';
	for (i=0; i<cnt ; ++i) {
		if (frm_els[i].type == 'checkbox' && frm_els[i].name.substring(0, nm_cnt) == box_name) {// 이름까지 비교.
			if (frm_els[i].checked) flag_disable = 'N';
			else flag_disable = 'Y';
		} else {
			if (flag_disable == 'Y') frm_els[i]	.disabled = true;
			else frm_els[i].disabled = false;
		}
	}
}

// 필드 검사
function check_field(fld, msg) 
{
    if ((fld.value = trim(fld.value)) == "") 			   
        error_field(fld, msg);
    else
        clear_field(fld);
    return;
}

// 필드 오류 표시
function error_field(fld, msg) 
{
    if (msg != "")
        errmsg += msg + "\n";
    if (!errfld) errfld = fld;
    fld.style.background = "#BDDEF7";
}

// 필드를 깨끗하게
function clear_field(fld) 
{
    fld.style.background = "#FFFFFF";
}

function trim(s)
{
	var t = "";
	var from_pos = to_pos = 0;

	for (i=0; i<s.length; i++)
	{
		if (s.charAt(i) == ' ')
			continue;
		else 
		{
			from_pos = i;
			break;
		}
	}

	for (i=s.length; i>=0; i--)
	{
		if (s.charAt(i-1) == ' ')
			continue;
		else 
		{
			to_pos = i;
			break;
		}
	}	

	t = s.substring(from_pos, to_pos);
	//				alert(from_pos + ',' + to_pos + ',' + t+'.');
	return t;
}

// 자바스크립트로 PHP의 number_format 흉내를 냄
// 숫자에 , 를 출력
function number_format(data) 
{
    var tmp = '';
    var number = '';
    var cutlen = 3;
    var comma = ',';
    var i;

    len = data.length;
    mod = (len % cutlen);
    k = cutlen - mod;
    for (i=0; i<data.length; i++) 
	{
        number = number + data.charAt(i);
        if (i < data.length - 1) 
		{
            k++;
            if ((k % cutlen) == 0) 
			{
                number = number + comma;
                k = 0;
            }
        }
    }

    return number;
}

// E-Mail 검사
function email_check(email) 
{
    if (email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
        return false;
    else
        return true;
}

// 주민등록번호 검사
function jumin_check(j1, j2) 
{
    if (j1.value.length<6 || j2.value.length<7)
        return false;

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

    if (sum_2 == 0) 
	{
        at = 10;
    } 
	else 
	{
        if (sum_2 == 1) 
            at = 11;
		else 
            at = sum_2;
    }
    att = 11 - at;
    if (juminno.charAt(12) != att) 
	{
        return false;
    }

    return true
}

// 새 창
function popup_window(url, winname, opt)
{
    window.open(url, winname, opt);
}

// 우편번호 창
function popup_zip(frm_name, frm_zip1, frm_zip2, frm_addr, rel_dir, top, left)
{
	url = rel_dir+'/zip_code_search.php?frm_name='+frm_name+'&frm_zip1='+frm_zip1+'&frm_zip2='+frm_zip2+'&frm_addr='+frm_addr;
	opt = 'scrollbars=yes,width=500,height=350,top='+top+',left='+left;
	popup_window(url, "winzip", opt);
}


// 폼메일 창
function popup_formmail(url)
{
	opt = 'scrollbars=yes,width=430,height=450,top=10,left=20';
	popup_window(url, "wformmail", opt);
}

// 큰이미지 창
function popup_large_image(it_id, width, height, shop_root) {
	var top = 10;
	var left = 10;
	url = shop_root + "image_real.php?it_id=" + it_id;
	width = width + 50;
	height = height + 50;
	opt = 'scrollbars=yes,width='+width+',height='+height+',top='+top+',left='+left;
	popup_window(url, "largeimage", opt);
}

// , 를 없앤다.
function no_comma(data)
{
	var tmp = '';
    var comma = ',';
    var i;

	for (i=0; i<data.length; i++)
	{
		if (data.charAt(i) != comma)
		    tmp += data.charAt(i);
	}
	return tmp;
}

// 삭제 검사 확인
function del(href) 
{
    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) 
        document.location.href = href;
}

// 쿠키 입력
function set_cookie(name, value, expirehours) 
{
	var today = new Date();
	today.setTime(today.getTime() + (60*60*1000*expirehours));
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// 쿠키 얻음
function get_cookie(name) 
{
    var find_sw = false;
    var start, end;
    var i = 0;

	for (i=0; i<= document.cookie.length; i++)
	{
		start = i;
		end = start + name.length;

		if(document.cookie.substring(start, end) == name) 
		{
			find_sw = true
			break
		}
	}

    if (find_sw == true) 
	{
        start = end + 1;
        end = document.cookie.indexOf(";", start);

        if(end < start)
            end = document.cookie.length;

        return document.cookie.substring(start, end);
    }
    return "";
}

// 쿠키 지움
function delete_cookie(name) 
{
	var today = new Date();

	today.setTime(today.getTime() - 1);
	var value = getCookie(name);
	if(value != "")
		document.cookie = name + "=" + value + "; path=/; expires=" + today.toGMTString();
}



function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}


// 우측 스카이스크래퍼
var bNetscape4plus = (navigator.appName == "Netscape" && navigator.appVersion.substring(0,1) >= "4");
var bExplorer4plus = (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.substring(0,1) >= "4");
var abs_top = 160;
var rel_top = 50;
function CheckUIElements()
{
        var yMenu1From, yMenu1To, yButtonFrom, yButtonTo, yOffset, timeoutNextCheck;
        if ( bNetscape4plus ) { // 네츠케이프 용 설정
                yMenu1From   = document["Menu1"].top;
                yMenu1To     = top.pageYOffset + rel_top;   // 위쪽 위치
        }
        else if ( bExplorer4plus ) {  // IE 용 설정
                yMenu1From   = parseInt (Menu1.style.top, 10);
                yMenu1To     = document.body.scrollTop + rel_top; // 위쪽 위치
        }
        timeoutNextCheck = 500;
        if ( Math.abs (yButtonFrom - (yMenu1To + 152)) < 6 && yButtonTo < yButtonFrom ) {
                setTimeout ("CheckUIElements()", timeoutNextCheck);
                return;
        }
        if ( yButtonFrom != yButtonTo ) {
                yOffset = Math.ceil( Math.abs( yButtonTo - yButtonFrom ) / 10 );
                if ( yButtonTo < yButtonFrom )
                        yOffset = -yOffset;
                if ( bNetscape4plus )
                        document["divLinkButton"].top += yOffset;
                else if ( bExplorer4plus )
                        divLinkButton.style.top = parseInt (divLinkButton.style.top, 10) + yOffset;
                timeoutNextCheck = 10;
        }
        if ( yMenu1From != yMenu1To ) {
                yOffset = Math.ceil( Math.abs( yMenu1To - yMenu1From ) / 20);
                if ( yMenu1To < yMenu1From )
                        yOffset = -yOffset;
                if ( bNetscape4plus )
                        document["Menu1"].top += yOffset;
                else if ( bExplorer4plus ) {
								if (document.body.scrollTop > abs_top) Menu1.style.top = parseInt (Menu1.style.top, 10) + yOffset;
								else Menu1.style.top = abs_top;
					 }
                timeoutNextCheck = 10;
        }
        setTimeout ("CheckUIElements()", timeoutNextCheck);
}
function MovePosition()
{
        var y;
        // 페에지 로딩시 포지션
        if ( bNetscape4plus ) {
                document["Menu1"].top = top.pageYOffset + abs_top;
                document["Menu1"].visibility = "visible";
        }
        else if ( bExplorer4plus ) {
                Menu1.style.top = document.body.scrollTop + abs_top;
                Menu1.style.visibility = "visible";
        }
        CheckUIElements();
        return true;
}