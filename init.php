<?
	include('config.php');

	mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
	mysql_select_db(MYSQL_DB);

	function dumper($foo){
		echo "<pre style=\"text-align: left;\">";
		echo HtmlSpecialChars(var_export($foo, 1));
		echo "</pre>\n";
	}

	function db_update($table, $hash, $where){

		$bits = array();
		foreach(array_keys($hash) as $k){
			$bits[] = "`$k`='$hash[$k]'";
		}

		return mysql_query("UPDATE $table SET ".implode(', ',$bits)." WHERE $where");
	}

	function db_insert_ignore($table, $hash){

		$fields = array_keys($hash);
		$sql = "INSERT IGNORE INTO $table (`".implode('`,`',$fields)."`) VALUES ('".implode("','",$hash)."')";
		mysql_query($sql);
	}
