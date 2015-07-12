<?php

	//defined('ROOT') or die('');
	
	define('db_host','localhost');
	define('db_user','root');
	define('db_pass','');
	define('db_name','sigeod_db');
	
	mysql_connect(db_host,db_user,db_pass);
	mysql_select_db(db_name);
	
?>
