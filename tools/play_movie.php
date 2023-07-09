
<!----

www.xmagic.co.kr 
0502-170-7000 
seogi@xmagic.co.kr

----->


<html>

<head>

<title>(주)한국플레어 뉴스리포트</title>

<script>
function resize(size){	
if(size == '100'){		
	document.MediaPlayer.DisplaySize = 1;		
	self.resizeTo(352,356);	
	}	
else if(size == '200'){		
	document.MediaPlayer.DisplaySize = 2;		
	self.resizeTo(604,672);	
	}	
else if(size == 'full'){		
	document.MediaPlayer.DisplaySize = 3;	
	}
}
</script>

<style type=text/css>

<!-- 

a:link    	{font-size: 8pt;color:2FA6B7;text-decoration:none;line-height:150%;}
a:visited 	{font-size: 8pt;color:2FA6B7;text-decoration:none;line-height:150%;}
a:active  	{font-size: 8pt;color:2FA6B7;text-decoration:none;line-height:150%;}
a:hover 	{font-size: 8pt;color:#FF9900;text-decoration:underline;line-height:150%;}

td {font-size: 12px; color:#717171; text-decoration: none}

//--> 

</style>

</head>

<body topmargin="0" leftmargin="0" rightmargin="0" BGCOLOR="#FFFFFF"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	<tr>
		<td bgcolor="#000000">
			<object classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" width="100%" height="100%"  id="MediaPlayer" type="application/x-oleobject" standby="Loading Microsoft Windows Media Player components...">
              <param name="Filename" value="./movie/<?=$movie_name;?>">
			  <PARAM NAME="AutoStart" VALUE="-1">
			  <PARAM NAME="AnimationAtStart" VALUE="0">
			  <PARAM NAME="BufferingTime" VALUE="5">
			  <PARAM NAME="ClickToPlay" VALUE="-1">
			  <PARAM NAME="DisplayBackColor" VALUE="0">
			  <PARAM NAME="DisplayForeColor" VALUE="99177215">
			  <PARAM NAME="ShowStatusBar" VALUE="0">
			  <PARAM NAME="TransparentAtStart" VALUE="-1">
			  <PARAM NAME="Volume" VALUE="-1300">
			  <PARAM NAME="ShowControls" VALUE="-1">
			  <PARAM NAME="ShowDisplay" VALUE="0">
			  <PARAM NAME="EnableContextMenu" VALUE="0">
			  <param name="VideoBorderColor" value="1">
            <embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/" Name="AniPlayer" Src>
			</object>
		</td>
	</tr>
	<tr>
		<td height="50">
      <table width="100%" height="100%" border="1" cellspacing="0" cellpadding="1" bordercolorlight="cccccc" bordercolordark="ffffff">
        <TBODY>
		<tr bgcolor="eeeeee"> 
          <td align="center" bgcolor="f0f0f0" width="30%"><b><a href="javascript:resize('100')">100%</a></b></td>
          <td align="center" bgcolor="f0f0f0" width="30%"><b><a href="javascript:resize('200')">200%</a></b></td>
         <td align="center" bgcolor="f0f0f0" width="30%"><b><a href="javascript:resize('full')" >Full</a></b></td>
        </tr>
		</TBODY>
      </table>
		</td>
	</tr>
</table>

</body>
</html>
