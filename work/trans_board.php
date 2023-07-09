<?
$Root = "./";
$Design_Root = "./design/";
$Designer_Root = "./Designer/";

require_once "{$Root}Common/db.php";
require_once "{$Root}Common/class_library.php";

$libHandle = new library();
// 질문과답변, 공지사항, 직거래 게시판 순
$table_array = array("TCBOARD_MAIN_731b"=>"TCBOARD_492", "TCBOARD_MAIN_732b"=>"TCBOARD_441", "TCBOARD_MAIN_733b"=>"TCBOARD_506", "TCBOARD_MAIN_6N"=>"TCBOARD_542");

while(list($source_table, $target_table) = each($table_array)) {

	$table_query = "
		CREATE TABLE `$target_table` (
			`serial_num` mediumint(10) unsigned NOT NULL auto_increment,
			`fid` mediumint(10) unsigned NOT NULL default '0',
			`name` varchar(150) NOT NULL default '',
			`email` varchar(150) default NULL,
		   `phone` varchar(14) NOT NULL,
			`homepage` varchar(150) default NULL,
			`subject` text NOT NULL,
			`comment_1` text NOT NULL,
			`comment_2` char(1) NOT NULL default '',
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
			`etc_1` char(1) NOT NULL default '',
			`etc_2` char(1) NOT NULL default '',
			`etc_3` char(1) NOT NULL default '',
			PRIMARY KEY  (`serial_num`)
		)
	";

	$result = mysql_query($table_query) or die("타겟테이블 생성 쿼리 중 에러<br>" . mysql_error());

	$query = "select * from $source_table";
	$result = @mysql_query($query) or die("원본 매물 추출 쿼리중 에러<br>" . mysql_error());



	while ($value = mysql_fetch_array($result)) {
		
		if ($value[is_html] == 'y') $value[is_html] = 'Y';
		else $value[is_html] = '';
		if ($value[is_private] == 'y') $value[is_private] = 'Y';
		else $value[is_private] = '';

		$value[name] = addslashes($value[name]);
		$value[email] = addslashes($value[email]);
		$value[subject] = addslashes($value[subject]);
		$value[comment] = addslashes($value[comment]);
		$value[comment] = $libHandle->replaceCR($value[comment], "\\r\\n");
		$query = "insert into $target_table values(0, '$value[fid]', '$value[name]', '$value[email]', '', '$value[homepage]', '$value[subject]', '$value[comment]', '', '', '$value[signdate]', '$value[count]', '$value[thread]', '', '', '', '', '', '$value[category]', '', '', '', '', '', '', '$value[is_html]', '$value[is_private]', '', '', '', '')";
		$insert_result = @mysql_query($query) or die("타겟 매물 입력 쿼리중 에러<br>" . mysql_error());
	}
}
echo("완료 되었습니다.");

?>