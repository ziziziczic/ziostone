<? 
//PHP source : http://data.ardor.net
//�������� ���丮�� �Խ����� ���·� ����ϸ鼭 �̹����� �״�� ���÷����մϴ�.
//�����ο� ������ �� �־�� �ϹǷ�, �����ڸ��� ����� �� �ְ�, Ư�� Ȯ���ڿ� ���� ������ ������ �� �ֽ��ϴ�.
//���丮 ����Ʈ ���·� �����ϱ� ���� ������ ����ϱ� ���� ��������ϴ�.
//���������� ���ϼ����� ��ġ�� �ʰ� ��� ��밡���մϴ�.

//��õ �ҽ��� ������(maldduk@jsd.snu.ac.kr)���� �����Ͻ� ���Դϴ�.
//(http://jsd.snu.ac.kr/ftp/pub/images/imglist.php3)
//���⿡, �÷��� ȭ�ϰ� �ؽ�Ʈ ȭ���� ���÷��� ����� �߰��ϰ�,
//��Ÿ ����Ǿ �������� ȭ�ϵ��� ����Ʈ �ϰ� ��������ϴ�.
//������ ��ɰ� ������ �� �뷮, �ű�ȭ�� ǥ�ñ��, 
//2���� �̻󿡼� ������� �̵��ϱⰡ �ȵǴ� ���� ������ �������� Ȯ���߽��ϴ�.
//�����ε� ���� �����߽��ϴ�.
//comment.cmt��� �̸����� �ش� ���丮�� ������ ���� �ؽ�Ʈȭ���� �����ϸ� ������ ���÷��� �˴ϴ�.
//mp3�� ID3v1 Tag ������ �����ݴϴ�.
//���� ��θ� �� �� ���� ����� ���Ȱ��� ������ �߰��Ͽ����ϴ�.
//(��θ��� ".."�� �����ϵ��� �⺻ �����Ǿ� �ֱ� ������, ȭ���̳� ���丮�� ".."�� ���ԵǴ� ��� ������ ����ų �� �ֽ��ϴ�.)

$ftpname =  ""; //����Ʈ ���� (������� ������ ���� URL)
$wwwrooturl =  ""; //�����ְ��� �ϴ� �� ���� URL (������� ������ ���� URL)
$wwwrootpath =  ""; //�� URL�� ������ ��ġ (������� ������ ���� URL�� ������ ��ġ)
$cut = "20"; // ���������� ǥ�õǴ� ���� ��
$imglimit = "430"; // ���÷��� �Ǵ� �̹����� �ִ� ���� ������ (�� ū �̹����� �̻������ �ٿ��� �������ϴ�.)
$textlimit = "300"; // ���÷��� �Ǵ� �ؽ�Ʈ ȭ���� �ִ� ���� �� (�� �� ������ �� ���� ���� �ٿ��� �������ϴ�.)
$uppath = ""; // ���� �������� ��ġ���� ���� ������ ��θ� �� �� �ְ� �� ���ΰ� ("ok"��� �־�� ����)
$filter = "(.gif|.jpg|.htm|.zip|.html|.txt|.swf|.psd|.text|.jpeg|.tar|.gz|.exe|.fla|.hwp|.doc|.ppt|.mov|.wmv|.mp3|.ai|.php|.php3|.tif|.tiff|.eps|.lnk|.css|.js|.url|.mht|.chm|.asf|.asx|.bmp|.mpg|.mpeg|.exe|.mxl|.ra|.au|.avi|.alz|.smi|.ram|.ico|.mwf|.smf|.lcd|.diz|.fon|.ttf|.ttc|.iso|.inf|.divx|.a00|.a01|.a02|.a03|.xls|.sit|.bin)$";
//����Ʈ�Ǵ� Ȯ����
$delim =  "/"; // ���丮 ������
$url1 = $SERVER_NAME;
$url2 = $PHP_SELF;
$url3 = strrchr($url2,"/");
$url3 = str_replace($url3,"",$url2);
$url0 = "http://$url1$url3";
if(!$wwwrooturl) $wwwrooturl = $url0;
$path1 = $SCRIPT_FILENAME;
$path2 = $PHP_SELF;
$path2 = strrchr($path2,"/");
$path0 = str_replace($path2,"",$path1);
if(!$wwwrootpath) $wwwrootpath = $path0;
if(!$ftpname) $ftpname = $wwwrooturl;
if($uppath != "ok") $path = str_replace("..","",$path);

