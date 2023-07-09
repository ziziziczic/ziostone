<?
	// class.tree.php3 v1.01
        // (c) 1999, 2000, 2001 Patrick Hess <hess@posi.de>

	class Tree {
		var $tree_basefrm = "_top";
		var $tree_gbase;

		// internal data
		var $tree_path;
		var $tree_count = 1;
		var $usetextlinks = true;
		var $startallopen = false;

		function Tree ($t_path = "class.tree") 
		{
			$this->tree_path = $t_path;
		}

  		function set_frame ($t_frame)
  		// (c) Gildas LE NADAN, 10 march 2000
  		// This method should be called before method open_tree
  		// if you want to change the default target frame
		{
			$this->tree_basefrm = $t_frame;
		}

		function set_textlinks ($tlval)
		{
			$this->usetextlinks = $tlval;
		}
		function set_startallopen ($saaval)
		{
			$this->startallopen = $saaval;
		}

		function open_tree ($t_text, $t_url, $t_frame="", 
				    $t_gbase="ftv2")
		{
			$this->tree_gbase = $t_gbase;
			$tree_ftv2blank = "$this->tree_gbase/ftv2blank.gif";
			$tree_ftv2doc = "$this->tree_gbase/ftv2doc.gif";
			$tree_ftv2folderclosed = "$this->tree_gbase/ftv2folderclosed.gif";
			$tree_ftv2folderopen = "$this->tree_gbase/ftv2folderopen.gif";
			$tree_ftv2lastnode = "$this->tree_gbase/ftv2lastnode.gif";
			$tree_ftv2link = "$this->tree_gbase/ftv2link.gif";
			$tree_ftv2mlastnode = "$this->tree_gbase/ftv2mlastnode.gif";
			$tree_ftv2mnode = "$this->tree_gbase/ftv2mnode.gif";
			$tree_ftv2node = "$this->tree_gbase/ftv2node.gif";
			$tree_ftv2plastnode = "$this->tree_gbase/ftv2plastnode.gif";
			$tree_ftv2pnode = "$this->tree_gbase/ftv2pnode.gif";
			$tree_ftv2vertline = "$this->tree_gbase/ftv2vertline.gif";
   			if($t_frame) {
    				$this->tree_basefrm = $t_frame;
   			}

			echo "<script>\n";

			if ($this->usetextlinks) echo "var USETEXTLINKS = 1;\n";
   			else                     echo "var USETEXTLINKS = 0;\n";

   			if ($this->startallopen) echo "var STARTALLOPEN = 1;\n";
   			else                     echo "var STARTALLOPEN = 0;\n";

?>
classPath = <? echo "\"$this->tree_path\";\n"; ?>
ftv2blank = <? echo "\"$tree_ftv2blank\""; ?>;
ftv2doc = <? echo "\"$tree_ftv2doc\""; ?>;
ftv2folderclosed = <? echo "\"$tree_ftv2folderclosed\""; ?>;
ftv2folderopen = <? echo "\"$tree_ftv2folderopen\""; ?>;
ftv2lastnode = <? echo "\"$tree_ftv2lastnode\""; ?>;
ftv2link = <? echo "\"$tree_ftv2link\""; ?>;
ftv2mlastnode = <? echo "\"$tree_ftv2mlastnode\""; ?>;
ftv2mnode = <? echo "\"$tree_ftv2mnode\""; ?>;
ftv2node = <? echo "\"$tree_ftv2node\""; ?>;
ftv2plastnode = <? echo "\"$tree_ftv2plastnode\""; ?>;
ftv2pnode = <? echo "\"$tree_ftv2pnode\""; ?>;
ftv2vertline = <? echo "\"$tree_ftv2vertline\""; ?>;
basefrm = <? echo "\"$this->tree_basefrm\""; ?>;
</script>
<script src=<?	echo "\"$this->tree_path/ua.js\""; ?> type="text/javascript">
</script>
<script src=<?	echo "\"$this->tree_path/ftiens4.js\""; ?> type="text/javascript"></script>
<script>
<?			echo "\n";

			$jsvn = "foldersTree";
			echo "$jsvn = gFld(\"$t_text\", \"$t_url\");\n";
			return ($jsvn);
		}

		function add_folder ($t_parent, $t_text, $t_url) 
		{  
			$jsvn = "aux".$this->tree_count;
			$this->tree_count++;
			echo "$jsvn = insFld($t_parent, gFld (\"$t_text\", ";
			echo "\"$t_url\"));\n";
			return ($jsvn);
		}		

		function add_document ($t_parent, $t_text, $t_url, $t_value, $t_num, $t_name, $t_method) 
		{ 
			echo "insDoc($t_parent, gLnk ($t_parent, \"$t_text\", ";
			echo "\"$t_url\", \"$t_value\", \"$t_num\", \"$t_name\", \"$t_method\"));\n";
		}	

		function close_tree ( )
		{
			echo "\ninitializeDocument();\n</script>";
		}
	}

?>

