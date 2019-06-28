<?php

if(!isset($_GET['c']) || !isset($_GET['a']) ){
	die('Access Denied/Forbidden');
}

set_time_limit(0);

/**

	KS 492607291@qq.com

**/

$_GET = transcribe( $_GET ); 
$_POST = transcribe( $_POST ); 
$_REQUEST = transcribe( $_REQUEST );

/**

**/

define( 'DS' , DIRECTORY_SEPARATOR );
// define( 'APP_ROOT' , dirname( dirname( __FILE__ ) ) . DS  );
define( 'APP_ROOT' , dirname( __FILE__ ) . DS  );

define( 'CACHE_ROOT' , 'b:'.DS );

date_default_timezone_set("Asia/Shanghai");
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

// define( 'KIS_APP_ROOT' , dirname( APP_ROOT ) . DS );
define( 'KIS_APP_ROOT' , APP_ROOT . DS .'php'.DS);
// include_once KIS_APP_ROOT.'ext_lib'. DS.'comm.function.php';
define( 'AROOT' , KIS_APP_ROOT);
define( 'CROOT' , KIS_APP_ROOT.'_lp'. DS.'core'. DS  );

include_once('func.inc.php');


/**

**/
function utf8_to_gb2312($subject, $function=1) {
	$charset_from = "UTF-8";
	$charset_to = "GB2312";
	if($function<1){
		$function=1;
	}else if($function>2){
		$function=2;
	}
	switch ($function) {
	case 1:
		$subject = iconv($charset_from, $charset_to, $subject);
		break;
	case 2:
		$subject = mb_convert_encoding($subject, $charset_to, $charset_from);
		break;
	/*case 3:
		include_once __dir__.DIRECTORY_SEPARATOR.'lib\gb2312utf8.php';
		
		$xyy = new GB2312UTF8();
		$UTF8 = $xyy->UTF8TOGB2312($subject);
		$subject = $UTF8;
		break;
	*/
	}
	return $subject;
}

function transcribe($aList, $aIsTopLevel = true) 
{
   if( !function_exists('get_magic_quotes_gpc') ) return $aList;

   $gpcList = array();
   $isMagic = get_magic_quotes_gpc();
  
   foreach ($aList as $key => $value) {
       if (is_array($value)) {
           $decodedKey = ($isMagic && !$aIsTopLevel)?stripslashes($key):$key;
           $decodedValue = transcribe($value, false);
       } else {
           $decodedKey = stripslashes($key);
           $decodedValue = ($isMagic)?stripslashes($value):$value;
       }
       $gpcList[$decodedKey] = $decodedValue;
   }
   return $gpcList;
}

//$_GET = transcribe( $_GET ); 
//$_POST = transcribe( $_POST ); 
//$_REQUEST = transcribe( $_REQUEST );

function v( $str )
{
	return isset( $_REQUEST[$str] ) ? $_REQUEST[$str] : false;
}

function loadCache($cacheFileName){
	$ret=array();
	if(file_exists($cacheFileName)){
		$json=file_get_contents($cacheFileName);
		$ret=json_decode($json,true);
	}
	return $ret;
}

function updateCache($cacheFileName,$newVal,$max=10){
	$cacheJson=loadCache($cacheFileName);
	$saveFlag=false;
	if($max>0){
		$idx=count($cacheJson)-$max;
		if($idx>0){
			$saveFlag=true;
			foreach ($cacheJson as $key => $value) {
				@unlink($value);
				unset($cacheJson[$key]);
				$idx--;
				if($idx<=0) break;
			}
		}	
	}
	if($newVal!==false){
		$saveFlag=true;
		$cacheJson[]=$newVal;	
	}	
	if($saveFlag){
		file_put_contents($cacheFileName,json_encode($cacheJson));
	}
	return $cacheJson;
}

