<?php

function get_favorites_uuid_rel_count( $uid,$cat,$uuid )
{
	$table = real_table_name('favorites_uuid_rel');

	// SELECT count(*) as num FROM favorites_uuid_rel WHERE uid=0 and category=1 and uuid='63485fdec802b19b8c9e13e46f45d76a'

	$tmp_sql = prepare('SELECT count(*) as num FROM `'.$table.'` WHERE is_his=0 AND uid=?s and category=?s and uuid=?s ' ,array($uid,intval($cat),$uuid)); 
	$data = get_var($tmp_sql);	
	return $data;
}


function add_favorites_uuid_rel( $uid,$cat,$uuid )
{
	$table = real_table_name('favorites_uuid_rel');
	$cf_now = date('Y-m-d H:i:s');
	$tmp_sql = prepare('INSERT INTO `'.$table.'`( `uid`, `is_his`, `category`, `uuid`, `value`) VALUES ( ?s,?s,?s,?s,?s ) ' ,array($uid,0,intval($cat),$uuid,$cf_now)); 
	return run_sql($tmp_sql);
}

function del_favorites_uuid_rel( $uid,$cat,$uuid )
{
	$table = real_table_name('favorites_uuid_rel');
	$cf_now = date('Y-m-d H:i:s');
	$tmp_sql = prepare('UPDATE `'.$table.'` SET `is_his`=1,`value`=CONCAT(value,?s) WHERE `is_his`=0 AND `uid`=?s AND `category`=?i AND `uuid`=?s limit 1' ,array(' '.$cf_now,$uid,intval($cat),$uuid));  
	return run_sql($tmp_sql);
}

//end.
