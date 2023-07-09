<?
if ($flag != $_SERVER[HTTP_HOST]) die("비정상적인 입력은 허용되지 않습니다.");
include "include/manager_header.inc.php";
include "{$vg_mailing_dir_info['include']}post_var_filter.inc.php";

$save_dir = $vg_mailing_dir_info[contents];
switch ($mode) {
	case "upload" :
		$file_ext = array("txt");
		$lh_common->file_upload("mail_contents_file", '', $file_ext, 'T', $save_dir, '');
		$lh_common->meta_url($vg_mailing_file[mail_form]);
	break;
	case "delete" :
		$delete_file_name_full = $save_dir . $delete_file_name;
		unlink($delete_file_name_full);
		$lh_common->meta_url($vg_mailing_file[mail_form]);
	break;
}

?>