function arrayDelSub($arr,$itm){
	$retArr=array();
	foreach ($arr as $key => $value) {
		if($value===$itm){
			//del
		}else{
			$retArr[]=$value;
		}
	}
	return $retArr;
}



/**



**/

$c=v('c');
$a=v('a');

if(function_exists($c.'_'.$a)){
	call_user_func($c.'_'.$a,$c,$a);
	die();
}

die('Access Denied/Forbidden');


/**


**/
function remove_space($c,$a){
	$input_from_post=v('input');
	if($input_from_post){
		$str1=$input_from_post;
	}else{
		die(__METHOD__.'() error!');
	}


	//echo $str1;
	$idx=0;
	$tmpArr=explode(PHP_EOL, $str1);
	foreach ($tmpArr as $key => $value) {
		if(!empty($value)){
			echo $value.PHP_EOL;	
			if($idx %2==1){
				echo '<br/>'.PHP_EOL;	
			}
			$idx++;
		}
	}

	//echo $subreplaceSrc;
	echo PHP_EOL.PHP_EOL.PHP_EOL;
}


function remove_lineno($c,$a){
	$input_from_post=v('input');
	if($input_from_post){
		$str1=$input_from_post;
	}else{
		die(__METHOD__.'() error!');
	}

	//echo $str1;
	$idx=0;
	$tmpArr=explode(PHP_EOL, $str1);
	foreach ($tmpArr as $key => $value) {
		if(!empty($value)){
			//echo h3($value);	
			if(substr($value, 1,1)=='.'){
				$value=substr($value, 2);
			}else if(substr($value, 2,1)=='.'){
				$value=substr($value, 3);
			}
			echo $value.PHP_EOL;
			echo '<br/>'.PHP_EOL;
			$idx++;
		}
	}

	//echo $subreplaceSrc;
	echo PHP_EOL.PHP_EOL.PHP_EOL;
}

function h3($h3){
	return '<h3>'.$h3.'</h3>'.PHP_EOL;
}

/**

*/

function api_prosess1($c,$a){
	$input_from_post=v('input');
	if($input_from_post){
		$str1=$input_from_post;
	}else{
		die(__METHOD__.'() error!');	
	}

	if(intval($str1)==1){
		$str1='E:\KS1021\exe\USBWebserver_v8.6\root\tmp_test\cg_db_web_editor\test\gamedata.sql';
	}

	if(strlen($str1)<1000){
		if(file_exists($str1)){
			$str1=file_get_contents($str1);
		}
	}

	$acl_id=intval( v('acl_id') );
	if($acl_id<=0){
		$acl_id=110;
		//die(__METHOD__.'() miss acl_id !');
	}

	$tmpFN=CACHE_ROOT.'tmp'.md5($input_from_post).'.txt';

	file_put_contents($tmpFN, $input_from_post);
	//die();

/*
CREATE TABLE Basic_knapsack (ID VarChar,

Name VarChar,

Quantity VarChar);
*/
	$delimiter1='CREATE TABLE';
	$delimiter2='TABLE';
	$delimiter3='(';
	$delimiter4='INSERT INTO';

	$tmpFN=CACHE_ROOT.'tmpNewSql.sql';
	@unlink($tmpFN);

	@unlink(CACHE_ROOT.'tmpNewSql2.sql');

	//echo $str1;
	$idx=0;
/*
	$tmpArr=explode($delimiter1, $str1);

	//var_dump($tmpArr);	die('[DEBUG] END');
	
	$tableIdx=1;
	foreach ($tmpArr as $key => $value) {
		if(stripos($value, ');')!==false){
			$tmpTableName=_cut_middle_str($delimiter1.$value,$delimiter2,$delimiter3);
			if(!empty($tmpTableName)){
				echo h3('#'.($tableIdx++).' '. $tmpTableName);

				$tmpLine=_cut_middle_str($delimiter1.$value,$delimiter2,$delimiter4);
				process_table($tmpTableName,$delimiter1.' '.$tmpLine);
			}
		}
		//if($tableIdx>10) break;
	}
*/
	$tmpArr=explode(PHP_EOL, $str1);
	$tableIdx=1;
	$sqlLineIdx=1;
	foreach ($tmpArr as $key => $value) {
		if(stripos($value, $delimiter1)!==false){
			$tmpTableName=_cut_middle_str($value,$delimiter2,$delimiter3);
			$tmpTableName=trim($tmpTableName);
			if(!empty($tmpTableName)){
				echo h3('#'.($tableIdx++).' '. $tmpTableName);
				$sqlLineIdx=1;
			}
		}else if(stripos($value, $delimiter4)!==false){
			if(stripos($value, $tmpTableName)!==false){
				//echo '<br/>'.PHP_EOL;
				//echo ($sqlLineIdx++).': '. $value.PHP_EOL;
				echo ($sqlLineIdx++).',';
				process_insert($acl_id,$tmpTableName,$value);
			}else{
				var_dump($value, $tmpTableName);
				die('[DEBUG] END');
			}
		
		}
		//if($tableIdx>10) break;
	}
}



