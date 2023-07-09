CREATE TABLE `VG_TAX_tax_list` (
  `serial_num` mediumint(5) unsigned NOT NULL auto_increment,
  `biz_a_name` varchar(50) NOT NULL default '',
  `biz_a_number` varchar(10) NOT NULL default '',
  `biz_a_ceo` varchar(20) NOT NULL default '',
  `biz_a_address` varchar(100) NOT NULL default '',
  `biz_a_cond` varchar(50) NOT NULL default '',
  `biz_a_type` varchar(50) NOT NULL default '',
  `biz_b_serial` mediumint(5) unsigned NOT NULL default '0',
  `biz_b_name` varchar(50) NOT NULL default '',
  `biz_b_number` varchar(10) NOT NULL default '',
  `biz_b_ceo` varchar(20) NOT NULL default '',
  `biz_b_address` varchar(100) NOT NULL default '',
  `biz_b_cond` varchar(50) NOT NULL default '',
  `biz_b_type` varchar(50) NOT NULL default '',
  `biz_b_email` varchar(50) NOT NULL default '',
  `biz_b_fax` varchar(20) NOT NULL default '',
  `biz_issue_date` int(10) unsigned NOT NULL default '0',
  `biz_goods` varchar(100) NOT NULL default '',
  `biz_amount` int(12) unsigned NOT NULL default '0',
  `biz_receipt` char(1) NOT NULL default '',
  `biz_tax_inc` char(1) NOT NULL default '',
  `biz_tax_count` tinyint(2) NOT NULL default '0',
  `sign_date` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`serial_num`)
) TYPE=MyISAM COMMENT='발급계산서목록' AUTO_INCREMENT=21 ;
