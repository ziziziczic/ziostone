<?

// ���׷��̵� ������ ��ȯ
$root = "../";

require_once "{$root}include/db.php";
require_once "{$root}include/library.class.php";

$lib_handle = new library();

$add_record = "Y";	// ���� �Ź��� �ִ°��(��� �о�Ϸ� ��Ű��, �������ʵ� ���ŵ� �Ź����̺��� ��°�� ���� �ؾ���, MAMUL_BACKUP_2)
if ($add_record == "Y") {
	$query = "select * from BACKUP_MAMUL order by sign_date asc";
	$result = @mysql_query($query) or die("��� �Ź� ���� ������ ����<br>" . mysql_error());
	while ($value = mysql_fetch_array($result)) {
		$value[name] = addslashes($value[name]);
		$value[email] = addslashes($value[email]);
		$value[phone] = addslashes($value[phone]);
		$value[subject] = addslashes($value[subject]);

		$value[comment_1] = str_replace("\\", "", $value[comment_1]);
		$value[comment_1] = str_replace("'", "", $value[comment_1]);
		$value[comment_1] = str_replace("\"", "", $value[comment_1]);
		$value[comment_1] = addslashes($value[comment_1]);
		$value[comment_1] = $lib_handle->replace_cr($value[comment_1], "\\r\\n");

		$value[comment_2] = str_replace("\\", "", $value[comment_2]);
		$value[comment_2] = str_replace("'", "", $value[comment_2]);
		$value[comment_2] = str_replace("\"", "", $value[comment_2]);
		$value[comment_2] = addslashes($value[comment_2]);
		$value[comment_2] = $lib_handle->replace_cr($value[comment_2], "\\r\\n");

		$query = "insert into MAMUL_BACKUP_2 values(0, '$value[fid]', '$value[name]', '$value[email]', '$value[phone]', '$value[homepage]', '$value[subject]', '$value[comment_1]', '$value[comment_2]', '', '$value[sign_date]', '$value[count]', '$value[thread]', '', '$value[user_ip]', '', '', '', '$value[category_1]', '$value[category_2]', '$value[category_3]', '$value[writer_id]', '$value[type]', '$value[is_view]', '$value[is_notice]', '$value[is_html]', '$value[is_private]', '', '$value[etc_1]', '$value[etc_2]', '$value[etc_3]')";
		$insert_result = @mysql_query($query) or die("Ÿ�� �Ź� �Է� ������ ����<br>" . mysql_error());
	}
	$real_source_table = "MAMUL_BACKUP_2";
}
// ���� �Ź� ó�� �Ϸ�

// ���� ����� �Ź� ���̺� ��������
$target_table = "
	CREATE TABLE `TCBOARD_513` (
	  `serial_num` mediumint(10) unsigned NOT NULL auto_increment,
	  `fid` mediumint(10) unsigned NOT NULL default '0',
	  `name` varchar(150) NOT NULL default '',
	  `email` varchar(150) default NULL,
	  `phone` varchar( 14 ) NOT NULL,
	  `homepage` varchar(150) default NULL,
	  `subject` varchar(200) NOT NULL,
	  `comment_1` text NOT NULL,
	  `comment_2` varchar(255) NOT NULL default '',
	  `passwd` varchar(30) NOT NULL default '',
	  `sign_date` int(10) unsigned NOT NULL default '0',
	  `count` mediumint(5) NOT NULL default '0',
	  `thread` varchar(255) NOT NULL default '',
	  `reply_answer` char(1) NOT NULL default 'N',
	  `user_ip` varchar(16) default NULL,
	  `user_file` varchar(255) default NULL,
	  `file_size` int(10) unsigned default '0',
	  `vote` int(5) unsigned default '0',
	  `category_1` varchar(100) default NULL,
	  `category_2` varchar(50) NOT NULL default '',
	  `category_3` varchar(50) NOT NULL default '',
	  `writer_id` varchar(20) default '',
	  `type` varchar(200) NOT NULL default '',
	  `is_view` char(1) NOT NULL default 'Y',
	  `is_notice` char(1) NOT NULL default '',
	  `is_html` char(1) NOT NULL default 'N',
	  `is_private` char(1) default 'N',
	  `relation_serial` mediumint(10) NOT NULL default '0',
	  `etc_1` varchar(20) NOT NULL default '',
	  `etc_2` char(1) NOT NULL default '',
	  `etc_3` char(1) NOT NULL default '',
	  PRIMARY KEY  (`serial_num`)
	)
";
$result = mysql_query($target_table) or die("���� �Ź� ���̺� ���� ���� �� ����<br>" . mysql_error());

$query = "select * from $real_source_table order by sign_date asc";
$result = @mysql_query($query) or die("���� �Ź� ���� ������ ����<br>" . mysql_error());
$i = 1;
while ($value = mysql_fetch_array($result)) {
	$query = "insert into TCBOARD_513 values(0, '$i', '$value[name]', '$value[email]', '$value[phone]', '$value[homepage]', '$value[subject]', '$value[comment_1]', '$value[comment_2]', '', '$value[sign_date]', '$value[count]', '$value[thread]', '', '$value[user_ip]', '', '', '', '$value[category_1]', '$value[category_2]', '$value[category_3]', '$value[writer_id]', '$value[type]', '$value[is_view]', '$value[is_notice]', '$value[is_html]', '$value[is_private]', '', '$value[etc_1]', '$value[etc_2]', '$value[etc_3]')";
	$insert_result = @mysql_query($query) or die("Ÿ�� �Ź� �Է� ������ ����<br>" . mysql_error());
	$i++;
}

echo("�Ϸ� �Ǿ����ϴ�.");

?>