function process_insert($acl_id,$tmpTableName,$value){
	//echo src_textarea($value);
/*
INSERT INTO Basic_knapsack (ID, Name, Quantity) VALUES ('32373530353131333736', 'C8EBC3C5D2A9BCC1C0F1B0FC', '31');
*/
		
	//echo src_textarea_s();
	//echo '<br/><p color="red">'.PHP_EOL;
	$tmpSql=$value;
	$tmpSql=str_replace(trim($tmpTableName).' (',$tmpTableName. '(acl_id,',$tmpSql);
	$tmpSql=str_replace(' VALUES (', 'VALUES ('.$acl_id.',',$tmpSql);
/*
	$tmpArr=explode("', '", $tmpSql);
	$key1="'";

	foreach ($tmpArr as $key => $value) {

		if(stripos($value, ')')!==false){ //前 or 后

			if(stripos($value, '(')!==false){ //前
				$tmpFieldVal=_cut_middle_str($value.$key1,"VALUES ('",$key1);
			}else{
				$tmpFieldVal=_cut_middle_str($key1.$value.$key1,$key1,$key1);
			}

		}else{
			$tmpFieldVal=$value;
		}

		$tmpFieldNewVal=_fy_($tmpTableName,$key,$tmpFieldVal);
		
		$tmpFieldVal=trim($tmpFieldVal);
		if(!empty($tmpFieldVal)){
			$tmpSql=str_replace($key1.$tmpFieldVal.$key1,$key1.$tmpFieldNewVal.$key1,$tmpSql);
		}
	}
*/
	//echo $tmpSql;
	//echo '</p>'.PHP_EOL;
	//echo src_textarea_e();

	$tmpSql=str_replace('"', '`',$tmpSql);

	$tmpFN=CACHE_ROOT.'tmpNewSql2_'.$tmpTableName.'.sql';
	if(file_exists($tmpFN)){
		$oldSql=file_get_contents($tmpFN);	
	}else{
		$oldSql='';
	}
	file_put_contents($tmpFN, $oldSql.PHP_EOL.$tmpSql);
}

//汉字转换为16进制编码
function hexencode($s) {
    return preg_replace('/(.)/es',"str_pad(dechex(ord('\\1')),2,'0',str_pad_left)",$s);    
}
//16进制编码转换为汉字
function hexdecode($s) {
    return preg_replace('/(\w{2})/e',"chr(hexdec('\\1'))",$s);
}
//echo hexdecode(hexencode("北京欢迎您！"));

function _fy_($tmpTableName,$tmpFieldIdx,$tmpFieldValue){
	if($tmpTableName=='Basic_User'){
		return $tmpFieldValue;
	}

	return hexdecode($tmpFieldValue);
}

