<?php

	//copy from api.function.php
	function get_full_info_by_email_password( $email , $password )
	{
		$table = real_table_name('user');
		$sql = "SELECT * FROM `".$table."` WHERE `email` = '" . s( $email ) . "' LIMIT 1";
		if(!$line = get_line( $sql )) return false;

		$ret = false;
		
		//$passwordv2 = ttpassv2($line['id']);
		$passwordv2 = ttpassv2( $password ,  $line['id']);

		if( strlen( $line['password'] ) == 32 )
		{
			// old password format 
			$passwordv1 = md5( $password  );

			if( $passwordv1 == $line['password'] ) $ret = $line;

			// change to new password
			$sql = "UPDATE `".$table."` SET `password` = '" . s( $passwordv2 ) . "' WHERE `id` = '" . intval( $line['id'] ) . "' LIMIT 1";
			run_sql( $sql );

		}elseif( strlen( $line['password'] ) == 30 )
		{
			if( $passwordv2 == $line['password'] ) $ret = $line;
		}

		return $ret; 
	}

//end.