function mp3($mpfile){ 
$fp = fopen("$mpfile","r"); 
fseek($fp,filesize("$mpfile")-128); 
$ID_tag = fread($fp, 128); 
$tag = substr($ID_tag,0,3); 
$title = substr($ID_tag,3,30); 
$artist = substr($ID_tag,33,30); 
$album = substr($ID_tag,63,30); 
$year = substr($ID_tag,93,4); 
$comment = substr($ID_tag,97,30); 
$genre = substr($ID_tag,127,1); 
fclose($fp); 
return array($tag,$title,$artist,$album,$year,$comment,$genre); 
}




function str_cut_dot($string,$limit_length) {
$string_length = strlen( $string ); 
if ( $limit_length <= $string_length ) { 
$string = substr( $string, 0, $limit_length )."..."; 
$han_char = 0; 
for ( $i = $limit_length-1; $i>=0; $i-- ) { 
$lastword = ord( substr( $string, $i, 1 ) );
if ( 127 > $lastword ) break;
else $han_char++;
} 
if ( $han_char%2 == 1 ) $string = substr( $string, 0, $limit_length-1 ) . "... "; 
} 
return $string; 
}




function update($file) 
{
$time = fileMtime($file);
if ($time > Time() - 86400) {
return "<font class=new>new</font> ";
}
else return "";
}; 




function get_fileSize( $file ) { 
$file_size = filesize($file); 
if( $file_size >= 1073741824 ) $file_size = round($file_size / 1073741824 * 100) / 100 . " Gbytes"; 
else if( $file_size >= 1048576 ) $file_size = round($file_size / 1048576 * 100) / 100 . " Mbytes"; 
else if( $file_size >= 1024 ) $file_size = round($file_size / 1024 * 100) / 100 . " Kbytes"; 
else $file_size = $file_size . " bytes"; 
return $file_size; 
} 




function list_dir($dirname, $filter, $delim)  
{                  
if( $dirname[strlen($dirname)-1] != $delim ) $dirname.=$delim;

$result_array=array();
$handle=opendir($dirname);

while ($file = readdir($handle)) {
if($file== '.'||$file== '..') continue;  
if(is_dir($dirname . $delim . $file)) { 
$result_array[]= "!$file"; 
continue; 
} 
else if(eregi($filter, $file)) $result_array[]=$file;  
} 
 
closedir($handle);  

$result_array = array_reverse($result_array);

return $result_array;  
} 




if($path !=  "") $path2dir=$path;   
else $path2dir =  ""; 

$path = str_replace(" ","%20",$path);

$dir =  "$wwwrootpath$delim$path2dir";                     
$dirlist = list_dir($dir, $filter, $delim);

if($order == "old") $dirlist = array_reverse($dirlist);
if($order == "atoz") asort($dirlist);
if($order == "ztoa") rsort($dirlist);

$size = sizeof($dirlist);           

if($wwwrooturl == "$wwwrooturl$path2dir") $up ="";
else {
$parentnumber = strrpos($path,"$delim");
$parentpath = substr($path,"",$parentnumber);
$up =" :::: <a href=$PHP_SELF?path=$parentpath><font color=white>[UP]</font></a>";
}

$totalpage = ceil($size/$cut);

if(!$page) $page = 1;
$next = $page +1;
$previous = $page -1;

$first = ($page - 1)*$cut +1;
$end = $first + $cut - 1;

if($totalpage <= 1) $pagecount = "";
else $pagecount = "<font class=title>$page</font>/$totalpage";




$commnet_file = "$wwwrootpath$delim$path2dir{$delim}comment.cmt";
if(file_exists($commnet_file)) {
$cmtsrc = fopen ($commnet_file,r);
$cmtread =fread($cmtsrc,$textlimit);
$comment = nl2br(str_cut_dot($cmtread,$textlimit));
$comment = "<br><br>$comment";
fclose ($cmtsrc);
}
else $comment = "";




