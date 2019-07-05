<?php

if( !defined('AROOT') ) die('NO AROOT!');
if( !defined('DS') ) define( 'DS' , DIRECTORY_SEPARATOR );

// define constant
define( 'IN' , true );

function init_return_array()
{
	$ret = array('return_code' =>0,'return_message' =>'','total_count'=>0,'datas'=>'null');
	return $ret;
}

function a_title_html($name,$title){
	return '<a href="javascript:void(0);" title="'.$title.'">'.$name.'</a>';
}

function fix_sql_filed($search, $replace, $subject){
	$replace = "'" .$replace. "'";
	return str_ireplace($search, $replace, $subject);
}

function kis_cmp_intval($var1,$var2){
	if($var1==$var2){
		return 0;
	}else{
		return $var1<$var2 ? -1 : 1;
	}
}

function unescape($str) { //定义unescape函数
	$str = urldecode($str);
	preg_match_all("/(?:%u.{4}|&#x.;|&#d+;|.+)/U",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v) {
		if(substr($v,0,2) == "%u"){
			$ar[$k] = iconv("UCS-2BE","utf-8",pack("H4",substr($v,-4)));
		}elseif(substr($v,0,3) == "&#x"){
			$ar[$k] = iconv("UCS-2BE","utf-8",pack("H4",substr($v,3,-1)));
		}elseif(substr($v,0,2) == "&#"){
			$ar[$k] = iconv("UCS-2BE","utf-8",pack("n",substr($v,2,-1)));
		}
	}
	return join("",$ar);
}

function func_str_compress($string){
	if(strlen($string)<500){
		return $string;
	}
	// echo 'DEBUG,' . __FUNCTION__ . '() Original size:' . strlen($string).PHP_EOL;
	$compressed=gzcompress($string);
	// echo 'DEBUG,' . __FUNCTION__ . '() Compressed size:' . strlen($compressed).PHP_EOL;

	if($compressed!==false){
		// echo 'DEBUG,' . __FUNCTION__ . '() Original str:' . $string.PHP_EOL;
		// echo 'DEBUG,' . __FUNCTION__ . '() Compressed str:' .$compressed.PHP_EOL;
		// $original = gzuncompress($compressed);
		// echo 'DEBUG,' . __FUNCTION__ . '() UN Compressed str:' .$original.PHP_EOL;
		$base64_str = base64_encode($compressed);
		// echo 'DEBUG,' . __FUNCTION__ . '() base64_encode str:' .$base64_str.PHP_EOL;

		if(strlen($string)>strlen($base64_str)){
			return $base64_str;
		}
		
	}
	return $string;
}

function func_str_un_compress($string){
	if(strlen($string)<500){
		return $string;
	}
	// echo 'DEBUG,' . __FUNCTION__ . '() base64_encode size:' . strlen($string).PHP_EOL;
	// echo 'DEBUG,' . __FUNCTION__ . '() base64_encode str:' .$string.PHP_EOL;
	$compressed = base64_decode($string);

	// echo 'DEBUG,' . __FUNCTION__ . '() base64_decode size:' . strlen($compressed).PHP_EOL;
	// echo 'DEBUG,' . __FUNCTION__ . '() base64_decode str:' .$compressed.PHP_EOL;

	if($compressed==false){
		$compressed=$string;
		echo __FUNCTION__.'() skip base64_decode!';
	}
	// 
	// echo 'DEBUG,' . __FUNCTION__ . '() Compressed size:' . strlen($compressed).PHP_EOL;
	// echo 'DEBUG,' . __FUNCTION__ . '() Compressed str:' .$compressed.PHP_EOL;
	$original = gzuncompress($compressed);
	// echo 'DEBUG,' . __FUNCTION__ . '() Original size:' . strlen($original).PHP_EOL;
	// echo 'DEBUG,' . __FUNCTION__ . '() Original str:' . $original.PHP_EOL;
	// mini_debug($original);
	if($original!==false){
		return $original;
	}else{
		return false;
	}
	// return $string;
}

