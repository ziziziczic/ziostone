<?
// 톤수별로 각각 따로 있는 경우, 지방권은 다른 테이블에 있는 경우
$Root = "./";
require_once "{$Root}Common/db.php";
require_once "{$Root}Common/class_library.php";

$libHandle = new library();

$target_table = "
CREATE TABLE MAMUL_BACKUP (
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
$result = mysql_query($target_table) or die("타겟테이블 생성 쿼리 중 에러<br>" . mysql_error());

$source_table_name = "TCBOARD_koreajiib_19b ";

$query = "select * from $source_table_name";
$result = mysql_query($query) or die("매물 소스 추출 쿼리 중 에러<br>" . mysql_error());

while($value = mysql_fetch_array($result)) {	
	
	$value[name] = addslashes($value[name]);
	$value[email] = addslashes($value[email]);
	$value[subject] = addslashes($value[subject]);

	$value[comment] = str_replace("\\", "", $value[comment]);
	$value[comment] = str_replace("'", "", $value[comment]);
	$value[comment] = str_replace("\"", "", $value[comment]);
	$value[comment] = addslashes($value[comment]);
	$value[comment] = $libHandle->replaceCR($value[comment], "\\r\\n");

	$value[comment_2] = str_replace("\\", "", $value[comment_2]);
	$value[comment_2] = str_replace("'", "", $value[comment_2]);
	$value[comment_2] = str_replace("\"", "", $value[comment_2]);
	$value[comment_2] = addslashes($value[comment_2]);
	$value[comment_2] = $libHandle->replaceCR($value[comment_2], "\\r\\n");

	if ($value[category] == "지방권정보") {
		$category_1 = '';
		$category_2 = "지방권";
	} else {
		$category_1 = $value[category];
		$category_2 = "수도권";
	}

	$category_3 = "일반";
	$query = "insert into MAMUL_BACKUP values(0, '0', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment]', '$value[comment2]', '', '$value[signdate]', '$value[count]', '$value[thread]', '', '', '', '', '', '$category_1', '$category_2', '$category_3', '$value[writer_id]', '$value[type]', '$value[is_view]', '$value[is_notice]', '$value[is_html]', '$value[is_private]', '', '', '', '')";
	$insert_result = @mysql_query($query) or die("타겟 매물 입력 쿼리중 에러<br>" . mysql_error());
}

// 실제 사용할 매물 테이블 생성시작
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
$result = mysql_query($target_table) or die("실제 매물 테이블 생성 쿼리 중 에러<br>" . mysql_error());

$query = "select * from MAMUL_BACKUP order by sign_date asc";
$result = @mysql_query($query) or die("최종 매물 추출 쿼리중 에러<br>" . mysql_error());
$i = 1;
while ($value = mysql_fetch_array($result)) {
	$value[subject] = addslashes($value[subject]);
	$value[comment_1] = addslashes($value[comment_1]);
	$query = "insert into TCBOARD_513 values(0, '$i', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment_1]', '$value[comment_2]', '', '$value[sign_date]', '$value[count]', '$value[thread]', '', '', '', '', '', '$value[category_1]', '$value[category_2]', '$value[category_3]', '$value[writer_id]', '$value[type]', '$value[is_view]', '$value[is_notice]', '$value[is_html]', '$value[is_private]', '', '', '', '')";
	$insert_result = @mysql_query($query) or die("타겟 매물 입력 쿼리중 에러<br>" . mysql_error());
	$i++;
}


echo("완료 되었습니다.");

?>