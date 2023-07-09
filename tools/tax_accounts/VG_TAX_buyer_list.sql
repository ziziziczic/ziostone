CREATE TABLE `VG_TAX_buyer_list` (
  `serial_num` mediumint(5) unsigned NOT NULL auto_increment,
  `buyer_id` varchar(15) NOT NULL default '',
  `biz_number` varchar(10) NOT NULL default '',
  `biz_name` varchar(50) NOT NULL default '',
  `biz_ceo` varchar(20) NOT NULL default '',
  `biz_address` varchar(100) NOT NULL default '',
  `biz_cond` varchar(50) NOT NULL default '',
  `biz_type` varchar(50) NOT NULL default '',
  `biz_email` varchar(50) NOT NULL default '',
  `biz_fax` varchar(20) NOT NULL default '',
  `biz_inc` char(1) NOT NULL default '',
  `sign_date` int(10) NOT NULL default '0',
  PRIMARY KEY  (`serial_num`),
  UNIQUE KEY `biz_number` (`biz_number`)
) TYPE=MyISAM COMMENT='사업자정보' AUTO_INCREMENT=3 ;