echo  "

			<!-- PHP source : http://data.ardor.net-->
			<!doctype html public '-//w3c//dtd html 4.0 transitional//en'>
			<html>
			<head>
			<title>$wwwrooturl$path2dir</title>
			<meta name=author content ='kion park, ardor.net, all rights are reserved. 2002'>
			<meta http-equiv=content-type content=text/html;charset=euc-kr>
			<style type=text/css title=style>
			a:active { color:#1c85ce ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:link { color:#1c85ce ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:visited { color:#1c85ce ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:hover { color:black ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:active.src { color:#777777 ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:normal}
			a:link.src { color:#777777 ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:normal }
			a:visited.src { color:#777777 ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:normal }
			a:hover.src { color:black ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:normal }
			a:active.dir { color:#0d5a8f ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:link.dir { color:#0d5a8f ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:visited.dir { color:#0d5a8f ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:hover.dir { color:black ; font-family:verdana,���� ; font-size:8pt ; text-decoration:none ; font-weight:bold }
			a:active.order { color:black ; font-family:arial,���� ; font-size:7pt ; text-decoration:none ; font-weight:normal }
			a:link.order { color:black ; font-family:arial,���� ; font-size:7pt ; text-decoration:none ; font-weight:normal }
			a:visited.order { color:black ; font-family:arial,���� ; font-size:7pt ; text-decoration:none ; font-weight:normal }
			a:hover.order { color:#0d5a8f ; font-family:arial,���� ; font-size:7pt ; text-decoration:none ; font-weight:normal }
			body { background-color:#dddddd ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			td.title { background-color:#a2bdcf ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			td { background-color:white ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			td.img { background-color:#f4f4f4 ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			td.dir { background-color:#ebebeb ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			td.dirname { background-color:#f4f4f4 ; color:#444444 ; font-family:verdana,���� ; font-size:8pt }
			font.title { color:black ; font-family:verdana,���� ; font-size:9pt ; font-weight:bold }
			font.new { color:red ; font-family:verdana,���� ; font-size:8pt }
			img { border-width:1px ; border-color:#dddddd }
			</style>
			</head>

			<body>

			<p align=center>

";


$jmp = 20;
$end_jmp = ceil($page / $jmp) * $jmp;
$start_jmp = $end_jmp - $jmp;

if($end_jmp > $totalpage) $end_jmp = $totalpage;

if($previous > 0)
echo "<a href=$PHP_SELF?path=$path&page=$previous&order=$order>< previous $cut items ></a>
";
elseif($totalpage <= 1)
echo "";
else
echo "<a href=$PHP_SELF?path=$path&page=$totalpage&order=$order>< go to the end ></a>
";

for($i = $start_jmp + 1 ; $i < $end_jmp + 1; $i++){
if($totalpage <= 1) echo "";
elseif($i == $page) echo "<font class=title>$i</font>
";
else echo "<a href=$PHP_SELF?path=$path&page=$i&order=$order> $i </a>
";
}

if($next <= $totalpage)
echo "<a href=$PHP_SELF?path=$path&page=$next&order=$order>< next $cut items ></a><br>
";
elseif($totalpage <= 1)
echo "";
else
echo "<a href=$PHP_SELF?path=$path&page=1&order=$order>< go to the first ></a><br>
";


echo "

			<table border=0 cellpadding=10 cellspacing=2>
			<td colspan=2 align=right style=padding:0px;background-color:transparent >
			<a class=order href=$PHP_SELF?path=$path&page=$page>[ normal ]</a>
			<a class=order href=$PHP_SELF?path=$path&page=$page&order=old>[ reverse ]</a>
			<a class=order href=$PHP_SELF?path=$path&page=$page&order=atoz>[ a-z ]</a>
			<a class=order href=$PHP_SELF?path=$path&page=$page&order=ztoa>[ z-a ]</a>
			</td>
			</tr>
			<tr>
			<td colspan=2 align=center class=title><nobr>&nbsp;&nbsp;
			<font class=title>$ftpname$path2dir</font> ({$size}items) $pagecount$up$comment
			</td>
			</tr>

";




while (list ($key, $val) = each ($dirlist)) { 
$items++;
if($items >= $first and $items <= $end) {


					if($val[0]== '!') {
						$dircnt++;
						$val = substr($val, 1); 

						$commnet_sub_file = "$wwwrootpath$delim$path2dir{$delim}$val{$delim}comment.cmt";
						if(file_exists($commnet_sub_file)) {
						$cmtsrc = fopen ($commnet_sub_file,r);
						$cmtread =fread($cmtsrc,$textlimit);
						$comment_sub = nl2br(str_cut_dot($cmtread,$textlimit));
						$comment_sub = "<br><br>$comment_sub";
						fclose ($cmtsrc);
						}
						else $comment_sub = "";
						echo  "
								<tr>
								<td width=100 align=left valign=middle class=dirname><nobr><b>DIR</b> (Folder)</td>
								<td width=480 align=left class=dir><nobr>
								<a href=\"$PHP_SELF?path=$path2dir$delim$val\" class=dir>[$val]</a>$comment_sub<br>
								</td>
								</tr>
					"; 
					}
					else {         
						$encodedurl = urlencode( "$path2dir$delim$val");
						$encodedurl = ereg_replace( "%2F",  "/", $encodedurl);
						$encodedurl = ereg_replace( "[+]",  "%20", $encodedurl);
						$extnumber = strrpos($encodedurl,".") + 1;
						$ext = substr($encodedurl,$extnumber);
						$fsize = get_fileSize("$wwwrootpath$delim$path2dir$delim$val");

						if($ext == 'jpg' || $ext == 'JPG' || $ext == 'jpeg' || $ext == 'JPEG' || $ext == 'gif' || $ext == 'GIF' || $ext == 'png' || $ext == 'PNG' || $ext == 'bmp' || $ext == 'BMP') {
						$imgcnt++;
						$new = update("$wwwrootpath$delim$path2dir$delim$val");
						$imginfo = getimagesize("$wwwrootpath$delim$path2dir$delim$val");
						if($imginfo[0] > $imglimit) $width = "width=$imglimit";
						else $width = "";
						echo  "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=img>
								<p align=left><nobr>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($imginfo[0]x$imginfo[1], $fsize) $new
								</p>
								<p align=left>
								<a href=\"$wwwrooturl$encodedurl\" target=image><img src=\"$wwwrooturl$encodedurl\" $width alt='$val'></a>
								</p>
								<p align=left><nobr>
								$wwwrooturl$path2dir$delim$val
								</p>
								</td>
								</tr>
						";
						}

						elseif($ext == 'swf' || $ext == 'SWF' ) {
						$imgcnt++;
						$new = update("$wwwrootpath$delim$path2dir$delim$val");
						echo  "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=img>
								<p align=left><nobr>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($fsize) $new
								</p>
								<p align=left>
								<a href=\"$wwwrooturl$encodedurl\" target=image><object classid=clsid:d27cdb6e-ae6d-11cf-96b8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0><param name=movie value=$wwwrooturl$encodedurl><param name=quality value=high><embed src=$wwwrooturl$encodedurl quality=high type=application/x-shockwave-flash pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash></embed></object></a>
								</p>
								<p align=left><nobr>
								$wwwrooturl$path2dir$delim$val
								</p>
								</td>
								</tr>
						"; 
						}

						elseif($ext == 'txt' || $ext == 'TXT' || $ext == 'text' || $ext == 'TEXT' || $ext == 'CSS' || $ext == 'css') {
						$filecnt++;
						$new = update("$wwwrootpath$delim$path2dir$delim$val");
						$thumbsrc = fopen ("$wwwrootpath$delim$path2dir$delim$val",r);
						$thumbread =fread($thumbsrc,$textlimit);
						$thumbtxt = nl2br(str_cut_dot($thumbread,$textlimit));
						fclose ($thumbsrc);
						echo  "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=img>
								<p align=left>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($fsize) $new
								</p>
								<p align=left>
								<table width=100% cellpadding=5 cellspacing=0><tr><td width=100% onMouseOver=this.style.backgroundColor='#d3e1eb' onMouseOut=this.style.backgroundColor=''><a href=\"$wwwrooturl$encodedurl\" target=image class=src>  
								$thumbtxt  
								</a></td></tr></table>
								</p>
								<p align=left><nobr>
								$wwwrooturl$path2dir$delim$val
								</p>
								</td>
								</tr>
						"; 
						}

						elseif($ext == 'mp3' || $ext == 'MP3') {
						$filecnt++;
						$new = update("$wwwrootpath$delim$path2dir$delim$val");
						$thumbsrc = mp3("$wwwrootpath$delim$path2dir$delim$val");
						if($thumbsrc[0] != "TAG") $mp3info = "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=ext><nobr>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($fsize) $new<br>
								$wwwrooturl$path2dir$delim$val
								</td>
								</tr>
						";
						else $mp3info = "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=img>
								<p align=left>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($fsize) $new
								</p>
								<p align=left>
								<table width=100% cellpadding=5 cellspacing=0><tr><td width=100% onMouseOver=this.style.backgroundColor='#d3e1eb' onMouseOut=this.style.backgroundColor=''><a href=\"$wwwrooturl$encodedurl\" target=image class=src>
								Title : $thumbsrc[1]<br>
								Artist : $thumbsrc[2]<br>
								Album : $thumbsrc[3]<br>
								Year : $thumbsrc[4]<br>
								Comment : $thumbsrc[5]<!--<br>
								Genre : $thumbsrc[6] -->
								</a></td></tr></table>
								</p>
								<p align=left><nobr>
								$wwwrooturl$path2dir$delim$val
								</p>
								</td>
								</tr>
						";
						echo  "$mp3info"; 
						}

						else {
						$filecnt++;
						$new = update("$wwwrootpath$delim$path2dir$delim$val");
						echo "
								<tr>
								<td width=100 align=right valign=middle class=ext><nobr><b>$ext</b></td>
								<td width=480 align=left class=ext><nobr>
								<a href=\"$wwwrooturl$encodedurl\" target=image>$val</a> ($fsize) $new<br>
								$wwwrooturl$path2dir$delim$val
								</td>
								</tr>
						";
						}
					} 

}
}

echo  "
			</table>
";

$jmp = 20;
$end_jmp = ceil($page / $jmp) * $jmp;
$start_jmp = $end_jmp - $jmp;

if($end_jmp > $totalpage) $end_jmp = $totalpage;

if($previous > 0)
echo "<br><a href=$PHP_SELF?path=$path&page=$previous&order=$order>< previous $cut items ></a>
";
elseif($totalpage <= 1)
echo "";
else
echo "<br><a href=$PHP_SELF?path=$path&page=$totalpage&order=$order>< go to the end ></a>
";

for($i = $start_jmp + 1 ; $i < $end_jmp + 1; $i++){
if($totalpage <= 1) echo "";
elseif($i == $page) echo "<font class=title>$i</font>
";
else echo "<a href=$PHP_SELF?path=$path&page=$i&order=$order> $i </a>
";
}

if($next <= $totalpage)
echo "<a href=$PHP_SELF?path=$path&page=$next&order=$order>< next $cut items ></a>
";
elseif($totalpage <= 1)
echo "";
else
echo "<a href=$PHP_SELF?path=$path&page=1&order=$order>< go to the first ></a>
";


if(!$dircnt) $dircount = "no directories";
else $dircount = "$dircnt directories";
if(!$imgcnt) $imgcount = "no images";
else $imgcount = "$imgcnt images";			
if(!$filecnt) $filecount = "no other files";
else $filecount = "$filecnt other files";

echo  "
			<br>
			( $dircount / $imgcount / $filecount )<br><br>
			<a href=http://ardor.net target=_blank>IMAGE SCANNER 1.28</a> by <a href=mailto:ardor@chol.com>kion</a>, 2003
			</p>
			
			</body>
			</html>
"; 

?>