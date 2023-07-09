<?
$gallery_i = 1;
$image_set = "";
if ($dir_handle = opendir($gallery_img_dir)) {
	while(false !== ($file = readdir($dir_handle))) {	
		if ($file != "." && $file != "..") {
			if ($gallery_i == 1) $first_img_src = "{$gallery_img_dir}/{$file}";
			$image_set .= "
				var img{$gallery_i} = new Image(); 
				img{$gallery_i}.src = '{$gallery_img_dir}/{$file}'; 

			";
			$gallery_i++;
		} 
	}
}
$gallery_i--;
if ($image_set == "") {
	$lib_handle->popup_msg('죄송합니다. 등록된 이미지가 없습니다.');
	echo("<script>window.close()</script>");
	exit;
}
?>
<script language="JavaScript1.2"> 
<!-- 
<?echo($image_set)?>
var maxLoops = <?echo($gallery_i)?>; 
var bInterval = 2; 
var count = 1; 
function init() { 
	blendtrjs.filters.blendTrans.apply(); 
	document.images.blendtrjs.src = eval("img"+count+".src"); 
	blendtrjs.filters.blendTrans.play(); 
	if (count < maxLoops) count++; 
	else count = 1; 
	setTimeout("init()", bInterval*700+2000); 
} 

//--> 
</script>
<img src="<?echo($first_img_src)?>" name="blendtrjs" border="0" style="filter: blendTrans(duration=2)">
<script language="JavaScript1.2">init();</script>