function get_count_kv_sql($api_id,$app_sql){
	$ret=array();
	$ret['count']=0;
	$ret['message']='';
	$ret['sql']=$app_sql;

	$kv_key = 'civitas_'.$api_id.'_count';
	$value=kget($kv_key);
	$v = intval($value);
	if($v>0) {
		$ret['count']=$v;
		$ret['message']='read kv.'.$kv_key .' ok !';
		$count = $v-1;
		kset($kv_key,$count);
		return $ret;
	}

	$count_sql = 'SELECT COUNT(*) AS num FROM ( ' . PHP_EOL . $app_sql . PHP_EOL . ') kstmp ';
	$count = get_var($count_sql);
	$ret['count']=intval($count);

	kset($kv_key,$count);

	if($count>0){		
		$ret['message'] ='read sql.count ok ! #'.$count . ' save kv ok !';
	}else{
		$ret['message']='read sql.count ok ! #'.$count;
	}
	return $ret;
}


function get_sql_count_info($app_sql){
	$ret=array();
	$ret['count']=0;
	$ret['message']='';
	$ret['sql']=$app_sql;

	$count_sql = 'SELECT COUNT(*) AS num FROM ( ' . PHP_EOL . $app_sql . PHP_EOL . ') kstmp ';
	$count = get_var($count_sql);
	$ret['count']=intval($count);
	$ret['message']='read sql.count ok ! #'.$count;
	return $ret;
}


function check_api_enable($api){
	// $ret = array();
	// $ret['api']=strtolower($api);
	$kv_key = 'shdic_api_'.strtolower($api);
	$value=kget($kv_key);
	if(empty($value)){
		kset($kv_key,'1');	//default value
		// $ret['message']=$kv_key .' init!';
		// $ret['result']=true;
		return true;
	}
	$v = intval($value);
	if($v==0){ 
		// $ret['message']=$kv_key .' NOT !';
		// $ret['result']=false;
		return false;
	}
	return true;
}

function debug_log($app,$msg){
	global $debug_log_table;
	if($debug_log_table==null){
		init_debug_log_table();
	}
	$cf1 = date('Y-m-d H:i:s');
	$sql =prepare(" INSERT INTO `shdic_crx_debug_log_table` ( `app`, `cf1`, `log`) VALUES (?s,?s,?s) "
		,array($app,$cf1,$msg));
	return run_sql($sql);
}

$debug_log_table=null;

function init_debug_log_table(){
	global $debug_log_table;

	//初始化数据库
	if(!get_data("SHOW TABLES LIKE 'shdic_crx_debug_log_table'")){
      
    	run_sql(" 
CREATE TABLE IF NOT EXISTS `shdic_crx_debug_log_table` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cf1` char(20) NOT NULL COMMENT '创建时间',
  `app` char(16) NOT NULL,
  `log` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    	");
	}

	$debug_log_table='shdic_crx_debug_log_table';
}


function tag_val(&$arr,$tag){
	return isset( $arr[$tag] ) ? $arr[$tag] : false;
}


function more_debug($str){
	return $str;
}

function html_a_src($href,$title,$new_win=true){
	$src='<a href="'.trim($href).'" ';
	if($new_win===true){
		$src.=' target="_blank" ';
	}else{
		if(!empty($new_win)){
			$src.=' target="'.trim($new_win).'" ';
		}
	}
	$src.='>'.$title.'</a>';
	return $src;
}

function _replace_middle_str($src, $str1, $str2,$new=''){
    $pos1 = stripos($src,$str1);
    $pos2 = stripos($src,$str2);

    if ($pos1!=false && $pos2!=false && $pos1<$pos2){
        $tmp = substr($src,0,$pos1);
        $tmp .= $new;
        $tmp .= substr($src,$pos2);
        $src = $tmp;
    }else{
        $src=false;
    }
    return $src;
}


function m_implode($ch, &$ar) {
  foreach($ar as &$v) {
    if(is_array($v)) $v = m_implode($ch, $v);
  }
  return implode($ch, $ar);
}


function js_src( $js ){
	return '<script>'.PHP_EOL . $js .PHP_EOL. '</script>'.PHP_EOL;
}

function api_header(){
	$action = empty( $_REQUEST['ajax'] ) ? '' : strtolower( $_REQUEST['ajax'] );
	if($action){
		if($action=='js'){
			$ContentType ='application/x-javascript';
		}else{
			$ContentType ='text/plain';
		}
	}else{
		$ContentType ='text/html';
	}
	header("Content-Type:".$ContentType.";charset=utf-8");
}


/**

	new code for this web app 

*/

?>
<?php
