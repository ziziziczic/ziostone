<?
// ������, ����� �з��� ���� ��ȯ �ϴ� ���α׷�
$Root = "./";
$Design_Root = "./design/";
$Designer_Root = "./Designer/";

require_once "{$Root}Common/db.php";
require_once "{$Root}Common/class_library.php";

$libHandle = new library();

$target_table = "
CREATE TABLE `MAMUL_BACKUP` (
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
$result = mysql_query($target_table) or die("�Ź����_1 ���̺� ���� ���� �� ����<br>" . mysql_error());
$real_source_table = "MAMUL_BACKUP";

// ������
$source_table = "TCBOARD_MAIN_10N";
$query = "select * from $source_table";
$result = @mysql_query($query) or die("������ �Ź� ���� ������ ����<br>" . mysql_error());

while ($value = mysql_fetch_array($result)) {
	$value[comment] = str_replace("\\", "", $value[comment]);
	$value[comment] = str_replace("'", "", $value[comment]);
	$value[comment] = str_replace("\"", "", $value[comment]);
	$value[comment] = addslashes($value[comment]);
	$value[comment] = $libHandle->replaceCR($value[comment], "\\r\\n");

	$value[comment2] = str_replace("\\", "", $value[comment2]);
	$value[comment2] = str_replace("'", "", $value[comment2]);
	$value[comment2] = str_replace("\"", "", $value[comment2]);
	$value[comment2] = addslashes($value[comment2]);
	$value[comment2] = $libHandle->replaceCR($value[comment2], "\\r\\n");


	$value[name] = addslashes(strip_tags($value[name]));
	$value[email] = addslashes($value[email]);
	$value[subject] = addslashes($value[subject]);
	
	if ($value[category] == "���������") {
		$category_2 = "�����";
		$value[category] = "";
	} else {
		$category_2 = "������";
	}

	$query = "insert into MAMUL_BACKUP values(0, '$value[fid]', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment]', '$value[comment2]', '', '$value[signdate]', '$value[count]', '$value[thread]', '', '', '', '', '', '$value[category]', '$category_2', '�Ϲ�', '', '', '', '', 'Y', '', '', '', '', '')";
	$insert_result = @mysql_query($query) or die("Ÿ�� �Ź� �Է� ������ ����<br>" . mysql_error());
}
/*
// �����
$source_table = "TCBOARD_MAIN_733b";
$query = "select * from $source_table";
$result = @mysql_query($query) or die("�����  �Ź� ���� ������ ����<br>" . mysql_error());

while ($value = mysql_fetch_array($result)) {
	$value[comment] = str_replace("\\", "", $value[comment]);
	$value[comment] = str_replace("'", "", $value[comment]);
	$value[comment] = str_replace("\"", "", $value[comment]);
	$value[comment] = str_replace("width=345", "width=100%", $value[comment]); 

	$value[name] = addslashes($value[name]);
	$value[email] = addslashes($value[email]);
	$value[subject] = addslashes($value[subject]);
	$value[comment] = addslashes($value[comment]);
	$value[comment] = $libHandle->replaceCR($value[comment], "\\r\\n");
	$query = "insert into MAMUL_BACKUP values(0, '$value[fid]', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment]', '', '', '$value[signdate]', '$value[count]', '$value[thread]', '', '', '', '', '', '', '�����', '�Ϲ�', '', '', '', '', 'Y', '', '', '', '', '')";
	$insert_result = @mysql_query($query) or die("Ÿ�� �Ź� �Է� ������ ����<br>" . mysql_error());
}
// Ÿ�� Ȩ������ �Ź� �����Ϸ�
*/
$add_record = "N";	// ���� �Ź��� �ִ°��(��� �о�Ϸ� ��Ű��, �������ʵ� ���ŵ� �Ź����̺��� ��°�� ���� �ؾ���, MAMUL_BACKUP_2)
if ($add_record == "Y") {
	$query = "select * from MAMUL_BACKUP order by sign_date asc";
	$result = @mysql_query($query) or die("��� �Ź� ���� ������ ����<br>" . mysql_error());
	while ($value = mysql_fetch_array($result)) {
		$value[name] = addslashes($value[name]);
		$value[email] = addslashes($value[email]);
		$value[subject] = addslashes($value[subject]);
		$value[comment_1] = addslashes($value[comment_1]);
		$value[comment_1] = $libHandle->replaceCR($value[comment_1], "\\r\\n");
		$query = "insert into MAMUL_BACKUP_2 values(0, '$value[fid]', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment_1]', '$value[comment_2]', '', '$value[sign_date]', '$value[count]', '$value[thread]', '', '', '', '', '', '$value[category_1]', '$value[category_2]', '$value[category_3]', '', '', '', '', 'Y', '', '', '', '', '')";
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
	$value[subject] = addslashes($value[subject]);
	$value[comment_1] = addslashes($value[comment_1]);
	$query = "insert into TCBOARD_513 values(0, '$i', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment_1]', '$value[comment_2]', '', '$value[sign_date]', '$value[count]', '$value[thread]', '', '', '', '', '', '$value[category_1]', '$value[category_2]', '$value[category_3]', '', '', '', '', 'Y', '', '', '', '', '')";
	$insert_result = @mysql_query($query) or die("Ÿ�� �Ź� �Է� ������ ����<br>" . mysql_error());
	$i++;
}

echo("�Ϸ� �Ǿ����ϴ�.");

?>