function process_table($tmpTableName,$tmpLine){
	echo src_textarea($tmpLine);
/*
CREATE TABLE  Basic_User (

    ID   VARCHAR COLLATE NOCASE,

    Node VARCHAR COLLATE NOCASE,

    Item VARCHAR COLLATE NOCASE,

    Data VARCHAR

);


CREATE TABLE IF NOT EXISTS `ksdb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
 
  PRIMARY KEY (`id`),
 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10001 ;

*/
	
	$xx1=PHP_EOL.' `id` int(11) NOT NULL AUTO_INCREMENT,'.PHP_EOL;

	echo src_textarea_s();
	$tmpNewSql='';
	$tmpNewSql.= 'CREATE TABLE IF NOT EXISTS `'.trim($tmpTableName).'` ('.PHP_EOL;
  	$tmpNewSql.= '  `unid` int(11) NOT NULL AUTO_INCREMENT,'.PHP_EOL;
  	$tmpNewSql.= "  `u_id` int(11) NOT NULL COMMENT '最后编辑者Id',".PHP_EOL;
  	$tmpNewSql.= "  `acl_id` int(11) NOT NULL COMMENT '权限控制表ID',".PHP_EOL;
  	$tmpNewSql.= PHP_EOL;

	$tmpSql=$tmpLine;


	//$tmpSql=str_replace(' '.$tmpTableName.' (', 'IF NOT EXISTS `'.$tmpTableName.'` ('.$xx1, $tmpSql);
	$tmpSql=str_replace(' COLLATE NOCASE', ' ',$tmpSql);

	$tmpArr=explode(',', $tmpSql);

	$key1='VarChar';
	$key2='VARCHAR';

	foreach ($tmpArr as $key => $value) {
		$tmpFieldName=$value;
		if(stripos($value, '(')!==false){
			$tmpFieldName=strstr($tmpFieldName,'(');
			//var_dump($tmpFieldName);//die();
			$tmpFieldName=substr($tmpFieldName,1,strlen($tmpFieldName)-1);
			//var_dump($tmpFieldName);//die();
		}else if(stripos($value, ')')!==false){
			$tmpFieldName=substr($tmpFieldName,0,stripos($tmpFieldName, ')'));
			//var_dump($tmpFieldName);die();
		}
		if(stripos($value, $key1)!==false){
			$tmpFieldName=str_replace($key1, ' ',$tmpFieldName);
			$tmpFieldName=str_replace($key2, ' ', $tmpFieldName);
		}else if(stripos($value, $key2)!==false){
			$tmpFieldName=str_replace($key2, ' ', $tmpFieldName);
			$tmpFieldName=str_replace($key1, ' ',$tmpFieldName);
		}else{
			$tmpFieldName='';
		}
		$tmpFieldName=trim($tmpFieldName);
		if(!empty($tmpFieldName)){
			$tmpNewSql.= '  `'.$tmpFieldName.'` varchar(500) NOT NULL,'.PHP_EOL;
		}
	}

	$tmpNewSql.= PHP_EOL;
	$tmpNewSql.= '`DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,'.PHP_EOL; 
	$tmpNewSql.= '  PRIMARY KEY (`unid`) '.PHP_EOL; 
	$tmpNewSql.= ') ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10001 ;'.PHP_EOL;
	echo $tmpNewSql;
	echo src_textarea_e();

	$tmpFN=CACHE_ROOT.'tmpNewSql.sql';
	if(file_exists($tmpFN)){
		$oldSql=file_get_contents($tmpFN);	
	}else{
		$oldSql='';
	}
	file_put_contents($tmpFN, $oldSql.PHP_EOL.$tmpNewSql);
}


/**

*/

function src_textarea($str){
	return '<textarea style="margin: 0px; width: 386px; height: 186px;">'.$str.'</textarea>'.PHP_EOL;
}

function src_textarea_s(){
	return '<textarea style="margin: 0px; width: 386px; height: 186px;">';
}

function src_textarea_e(){
	return '</textarea>'.PHP_EOL;
}
?>

<!-- END -->