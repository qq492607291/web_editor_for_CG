<?php

///////////////////// config stuff /////////////////////////
if(!defined('HTTP_BAE_ENV_APPID') && !defined('SAE_TMP_PATH') ){
	@set_time_limit(0);
}
date_default_timezone_set('PRC');

if (!defined('ROOT')) define('ROOT', dirname(__FILE__));
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!defined('CRLF')) define('CRLF', PHP_EOL);


$runtime_debug=0;

_init();
//echo KIS_CACHE_PATH;
///// ///// ///// ///// /////     SUB FUNCTION    ///// ///// ///// /////

function _init() {
	global $runtime_debug;
	if(isset($_GET['runtime_debug'])){
		if($_GET['runtime_debug']=='kis'){
			$runtime_debug =1;
		}
	}

	if(is_on_server()===true){
		if (defined('SAE_TMP_PATH')){
			//sae
			define('KIS_CACHE_PATH', "saekv://".APP_UID."cache/");
		}else{
			define('KIS_CACHE_PATH',sys_get_temp_dir());
		}
	
	}else{
		if(!defined('KIS_CACHE_PATH')){
			if(file_exists("b://cache")){
				define('KIS_CACHE_PATH', "b://cache");
			}else if(defined('KIS_APP_TMP_PATH')){
				define('KIS_CACHE_PATH', KIS_APP_TMP_PATH. DS . 'tmp_dir');
			}else{
				$kk=_get_tempdir();
				define('KIS_CACHE_PATH', $kk);
			}
		}		
	}
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _get_path(){
	if (defined('SAE_TMP_PATH')){
		return "saekv://".APP_UID."/cache/";
	}else{
		return sys_get_temp_dir();
	}
	// if(APP_RUN_ENV=="SAE"){
		// return "saekv://cache/";
	// }else {
		// return "upload/";
	// }
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _exit_html($n){
	echo '</body></html>'.PHP_EOL;
	exit($n);
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _EE($n){
	echo $n.PHP_EOL;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _EBR($n){
	echo $n."<br />".PHP_EOL;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _EJS($js){
	_EE('<script type="text/javascript">');
	_EE($js);
	_EE('</script>');
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function my_replace($string,$find,$replace){
	if(stripos($string, $find)){
		$count = 0;
		return str_replace($find,$replace,$string,$count);
	}else{
		return $string;
	}
	
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

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

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function gb2312_to_utf8($subject, $function=1) {
	$charset_from = "GB2312";
	$charset_to = "UTF-8";
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
		$UTF8 = $xyy->GB2312TOUTF8($subject);
		$subject = $UTF8;
		break;
	*/
	}
	return $subject;
}
///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _get_workdir(){
	return realpath(__DIR__.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR ;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _get_mailcfg(){
	$mailcfg = array();
	if (function_exists('_get_mailcfg_user')) {
		$mailcfg = _get_mailcfg_user();
		return $mailcfg;
	}else if(!empty($GLOBALS['config']['mail']['server'])){
		return $GLOBALS['config']['mail'];
	}
	die('error! mail config not ready!');
	return $mailcfg;
}



///// ///// ///// ///// /////     SUB FUNCTION    ///// ///// ///// /////

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function disp($msg){
	if(APP_RUN_ENV=='WEB'){
		echo $msg;
	}else{
		echo iconv('UTF-8','GBK',$msg).PHP_EOL;	
	}
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function is_on_server($env=''){
	// if(!empty($env)){

	// }
	if(defined('SERVER_SOFTWARE') && (SERVER_SOFTWARE == 'bae/3.0') ){
		return true;
	}else if(defined('SAE_TMP_PATH') ){
		return true;
	}
	return false;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function _show_tips($msg,$title='TIPS') {
	echo '<div style="background-color:#c8c8c8;">'.$title.':' . $msg . PHP_EOL .'<br/></div>'.PHP_EOL;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 

function debug($msg1,$mode=0){
	global $runtime_debug;
	
	if(defined('KIS_DEBUG_MODE')){
		if (KIS_DEBUG_MODE=='DISABLE_DEBUG') {
			return false;
		}
	}
	if(is_array($msg1)){
		$msg = print_r($msg1,true);
	}else{
		$msg = $msg1;
	}
	if(is_on_server()===true){
		if($runtime_debug ===1){
			echo '<!-- DEBUG:'.PHP_EOL .$msg.PHP_EOL .' -->'.PHP_EOL;
			return true;
		}else{
			return false;
		}
	}else{
		if (APP_ENVIRONMENT=='DEVELOPMENT') {
			echo '<div style="background-color:#c8c8c8;">DEBUG['.$mode.']:' . $msg . PHP_EOL .'<br/></div>'.PHP_EOL;
		}else{
			echo '<!-- DEBUG:'.PHP_EOL .$msg.PHP_EOL .' -->'.PHP_EOL;	
		}
		return true;
	}
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function debug_txt($name,$msg){
	if(defined('KIS_DEBUG_MODE')){
		if (KIS_DEBUG_MODE=='DISABLE_DEBUG') {
			return false;
		}
	}
	if(is_on_server()===true){
		return false;
	}else{
		$cachedatatxt  = _get_tempdir() . "debug_txt_". $name . ".txt";
		@file_put_contents($cachedatatxt,$msg);
		echo '<div style="background-color:#c8c8c8;">DEBUG:' . $cachedatatxt . PHP_EOL .'<br/></div>'.PHP_EOL;
		return true;
	}
}


///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _get_rootdir(){
	return realpath(__DIR__. DIRECTORY_SEPARATOR ."..").DIRECTORY_SEPARATOR ;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _get_tempdir($app=0){

	if(defined('KIS_CACHE_PATH')){
		return KIS_CACHE_PATH.DIRECTORY_SEPARATOR ;
	}


	if(is_on_server()===true){
		if(SERVER_SOFTWARE == 'bae/3.0'){
			return sys_get_temp_dir();
		}else if(defined('SAE_TMP_PATH') ){
			return SAE_TMP_PATH.DIRECTORY_SEPARATOR ;
		}else{
			return 'tmp_dir\\';
		}
	}
	
	//local test	
	$tmppath = 'b:\\';

	if (!is_dir($tmppath)){
		if ($app==0){
			$tmppath = _get_rootdir();
		}
	}
	$tmppath = $tmppath.'tmp_dir';
	if (!is_dir($tmppath)){
		mkdir_r($tmppath);
	}
	return $tmppath.DIRECTORY_SEPARATOR ;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _get_tempFileName($fixName){
	$tmpdir = _get_tempdir();
	$tmpFileName = $tmpdir. uniqid($fixName,true);
	// echo '$tmpFileName=' . $tmpFileName . "\r\n";
	// $tmpFileName = $tmpdir . md5(uniqid($fixName)) ;
	// echo '$tmpFileName=' . $tmpFileName . "\r\n";
	return $tmpFileName;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function IsWindows()
{
	return strncmp(PHP_OS,'W',1)==0;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function mkdir_r($dirName, $rights=0777)
{
	$dirs = explode(DIRECTORY_SEPARATOR, $dirName);
	$dir='';
	foreach($dirs as $part)
    {
        $dir.=$part.DIRECTORY_SEPARATOR;
        if(!is_dir($dir) && strlen($dir)>0)
        	//echo $dir;
			@mkdir($dir, $rights);
    }
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function removeDir($path)
{
	if(substr($path, -1, 1) != "/")
		$path .= "/";
	$normal_files = glob($path . "*");
	$hidden_files = glob($path . "\.?*");
	$all_files = array_merge($normal_files, $hidden_files);
	foreach($all_files as $file)
	{
         if(preg_match("/(\.|\.\.)$/", $file))
            continue;
         if(is_file($file)===TRUE)
            unlink($file);
         else if (is_dir($file) === TRUE)
            removeDir($file);
	}
	if(is_dir($path)=== TRUE) 
		rmdir($path);
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function remove_dir($dirname) 
{
	if(!file_exists($dirname))
	{
		return false ;
	}
	if(!is_dir($dirname))
	{
		return false ;
	}
	if($handle=opendir($dirname))
	{
		while (false !== ($file = readdir($handle))) 	
		{
			if($file=="." || $file=="..")
				continue ;
			$dir_file = $dirname.DIRECTORY_SEPARATOR.$file ;
			if(is_dir($dir_file))
				remove_dir($dir_file) ;
			else
				unlink($dir_file) ;
		}
		closedir($handle) ;
		rmdir($dirname) ;
	}
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function returnLines($str) 
{
	if(empty($str))
		return array() ;
	$lines  = explode("\n",$str) ;
	foreach($lines as $key=>$value)
	{
		if(trim($value)=="")
			unset($lines[$key]) ;
	}
	return $lines ;
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function stringToProxyContext($http_proxy_host,$http_proxy_port,$http_proxy_username,$http_proxy_password)
{
	$http_proxy_a=array(
                     'http' => array(
                                     'proxy' => 'tcp://'.$http_proxy_host.':'.$http_proxy_port,
                                     'request_fulluri' => True,
                                    ),
                    );
	if($http_proxy_username!="")
	{
		$auth=base64_encode($http_proxy_username.':'.$http_proxy_password);
		$http_proxy_a['http']['header']="Proxy-Authorization: Basic $auth";
	}
	return stream_context_create($http_proxy_a);
}



function getJsonConfigIni($file = '')
{
	$file = $file?$file:dirname(__FILE__).DIRECTORY_SEPARATOR.'config.ini';

	if(file_exists($file))
	{
		return (json_decode(file_get_contents($file), true));
	}

	return false;
}

function setJsonConfigIni($cfg = array(), $file='')
{
	$file = $file?$file:dirname(__FILE__).DIRECTORY_SEPARATOR.'config.ini';

	if($cfg && is_array($cfg))
	{
		file_put_contents($file, json_encode($cfg));
	}

	return true;
}

function _getJsonConfig($file = '')
{
	$file = $file?$file:dirname(__FILE__).DIRECTORY_SEPARATOR.'config.ini';

	if(file_exists($file))
	{
		$conf = json_decode(file_get_contents($file), true);
		
		$tmpArray = array();
		foreach ($conf as $tmpKey => $tmpVal){
			$tmpKey = trim($tmpKey);
			$tmpVal = utf8_decode($tmpVal);
			$tmpArray[$tmpKey]=$tmpVal;
		}
		
		$tmpArray['fileName'] = $file;
		$tmpArray['filePath'] = realpath($file);
		
		return $tmpArray;
	}

	return false;
}

function _setJsonConfig($cfg, $file='')
{
	$tmpArray = array();
	foreach ($cfg as $tmpKey => $tmpVal){
		$tmpKey = trim($tmpKey);
		$tmpVal = utf8_encode($tmpVal);
		$tmpArray[$tmpKey]=$tmpVal;
	}

	$file = $file?$file:dirname(__FILE__).DIRECTORY_SEPARATOR.'config.ini';

	if($cfg && is_array($cfg)) {
		$conf = json_encode($tmpArray);
		file_put_contents($file, $conf);
	}else{
		debug('_setJsonConfig() error #1');
	}

	return true;
}


function _conf_get($itemName,$itemValue,$cfg=null,$fileName=''){
	if ($cfg===null) {
		debug('_conf_read() call init');
		$cfg = _getJsonConfig($filename);
	}
	$itemName = trim($itemName);
	if (isset($cfg[$itemName])) {
		//有该配置项则返回其值.
		debug( '_conf_read() item('.$itemName.') isset' );
		return $cfg[$itemName];
	}
	debug('_conf_read() item('.$itemName.') not set , return default value.');
	return $itemValue;	//返回默认值.
}

function _conf_set($itemName,$itemValue,$cfg=null,$fileName=''){
	$tmpArray = array();
	if($cfg && is_array($cfg)) {
		foreach ($cfg as $tmpKey => $tmpVal){
			$tmpKey = trim($tmpKey);
			$tmpVal = utf8_decode($tmpVal);
			$tmpArray[$tmpKey]=$tmpVal;
		}
	}else{
		debug('_conf_set() error #1');
		$tmpArray = _getJsonConfig($filename);
	}
	
	// var_dump($tmpArray );
	
	$tmpArray[$itemName] =$itemValue;
	
	$tmpArray['fileName'] = $file;
	$tmpArray['filePath'] = realpath($file);
	
	return $tmpArray;
}

function _conf_save($cfg=null,$fileName=''){
	if ($cfg===null) {
		debug('_conf_read() call init');
		$cfg = _getJsonConfig($filename);
	}
	_setJsonConfig($cfg,$fileName);
	return $cfg;
}

///// ///// ///// ///// ///// ///// ///// ///// /////  写ini文件
function _ini_write($itemName,$itemValue,$cfg=null,$fileName=''){
	if (strlen($fileName)==0){
		$fileName = _get_workdir() . 'config.ini';
	}
	if ($cfg===null) {
		$cfg=@_ini_init($fileName);
	}
	$itemName = trim($itemName);
	debug('_ini_write() $itemName='.$itemName,1);	//DEBUG
	// if (isset($cfg[$itemName])) {
		// debug('found $cfg[$itemName]='.$cfg[$itemName],1);	//DEBUG
		// $cfg[$itemName] = $itemValue;
		// $tmpStr = '[config]'.PHP_EOL;
	// }else{
		// debug('不存在 $cfg[$itemName]='.$cfg[$itemName]);	//DEBUG
		// $tmpStr = '[config]'.PHP_EOL;
		// $tmpStr = $tmpStr . $itemName . '='. $itemValue .PHP_EOL;
	// }
	// foreach($cfg as $name=>$val){	
		// $tmpStr = $tmpStr . $name .'='. $val .PHP_EOL;
	// }	
	// @file_put_contents($fileName,$tmpStr);
	$cfg[$itemName] = $itemValue;
	$cfg=@_ini_real_write($cfg,$fileName);
	return $cfg;
}

function _ini_real_write($cfg,$fileName){
	$tmpStr = '[config]'.PHP_EOL;
	foreach($cfg as $nam=>$val){	
		$tmpStr = $tmpStr . $nam .'='. $val .PHP_EOL;
	}	
	@file_put_contents($fileName,$tmpStr);	
	$cfg=@parse_ini_file($fileName);
	return $cfg;
}


///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _ini_read($itemName,$itemValue,$cfg=null,$fileName=''){
	if (strlen($fileName)==0){
		$fileName = _get_workdir() . 'config.ini';
	}
	if ($cfg===null) {
		debug('_ini_read() call init');
		$cfg=@_ini_init($fileName);
	}
	$itemName = trim($itemName);
	if (isset($cfg[$itemName])) {
		//有该配置项则返回其值.
		debug( '_ini_read() item('.$itemName.') isset' );
		return $cfg[$itemName];
	}
	debug('_ini_read() item('.$itemName.') notset , return default value.');
	return $itemValue;	//返回默认值.
}

///// ///// ///// ///// ///// ///// ///// ///// ///// 
function _ini_init($fileName=''){
	if (strlen($fileName)==0){
		$fileName = _get_workdir() . 'config.ini';
		debug('_ini_init() $fileName=' . $fileName);	//DEBUG
	}
	if (!file_exists($fileName)) {
		echo iconv('UTF-8','GBK','_ini_init(' .$fileName.') file NOT exist.').PHP_EOL;	
		$tmpStr = '[config]'.PHP_EOL;
		$tmpStr = $tmpStr . '#init' .PHP_EOL;
		@file_put_contents($fileName,$tmpStr);
	}
	$cfg=@parse_ini_file($fileName);
	return $cfg;
}

function _cut_middle_str($str, $str1, $str2){
//_cut_middle_str('xxaabbccyy','aa','cc')='bb';
	if (empty($str1))  {
		echo 'DEBUG:'.__FUNCTION__.'() ,miss $str1'.PHP_EOL;
		return $str;
	}
	if (empty($str2))  {
		echo 'DEBUG:'.__FUNCTION__.'() ,miss $str2'.PHP_EOL;
		return $str;
	}
	//debug("_cut_middle_str(0) str=" . $str. '#  str1='.$str1. '#  str2='.$str2);
	$i = stripos($str,$str1);
	if ($i!== false){
		$str = substr($str,$i+strlen($str1));
		// echo '<!--  #1'.$str.PHP_EOL.' -->'.PHP_EOL;
		//debug("_cut_middle_str(1) str=". $str);
	}else{
		return '';
	}
	$i = stripos($str,$str2);
	if ($i!== false){
		$str = substr($str,0,$i);
		// echo '<!--  #2'.$str.PHP_EOL.' -->'.PHP_EOL;
		//debug("_cut_middle_str(2) str=". $str);
	}
	return $str;
}

function _cut_middle_str_array($str, $str1, $str2,$save_count=0){
//_cut_middle_str('xxaabbccyy','aa','cc')='bb';
	if (empty($str))  {
		echo ( 'DEBUG: ' . __FUNCTION__ . '() miss $str'. PHP_EOL) ;
		return $str;
	}
	if (empty($str1))  {
		echo ( 'DEBUG: ' . __FUNCTION__ . '() miss $str1'. PHP_EOL) ;
		return $str;
	}
	if (empty($str2))  {
		echo ( 'DEBUG: ' . __FUNCTION__ . '() miss $str2'. PHP_EOL) ;
		return $str;
	}

	$ret_array = array();
	
	$i = stripos($str,$str1);
	if ($i=== false){
		return $ret_array;
	}

	$tmp_array=explode($str1, $str);
	if(count($tmp_array)==0){
		return $ret_array;
	}

	
	$ret_arr_id = 0;
	foreach ($tmp_array as $tmp_str) {
		$i = stripos($tmp_str,$str2);
		if ($i!== false){
			$tmp_ret_str = substr($tmp_str,0,$i);
			$ret_array[$ret_arr_id]=$tmp_ret_str;
			//echo ('xxx['.$ret_arr_id.']='.$tmp_ret_str. PHP_EOL);
			$ret_arr_id++;
		}
	}
	if($save_count===1){
		$ret_array['total_count']=$ret_arr_id;
	}	

	return $ret_array;
}

function _get_all_url($strSource, $keyStr1, $keyStr2){
	//$keyStr1:URL必须包含的内容.
	//$keyStr2:URL必不包含的内容.
	$tmp_func_name = '_get_all_url()';
	//debug("in " . $tmp_func_name );
	$pattern = '/<a.*?(?: |\\t|\\r|\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>(.+?)<\/a.*?>/sim';
	preg_match_all($pattern, $strSource, $strResult);
	$num = count($strResult[1]);
	
	//debug("in " . $tmp_func_name .' $num['. $num.'].');
	
	$keyArray1 = explode(PHP_EOL,$keyStr1);
	$keyArray2 = explode(PHP_EOL,$keyStr2);
	$num1 = count($keyArray1);
	//debug('$num1='.$num1,1);		//DEBUG
	$num2 = count($keyArray2);
	//debug('$num2='.$num2,1);		//DEBUG
	
	$result = '';
	$ret_array = array();
	
	for($i = 0; $i < $num; $i++){
		// printf("%d href=(%s) title=(%s) \n", $i, $strResult[1][$i], $strResult[2][$i]);
		// printf("<a href=%s> %s </a>\n\n", $strResult[1][$i], $strResult[2][$i]);
		
		$keyflag = false;
		for($j = 0; $j < $num2; $j++){
			$keyTmp = $keyArray2[$j];	//无效URL关键词.
			if (strlen($keyTmp)>0) {
				if(stripos($strResult[1][$i],$keyTmp)){
					$keyflag = true;	//found key
					//debug('无效URL关键词'.$keyTmp);		//DEBUG
					break;
				}					
			}
		}
		// if($keyflag){
			//$_msg="found key , skip it";
		// }
		if($keyflag==false){
			for($jj = 0; $jj < $num1; $jj++){
				$keyTmp = $keyArray1[$jj];	//有效URL关键词.
				if (strlen($keyTmp)>0) {
					if(stripos($strResult[1][$i],$keyTmp)===false){
						$keyflag = true;
						//debug('miss 有效URL关键词'.$keyTmp);		//DEBUG
						break;
					}
				}
			}
		}
		if($keyflag==false){
			$keyTmp = $strResult[1][$i];
			$tmpStr = $strResult[2][$i];
			$keyTmp = trim($keyTmp);
			$tmpStr = trim($tmpStr);
			$ret_array[$keyTmp] = $tmpStr; //存成key=>value的形式.
		}
	}
	
	//debug("out " . $tmp_func_name );
	return $ret_array;
}


function _get_content($tmpStr,$sitesign){
//剪切有效内容
	$tmpStr = strstr($tmpStr,$sitesign['ContentStart']);
	$tmpStr = substr($tmpStr,strlen($sitesign['ContentStart']));
	$tmpStr = strstr($tmpStr,$sitesign['ContentEnd'],true);
	
	$nTryCount=0;	//尝试次数
	$nMaxTryCount=10;	//max尝试次数

	$tmpStr = str_replace('<br />','[%CRLF%]',$tmpStr);
	$tmpStr = strip_tags($tmpStr);
	$tmpStr = str_replace('[%CRLF%]',PHP_EOL,$tmpStr);

	//清理连续的换行
	$nTryCount=0;
	while ( ($nTryCount<$nMaxTryCount) and strstr($tmpStr,PHP_EOL . PHP_EOL) ) {
		$tmpStr = str_replace(PHP_EOL . PHP_EOL,PHP_EOL,$tmpStr);
		$nTryCount ++;
	}
	if (APP_ENVIRONMENT=='DEVELOPMENT') {
		if ($nTryCount<$nMaxTryCount) {echo 'remove space #1 ,cout=' . $nTryCount . PHP_EOL;}
	}
	//清理连续的TAB
	$nTryCount=0;
	$tmpKey = "\t";
	while ( ($nTryCount<$nMaxTryCount) and strstr($tmpStr,$tmpKey.$tmpKey) ) {
		$tmpStr = str_replace($tmpKey.$tmpKey,' ',$tmpStr);
		$nTryCount ++;
	}
	if (APP_ENVIRONMENT=='DEVELOPMENT') {
		if ($nTryCount<$nMaxTryCount) {echo 'remove space #2 ,cout=' . $nTryCount . PHP_EOL;}
	}
	
	//清理连续的&nbsp;
	$nTryCount=0;
	$tmpKey = '&nbsp;';
	while ( ($nTryCount<$nMaxTryCount) and strstr($tmpStr,$tmpKey.$tmpKey) ) {
		$tmpStr = str_replace($tmpKey.$tmpKey,' ',$tmpStr);
		$nTryCount ++;
	}
	if ($debugRunMode===1) {
		if ($nTryCount<$nMaxTryCount) {echo 'remove space #3 ,cout=' . $nTryCount . PHP_EOL;}
	}
	
	//清理连续的空格
	$nTryCount=0;
	$tmpKey = ' ';
	while ( ($nTryCount<$nMaxTryCount) and strstr($tmpStr,$tmpKey.$tmpKey) ) {
		$tmpStr = str_replace($tmpKey.$tmpKey,' ',$tmpStr);
		$nTryCount ++;
	}
	if (APP_ENVIRONMENT=='DEVELOPMENT') {
		if ($nTryCount<$nMaxTryCount) {echo 'remove space #4 ,cout=' . $nTryCount . PHP_EOL;}
	}

	return $tmpStr;
}

///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 
///////// 
///////// 
///////// 
///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 
function _get_url($startUrl,
	$post_data = '',
	$user_agent='',  
	$header = 0, 
	$follow_loc = 0, 
	$cookie_file='def',
	$CURLOPT_REFERER = 'def',
	$CURLOPT_TIMEOUT=16)
{

	$tmp_func_name = __FUNCTION__ .'()';
	debug("in " . $tmp_func_name . ' $startUrl ='.$startUrl  );
	
	if (empty($startUrl)){
		echo ( 'ERROR, ' . __FUNCTION__ . '() ERROR ! startUrl is empty ! ' ) ;
		return ;
	}
	/*$cachedatatxt = md5($startUrl.$post_data.$user_agent.$header.$follow_loc.$cookie_file.$CURLOPT_REFERER
		.$CURLOPT_TIMEOUT.date("YmdH")).".txt";*/
	$cachedatatxt = md5($startUrl.$post_data.$user_agent.$header.$follow_loc.$cookie_file.$CURLOPT_REFERER
		.$CURLOPT_TIMEOUT.date("Ymd")).".txt";
	$cachedatatxt_mini=$cachedatatxt;
	//debug('tmp-dir='._get_tempdir());	
	$cachedatatxt  = _get_tempdir() . $cachedatatxt ;
	
	if($ret= kis_cache_get($cachedatatxt_mini)){
		if(!empty($ret)){
			return $ret;
		}
	}

	// 1. 初始化
	$ch = @curl_init();
	// 2. 设置选项，包括URL
	@curl_setopt($ch, CURLOPT_URL, $startUrl);
	if (empty($user_agent)==0){
		// $user_agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';	//IE 6.0
		// $user_agent='Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)';	//IE 7.0
		$user_agent='Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)';	//IE 8.0
	}
	
	debug("in " . $tmp_func_name . ' $curl_setopt ='.$startUrl  );
	
	@curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	if (!empty($cookie_file)){
		if (strncmp($cookie_file,'def',3)==0) {
			//$cookie_file = _get_tempFileName('tmpcookie');
			$cookie_file = $cachedatatxt .'.tmpcookie.txt';
		}
		@curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		@curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
	}
	if (!empty($CURLOPT_REFERER)){
		if (strncmp($CURLOPT_REFERER,'def',3)==0) {
			$CURLOPT_REFERER = '';
		}
		@curl_setopt($ch, CURLOPT_REFERER,$CURLOPT_REFERER);
	}
	@curl_setopt($ch, CURLOPT_HEADER, $header);				// 只需返回HTTP header
	@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		 // 返回结果，而不是输出它
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_loc);		//启用时会将服务器服务器返回的“Location:”放在header中
			//递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量；
	// @curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	// @curl_setopt($ch, CURLOPT_PROXY, 'fakeproxy.com:1080'); 
	// @curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password'); 

	@curl_setopt($ch, CURLOPT_TIMEOUT, $CURLOPT_TIMEOUT);
	if ($post_data!='') {
	  @curl_setopt($ch, CURLOPT_POST, 1);
	  @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	// 3. 执行并获取HTML文档内容
	$output = @curl_exec($ch);
	if ($output === FALSE) {
		debug( "cURL Error: " . curl_error($ch).PHP_EOL);
	}
	$info = curl_getinfo($ch);
	debug( 'get '. $info['url'] . ' ,cost'. $info['total_time'] . 'sec.'."\r\n");

	// 4. 释放curl句柄
	@curl_close($ch);

	debug("out " . $tmp_func_name );
	
	kis_cache_set($cachedatatxt_mini,$output);
	return $output;
}

///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 

function _kis_mail($sendto,$title,$content,$mailcfg=null){
	$ret="";
	if(!empty($GLOBALS['config']['mail'])){
		$mailcfg = $GLOBALS['config']['mail'];
		$auth_username=$mailcfg['auth_username']; 
		$auth_password=$mailcfg['auth_password']; 
	}else{
		echo ( 'WRONG, email config not ready ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
		return false;
	}

	// $title = mb_convert_encoding($title, "UTF-8", "auto");
	// $content = mb_convert_encoding($content, "UTF-8", "auto");
	// $sendto = mb_convert_encoding($sendto, "UTF-8", "auto");

	// echo ( PHP_EOL.'DEBUG, ' . __FUNCTION__ . ' sendto='.$sendto.PHP_EOL ) ;
	// echo ( PHP_EOL.'DEBUG, ' . __FUNCTION__ . ' title='.$title.PHP_EOL ) ;
	// echo ( PHP_EOL.'DEBUG, ' . __FUNCTION__ . ' content='.$content.PHP_EOL ) ;
	
	if(_phpmailer_mail($sendto,'',$title,$content)) {
		return true;
	}

	// if(defined('HTTP_BAE_ENV_APPID')){
	// 	_EBR ('SEND MAIL BY BAE!');

	// if(defined('SERVER_SOFTWARE')){
	// 	//SERVER_SOFTWARE = bae/3.0
	// 	$runtime_env_check=strtolower(SERVER_SOFTWARE.'');
	// 	if(stripos($runtime_env_check,'bae')!==false){
	// 		//skip
	// 	}else{
	// 		if(v('runtime_debug')) echo 'SERVER_SOFTWARE =' . SERVER_SOFTWARE .' !'. PHP_EOL;
	// 	}
	// 	if(!class_exists("Bcms")){
	// 		// require_once AROOT . DS .'lib'. DS.  'Bcms.class.php';
	// 		require_once "Bcms.class.php";
	// 	}

	// 	$bcms = new Bcms (APP_AK, APP_SK) ;
	// 	$ret = $bcms->mail ( BCMS_QUEUE, $content, array($sendto), array( Bcms::MAIL_SUBJECT => $title)) ;
	// 	if ( false === $ret ) {
	// 		echo ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
	// 		echo ( 'ERROR NUMBER: ' . $bcms->errno ( ) ) ;
	// 		echo ( 'ERROR MESSAGE: ' . $bcms->errmsg ( ) ) ;
	// 		echo ( 'REQUEST ID: ' . $bcms->getRequestId ( ) );
	// 		$ret=0;
	// 	} else {
	// 		echo ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
	// 		echo ( 'result: ' . print_r ( $ret, true ) ) ;
	// 		//print_r($ret);
	// 		$ret=1;
	// 	}
		
	// }else if (defined('SAE_TMP_PATH')){
	// 	_EBR ('SEND MAIL BY SAE!');
				
	// 	$mail = new SaeMail();
	// 	$ret = $mail->quickSend( $sendto , $title , $content , $auth_username , $auth_password );
		 
	// 	//发送失败时输出错误码和错误信息
	// 	if ($ret === false){
	// 		var_dump($mail->errno(), $mail->errmsg());
	// 		$ret=0;
	// 	}
	// 	$ret=1;
	// }else{
	// 	//local mode
	// 	_EBR('SEND MAIL BY LOCAL SMTP CONFIG!');

		if(empty($mailcfg)) {
			$mailcfg = _get_mailcfg();	
		}

		//_EBR ( "auth_username2=".$mailcfg['auth_username'] );
		//_EBR("auth_password2=".$mailcfg['auth_password'] );

		$ret = _send_mail($sendto,$title,$content,$mailcfg);
	// }
	return $ret;
}


function _phpmailer_mail($sendto_add,$sendto_name,$title,$content,$mode=1,$mailcfg=null){
	global $runtime_debug;
	if ($mailcfg===null) $mailcfg = _get_mailcfg();

	require_once 'PHPMailer/PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;

	$mail->CharSet = 'UTF-8'; //这里转换字符

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	if(is_on_server()===true){
		$mail->SMTPDebug = 0;		
	}else{
		$mail->SMTPDebug = 2;
	}	
	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';
	//Set the hostname of the mail server
	$mail->Host = $mailcfg['server'];
	//Set the SMTP port number - likely to be 25, 465 or 587
	$mail->Port = $mailcfg['port'] ;
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication
	$mail->Username = $mailcfg['auth_username'] ;
	//Password to use for SMTP authentication
	$mail->Password = $mailcfg['auth_password'];
	//Set who the message is to be sent from
	$mail->setFrom($mailcfg['from_email'] , $mailcfg['from_name'] );
	//Set an alternative reply-to address
	$mail->addReplyTo($mailcfg['from_email'] , $mailcfg['from_name']);
	//Set who the message is to be sent to
	$mail->addAddress($sendto_add, $sendto_name);
	//Set the subject line
	$mail->Subject = $title;
	// $mail->Subject ="?utf-8?B?" . base64_encode($title) . "?=";

	if($mode==1){
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail->msgHTML($content);
		//Replace the plain text body with one created manually
		$mail->AltBody = $content;
	} else {
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML(file_get_contents($content), dirname(__FILE__));
		//Replace the plain text body with one created manually
		$mail->AltBody = $content;
	}
	
	//Attach an image file
	// $mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    
	} else {
	    echo "Message sent!";
	    return true;
	}
	return false;
}

function _send_mail($sendto,$title,$content,$mailcfg=null){
	if ($mailcfg===null) $mailcfg = _get_mailcfg();

	//_EBR("@_send_mail(),auth_username=".$mailcfg['auth_username']);
	//echo "@_send_mail(),auth_password=".$mailcfg['auth_password'].'<br/>'.PHP_EOL;
	echo "@_send_mail(),auth_username=".$mailcfg['auth_username'].'<br/>'.PHP_EOL;

	$stmp=new stmp($mailcfg); 
	$mail=array('to'=>$sendto,'subject'=>$title,'content'=>$content); 
	if(!$stmp->send($mail)){ 
		echo $stmp->get_error().PHP_EOL;
		return 1;
	}else{ 
		echo 'mail success!'.PHP_EOL;
		echo $stmp->get_error().PHP_EOL;
		return 0;
	} 
} 
///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 

function _get_page($startUrl,$ref='def',$cookie_file='def'){
	if( defined('SAE_APPNAME') ){
		$result = _get_url($startUrl,'','',0,0,$cookie_file,$ref);
		return $result;
	}
	$tmpFile = KIS_CACHE_PATH . md5($startUrl . $ref) .'.htm';
	$tmp_func_name = '_get_page()';
	debug("in " . $tmp_func_name . ' $tmpFile ='.$tmpFile  );
	if (APP_ENVIRONMENT=='DEVELOPMENT') {
		_time_log($tmpFile.','. $startUrl.','.$ref);
		if (file_exists($tmpFile)){
			$result = file_get_contents($tmpFile);
		}else{
			$result = _get_url($startUrl,'','',0,0,$cookie_file,$ref);
			file_put_contents($tmpFile,$result);
		}
	}else{
		$result = _get_url($startUrl,'','',0,0,$cookie_file,$ref);
		if (KIS_CACHE_MODE=='ALL') {
			file_put_contents($tmpFile,$result);
		}
	}
	return $result;
}
///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 
///////// 
///////// 
///////// 
///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// ///////// 
function _post_page($startUrl,$post_data){
	$tmpFile = KIS_CACHE_PATH . md5($startUrl . $ref) .'.htm';
	
	if (APP_ENVIRONMENT=='DEVELOPMENT') {
		if (file_exists($tmpFile)){
			$result = file_get_contents($tmpFile);
		}else{
			$result = _get_url($startUrl,$post_data);
			if (KIS_CACHE_MODE=='ALL') {
				file_put_contents($tmpFile,$result);
			}
		}
	}else{
		$result = _get_url($startUrl,$post_data);
		if (KIS_CACHE_MODE=='ALL') {
			file_put_contents($tmpFile,$result);
		}
	}
	return $result;
}


function _my_sleep($min=5,$max=10){
	$kk = rand($min,$max);
	echo 'sleep '. $kk . ' sec.' .PHP_EOL;
	sleep($kk);
}

function _today_str(){
	return date('Y-m-d');
}

function _time_str(){
	return date('Y-m-d H:i:s');
}
function _time_log($txt,$fileName=''){
	return _txt_log(_time_str() . ',' . $txt,$fileName) ;
}

function minilog($s, $log='')
{
	$log = $log?$log:ROOT.DS.'logs'.DS.'log.txt';
	file_put_contents($log, date('Y-m-d H:i:s').'==>'.$s."\r\n",FILE_APPEND);
}

function _txt_log($txt,$fileName=''){
	if (strlen($fileName)==0){
		$fileName = _get_workdir() . 'tmpLog.txt';
		// debug('_txt_log() $fileName=' . $fileName);	//DEBUG
	}
	if ($fh = fopen($fileName, "a+")) {
		# Processing
		fwrite($fh,$txt . PHP_EOL);
		fclose($fh);
		return 0;
	} else {
		return 1;
	}	
}

function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = false) {
	if (function_exists("mb_substr")) {
		if ($suffix && strlen($str) > $length)
			return mb_substr($str, $start, $length, $charset)."...";
		else
			return mb_substr($str, $start, $length, $charset);
	}else if(function_exists('iconv_substr')) {
		if ($suffix && strlen($str) > $length)
			return iconv_substr($str, $start, $length, $charset)."...";
		else
			return iconv_substr($str, $start, $length, $charset);
	}
	$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("", array_slice($match[0], $start, $length));
	if ($suffix)
		return $slice."…";
	return $slice;
}

function rand_string($len = 6, $type = '', $addChars = '') {
	$str = '';
	switch ($type) {
	case 0:
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
		break;
	case 1:
		$chars = str_repeat('0123456789', 3);
		break;
	case 2:
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
		break;
	case 3:
		$chars = 'abcdefghijklmnopqrstuvwxyz'.$addChars;
		break;
	default:
		// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
		$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
		break;
	}
	if ($len > 10) { //位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	}
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for ($i = 0; $i < $len; $i++) {
			$str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		}
	}
	return $str;
}

function seed(){	//seed用户自定义函数以微秒作为种子
	list($msec, $sec) = explode(' ', microtime());
	return (float)$sec;
}

function randomkeys($length) {
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
	$key='';
	for ($i = 0; $i < $length; $i++) {
		$key.= $pattern{mt_rand(0, 35)}; //生成php随机数
	}
	return $key;
}

function random_num($length,$m=0){
	if($m===0){
		return domake_password($length);
	}else{
		if($m>$length){
			$low=$length;
			$upper=$m;
		}else{
			$upper=$length;
			$low=$m;
		}
		mt_srand((double)microtime() * 1000000);
		$randnum = mt_rand($low, $upper);
		return $randnum ;
	}
}

function domake_password($pw_length) {		//随机数
	$low_ascii_bound = 48;
	$upper_ascii_bound = 57;
	$notuse = array(58, 59, 60, 61, 62, 63, 64, 73, 79, 91, 92, 93, 94, 95, 96, 108, 111);
	$password1 = '';
	$i=0;
	while ($i < $pw_length) {
		mt_srand((double)microtime() * 1000000);
		$randnum = mt_rand($low_ascii_bound, $upper_ascii_bound);
		if (!in_array($randnum, $notuse)) {
			if ($i == 0 && $randnum == 0) {
				$i = 0;
				$password1 = '';
				domake_password(4);
			}
			$password1 = $password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}


//详细出处参考：http://www.jb51.net/article/13378.htm
class stmp{

	private $mailcfg=array();
	private $error_msg='';

	function __construct($mailcfg){

		$this->mailcfg=$mailcfg;

	}

	public function send($mail){
		$mailcfg=$this->mailcfg;
		if(!$fp = fsockopen($mailcfg['server'], $mailcfg['port'], $errno, $errstr, 30)) {
			return $this->error("($mailcfg[server]:$mailcfg[port]) CONNECT - Unable to connect to the SMTP server,"
				." please check your \"mail_config\".");
		}
		stream_set_blocking($fp, true);
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != '220') {
			return $this->error("$mailcfg[server]:$mailcfg[port] CONNECT - $lastmessage");
		}
		fputs($fp, ($mailcfg['auth'] ? 'EHLO' : 'HELO')." ".$mailcfg['auth_username']."\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250) {
			return $this->error("($mailcfg[server]:$mailcfg[port]) HELO/EHLO - $lastmessage");
		}
		while(1) {
			if(substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) {
				break;
			}
			$lastmessage = fgets($fp, 512);
		}
		if($mailcfg['auth']) {
			fputs($fp, "AUTH LOGIN\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 334) {
				return $this->error("($mailcfg[server]:$mailcfg[port]) AUTH LOGIN - $lastmessage");
			}
			fputs($fp, base64_encode($mailcfg['auth_username'])."\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 334) {
				return $this->error("($mailcfg[server]:$mailcfg[port]) USERNAME - $lastmessage");
			}

			fputs($fp, base64_encode($mailcfg['auth_password'])."\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 235) {
				return $this->error("($mailcfg[server]:$mailcfg[port]) PASSWORD - $lastmessage");
			}

			$email_from = $mailcfg['from'];
		}
		fputs($fp, "MAIL FROM: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from).">\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 250) {
			fputs($fp, "MAIL FROM: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from).">\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 250) {
				return $this->error("($mailcfg[server]:$mailcfg[port]) MAIL FROM - $lastmessage");
			}
		}

		$email_to=$mail['to'];
		foreach(explode(',', $email_to) as $touser) {
			$touser = trim($touser);
			if($touser) {
				fputs($fp, "RCPT TO: <$touser>\r\n");
				$lastmessage = fgets($fp, 512);
				if(substr($lastmessage, 0, 3) != 250) {
					fputs($fp, "RCPT TO: <$touser>\r\n");
					$lastmessage = fgets($fp, 512);
					return $this->error("($mailcfg[server]:$mailcfg[port]) RCPT TO - $lastmessage");
				}
			}
		}
		fputs($fp, "DATA\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 354) {
			return $this->error("($mailcfg[server]:$mailcfg[port]) DATA - $lastmessage");
		}
		$str="To: $email_to\r\nFrom: $email_from\r\nSubject: ".$mail['subject']."\r\n\r\n".$mail['content']
			."\r\n.\r\n";
		fputs($fp, $str);
		fputs($fp, "QUIT\r\n");
		return true;
	}

	public function get_error(){
		return $this->error_msg;
	}

	private function error($msg){
		$this->error_msg.=$msg;
		return false;
	}

}

function guid() {
	if (function_exists('com_create_guid')) {
		return com_create_guid();
	} else {
		mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45); // "-"
		$uuid = chr(123) // "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid, 12, 4).$hyphen
			.substr($charid, 16, 4).$hyphen
			.substr($charid, 20, 12)
			.chr(125); // "}"
	}
	return $uuid;
}

function uuid($hyphen='-',$prefix = '') {
//Example of using the function -
//Using without prefix.
//echo uuid(); //Returns like ‘1225c695-cfb8-4ebb-aaaa-80da344e8352′   
//Using with prefix
//echo uuid('-','urn:uuid:');//Returns like ‘urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344e8352′
	$chars = md5(uniqid(mt_rand(), true));
	$uuid = substr($chars, 0, 8).$hyphen
	.substr($chars, 8, 4).$hyphen
	.substr($chars, 12, 4).$hyphen
	.substr($chars, 16, 4).$hyphen
	.substr($chars, 20, 12);
	return $prefix.$uuid;
}

function kis_uuid($hyphen='',$prefix = '') {
//Example of using the function -
//Using without prefix.
//echo uuid(); //Returns like ‘1225c695-cfb8-4ebb-aaaa-80da344e8352′   
//Using with prefix
//echo uuid('-','urn:uuid:');//Returns like ‘urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344e8352′

// base on function uuid() ,mod for sorted
	//53d1be2f7b9392.93290838#53d1be2f-7b93-92$fe-7022-6a0493521f1c
	//53d1bdd7b0b6b#53d1bdd7-b0b6-b$db-bc4c-69b2cf0334ce
	$kk = uniqid('',true);	//53d1bc74439ba0.80927708
	$kk = explode('.', $kk);
	$kk= $kk[0];
	// $kk = uniqid();		//53d1bdd7b0b6b
	$jj=1;
	if(strlen($kk)>13){
		$jj=strlen($kk)-12;	//-13+1
	}
	$chars = md5(uniqid(mt_rand(), true));
	$uuid = substr($kk, 0, 8).$hyphen
	.substr($kk, 8, 4).$hyphen;
	$uuid .= substr($kk, 12, $jj).substr($chars, 12,(4-$jj)).$hyphen
	.substr($chars, 16, 4).$hyphen
	.substr($chars, 20, 12);
	return $prefix.$uuid;
}
 
function _uid(){
	//return 'not_ready_uid';
	$d='not_ready_uid';
	
	$key="email";	
	if(isset( $_SESSION[$key] )){
		return $_SESSION[$key];
	}
	$key="uid";
	$ret = isset( $_SESSION[$key] ) ?  $_SESSION[$key] : $d;
	return $ret;
}

function _split($p,$str){
	return explode($p,$str);
}

function remove_all_img($code) {
	//img,css,仅处理url为绝对地址
	$patterns = array("/(<img\s+.*src=[\"|']?)([^>\"'\s]+?)(\s*[^>]*>)/iesU",
		 "/(<link\s+.*href=[\"|']?)([^>\"'\s]+?)(\s*[^>]*>)/iesU");
	$replace = "";
	$code = preg_replace($patterns, $replace, $code);
	$code = stripslashes($code);
	//$code = preg_replace("/(<base href=(.*)\/>)/iesU", "", $code);
	return $code;
}

function remove_all_url($code) {
	//url,onpick,action,go,此处替换和加密url
	$patterns = array("/(<a\s+.*href=[\"|']?)([^>\"'\s]+?)(\s*[^>]*>)/iesU",
			"/(onpick=[\"|']?)([^>\"'\s]+?)(\s*[^>]*>)/iesU");
	$replace = "";
	$code = preg_replace($patterns, $replace, $code);
	
	$code = stripslashes($code);
	$code = preg_replace("/(<base href=(.*)\/>)/iesU", "", $code);
	
	$code = my_replace($code,'</a>','');
	return $code;
}

function _show_var($var){
	echo "<pre>".PHP_EOL;
	print_r($var);
	echo "</pre>".PHP_EOL;
}



function _kis_e($s){
	if($s=='') return '';
	$k='nowamagic';
	return encrypt($s, 'E', $k);
	//return base64_encode($s);
}
function _kis_d($s){
	if($s=='') return '';
	$k='nowamagic';
	$ret=encrypt($s, 'D', $k);
	if($ret==''){
		$s=str_ireplace(' ','+',$s);		//fix for url
		$ret=encrypt($s, 'D', $k);
	}
	return $ret;
	//return base64_decode($s);
}

function test_encrypt(){
	$id = 132;
	
	$token = encrypt($id, 'E', 'nowamagic');
	
	echo '加密:'.encrypt($id, 'E', 'nowamagic');
	echo '<br />';
	
	echo '解密：'.encrypt($token, 'D', 'nowamagic');
}

/*********************************************************************
函数名称:encrypt
函数作用:加密解密字符串
使用方法:
加密     :encrypt('str','E','nowamagic');
解密     :encrypt('被加密过的字符串','D','nowamagic');
参数说明:
$string   :需要加密解密的字符串
$operation:判断是加密还是解密:E:加密   D:解密
$key      :加密的钥匙(密匙);
*********************************************************************/
function encrypt($string,$operation,$key=''){
    $key=md5($key);
    $key_length=strlen($key);
    $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
    $string_length=strlen($string);
    $rndkey=$box=array();
    $result='';
    for($i=0;$i<=255;$i++)
    {
        $rndkey[$i]=ord($key[$i%$key_length]);
        $box[$i]=$i;
    }
    for($j=$i=0;$i<256;$i++)
    {
        $j=($j+$box[$i]+$rndkey[$i])%256;
        $tmp=$box[$i];
        $box[$i]=$box[$j];
        $box[$j]=$tmp;
    }
    for($a=$j=$i=0;$i<$string_length;$i++)
    {
        $a=($a+1)%256;
        $j=($j+$box[$a])%256;
        $tmp=$box[$a];
        $box[$a]=$box[$j];
        $box[$j]=$tmp;
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }
    if($operation=='D')
    {
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
        {
            return substr($result,8);
        }
        else
        {
            return'';
        }
    }
    else
    {
        return str_replace('=','',base64_encode($result));
    }
}

	
	
function gen_select_html($id,$arr_info,$title_n,$val_n,$val,$size=1,$disabled=false,$multiple=false,$title_need_decode=true){
	$a='multiple="multiple" ';
	$b='disabled="disabled" ';
	$c='';
	if($disabled==false) $a='';
	if($multiple==false) $b='';
	if($size>1) {
		$c=' size="'.$size.'" ';
	}
	$ret='<select name="'.$id.'" id="'.$id.'" '.$a.$b.$c.' >'.PHP_EOL;
	$len_id=0;
	
	if($val==''){
		$ret .='<option value="" selected="selected">请选择</option>'.PHP_EOL;
	}
	$tmp_array=array();

	if(is_array($arr_info)){
		//print_r($arr_info );
	}else{		
		return $ret.'</select>';
	}

	//echo 'title_n='.$title_n.'<br/>'.PHP_EOL;
	//echo 'val_n='.$val_n.'<br/>'.PHP_EOL;

	foreach($arr_info as $tmp_a){
		//echo print_r($tmp_a).PHP_EOL;
		$len_id++;
		//$tmp_val = $tmp_a[$val_n];
		if(isset($tmp_a[$val_n]) && isset($tmp_a[$title_n])){
			$tmp_val = $tmp_a[$val_n];
			$tmp_title = $tmp_a[$title_n];
		}else{
			echo ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
			echo ( 'MISS [val_n]('.$val_n.') or [title_n]('.$title_n.')');
			continue;
		}
		if($title_need_decode){
			$tmp_title = _kis_d($tmp_title);
		}
		//$tmp_array[$tmp_title]=$tmp_val;
		$tmp_array[$tmp_title]=$tmp_title . '$$$$$' . $tmp_val;
		//echo 'tmp_array['.$tmp_title.']=' . $tmp_title . '$$$$$' . $tmp_val.PHP_EOL;

	}
	$debug_html = '';
	//$debug_html .= print_r($tmp_array ,true);
	asort($tmp_array,SORT_STRING );
	//$debug_html .= print_r($tmp_array ,true);
	$len_id=0;
	foreach($tmp_array as $tmp_k=>$tmp_v){
		$len_id++;
		$tmp_arr = explode('$$$$$',$tmp_v);
		//echo 'count='.count($tmp_arr);
		//print_r($tmp_arr );
		if(count($tmp_arr)>1){
			$tmp_v=$tmp_arr[1];
			$tmp_t = $tmp_arr[0];
		}else{
			echo ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
			echo ( 'MISS [Val] or [Desc]');
			continue;
		}
		$tmp_checked = "";
		if($tmp_v==$val) {
			$tmp_checked = ' selected="selected"';
		}else{
			$tmp_checked = '';
		}
		if($title_need_decode){
			//$tmp_title = _kis_d($tmp_title);
		}
		$ret .='<option value="'.$tmp_v.'" '.$tmp_checked.'>'.($tmp_t).'</option>'.PHP_EOL;
	} 
	return $ret.'</select>'.$debug_html;
	
}

$kis_logger=null;

function kis_log($msg,$type){

	if(SERVER_SOFTWARE == 'bae/3.0'){
		return bae_log($msg,$type);
	}else if( defined('SAE_TMP_PATH') ){
		//return sae_log($msg,$type);
	}
	return false;
}

function bae_log($msg,$type=16){
	/*
	*代码示例， 利用BaeLog打印“轨迹”、“通知”、“调试”、“警告”和 *“致命”日志。
	* 1=>“Fatal”、2=>“Warning”4=>“Notice”、8=>“Trace”、 16=>“Debug”
	*/
	global $kis_logger;
	if(empty($kis_logger)) {
		require_once "BaeLog.class.php";
		 $kis_logger=BaeLog::getInstance();
	}
	$logger =  $kis_logger;
	
	switch ($type) {
	case 1:
		//打印一条致命日志
		$logger ->logFatal($msg);
		break;
	case 2:
		//打印一条警告日志
		$logger ->logWarning($msg);
		break;
	case 4:
		//打印一条通知日志
		$logger ->logNotice($msg);
		break;
	case 8:
		//打印一条轨迹日志
		$logger ->logTrace($msg);
		break;
	case 16:
		//打印一条调试日志
		$logger ->logDebug($msg);
		break;
	}

}

function sae_log($msg,$type){

}

$kis_cache_obj=null;
function kis_cache($op,$k,$v=null){

	if(defined('HTTP_BAE_ENV_APPID') ){
		return bae_cache($op,$k,$v);
	}else if( defined('SAE_TMP_PATH') ){
		//return sae_cache($op,$k,$v);
	}
	return false;
}

function bae_cache($op,$k,$v){
	global $kis_cache_obj;
	if(empty($kis_cache_obj)) {
		require_once ('BaeMemcache.class.php');
		$kis_cache_obj = new BaeMemcache();		
	}
	$mem=$kis_cache_obj;

	if($op=='set'){
		if(!empty($v)){
			$ret=$mem->add("key".$k,$v);
		}else{
			$ret=false;
		}
 		
	}else{
		$ret=$mem->get("key".$k);
	}

	return $ret;   
}

function gen_input($id,$val='',$class='',$max=32){
	$ret='<input name="'.$id.'" id="'.$id.'" class="'.$class.'" value="'.$val.'" maxlength="'.$max.'">';
	return $ret;
}

function _server_env_name(){
	$ret="local";
	if(defined('HTTP_BAE_ENV_APPID')){
		$ret="BAE";
	}else if (defined('SAE_TMP_PATH')){
		$ret="SAE";
	}
	return $ret;
}


function _kis_kkaiww($nickName){
	$retVal=$nickName;
/*		<option>kk@189</option>
		<option>ww@189</option>
		<option>kk@139</option>
		<option>ww@139</option>*/
	switch ($nickName) {
		default:
			# code...
			break;
	}
	return $retVal;
}

/*使用方法：
1. 获取当前时间戳(精确到毫秒)：microtime_float()
2. 时间戳转换时间：microtime_format('Y年m月d日 H时i分m秒 x毫秒', 1270626578.66000000)*/

/** 获取当前时间戳，精确到毫秒 */
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
/** 格式化时间戳，精确到毫秒，x代表毫秒 */
function microtime_format($time,$tag='')
{
	if(empty($tag)){
		$tag='Y年m月d日 H时i分m秒 x毫秒';
	}
	list($usec, $sec) = explode(".", $time);
	$date = date($tag,$usec);
	return str_replace('x', $sec, $date);
}


function debug_div($k,$v,$is_html=false){
	echo '<div style="background-color:#c8c8c8;">DEBUG:' .$k .'=<br/>'.PHP_EOL;
	if($is_html===true){
		echo '<pre>';
	}
	if(is_array($v)){
		print_r($v);
	}else{
		echo $v;
	}
	if($is_html===true){
		echo '</pre>';
	}
	echo PHP_EOL .'</div>'.PHP_EOL;
}

function gen_auto_close_html_v1($close_sec_num=6){
	$tmp_html = '<span id="jumpTo">'.$close_sec_num.'</span>秒后自动关闭！'.PHP_EOL;
	$tmp_html .= '<script type="text/javascript">closeit('.$close_sec_num.');</script>'.PHP_EOL;
	return $tmp_html;
}

function simple_auto_close_html($close_sec_num=6,$msg=''){
	$tmp_html = '';
	if(!empty($msg)){
		$tmp_html = $msg .'<br/><hr><br/>'.PHP_EOL ;
	}
	$tmp_html .= '<span id="jumpTo">'.$close_sec_num.'</span>秒后自动关闭！'.PHP_EOL;
	$tmp_html .= '<script type="text/javascript">closeit('.$close_sec_num.');</script>'.PHP_EOL;
	return $tmp_html;
}

function gen_auto_close_html($close_sec_num=6,$new_url='',$root_path=''){
	if(empty($root_path)){
		$root_path = c('root_path');
	}
	$tmp_html = '<br/><br/><h3><span id="jumpTo">'.$close_sec_num.'</span>秒后自动关闭！</h3><br/><br/>'.PHP_EOL;
	$tmp_html .= '<script type="text/javascript" src="'.$root_path.'/res/www.js">//</script>';
	if(empty($new_url)){
		$tmp_html .= '<script>closeit('.$close_sec_num.');</script>'.PHP_EOL;
	}else{
		$tmp_html .= '<script>countDown('.$close_sec_num.',"'.$new_url.'");</script>'.PHP_EOL;	
	}

	$tmp_html .= '<a href="'.$root_path.'/?a=index'.'">Open</a>';
	//$tmp_html = 'DISABLE! ' . __FUNCTION__ . '() !!!';
	return $tmp_html;
}

function kis_cache_get($key){
	$cachedatatxt  = _get_tempdir() . $key ;
	if(defined('HTTP_BAE_ENV_APPID')){
		$mem = new BaeMemcache();
		$ret = $mem->get($key);
        //echo ( 'result: ' . print_r ( $ret, true ) .'resultEnd') ;
        /*echo ( '<!-- DEBUG, ' . __FUNCTION__ . ' BaeMemcache.get OK !!!' ) ;
        echo ( 'result len: ' . strlen($ret) .' # -->'.PHP_EOL) ;*/
		if(!empty($ret)){
			return $ret;
		}
	}else{
		if(file_exists($cachedatatxt)){
			//debug("Load from cache file. ".$key);
			debug("Load from cache file. ".$cachedatatxt);
			return file_get_contents($cachedatatxt);
		}
	}
	return '';
} 

function kis_cache_set($key,$value){
	if(defined('HTTP_BAE_ENV_APPID')){
		$mem = new BaeMemcache();
		$ret = $mem->add($key,$value);
		/*echo ( '<!-- DEBUG, ' . __FUNCTION__ . ' BaeMemcache.add OK !!!' ) ;
        echo ( 'result: ' . print_r ( $ret, true ) .'resultEnd# -->'.PHP_EOL) ;*/
	}else{
		$cachedatatxt  = _get_tempdir() . $key ;
		//debug("Save to cache file. ".$key );
		debug("Save to cache file. ".$cachedatatxt );
		file_put_contents($cachedatatxt,$value);
	}
	return '';
}

function _get_local_root_path($lv=0){
	//DOCUMENT_ROOT	D:/green_servers/USBWebserver/8.5/root
	//SCRIPT_FILENAME	D:/green_servers/USBWebserver/8.5/root/appidjg6394hgny/2/test20130712-server-info.php
	$tmp_root=$_SERVER['DOCUMENT_ROOT'];
	$tmp_sfn = $_SERVER['SCRIPT_FILENAME'];
	$tmp_root_arr=explode('/', $tmp_root);
	$tmp_sfn_arr=explode('/', $tmp_sfn);
	//print_r($tmp_root_arr);
	//print_r($tmp_sfn_arr);
	$min=count($tmp_root_arr);
	if($lv===0){
		$max=count($tmp_sfn_arr)-1;
	}else{
		$max=$min+intval($lv);
	}
	
	$retVal='';
	for ($i=$min; $i < $max; $i++) { 
		$retVal .= '/' . $tmp_sfn_arr[$i];
	}
	return $retVal;
}


/**************************************************************
 *
 *	使用特定function对数组中所有元素做处理
 *	@param	string	&$array		要处理的字符串
 *	@param	string	$function	要执行的函数
 *	@return boolean	$apply_to_keys_also		是否也应用到key上
 *	@access public
 *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
 
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}
 
/**************************************************************
 *
 *	将数组转换为JSON字符串（兼容中文）
 *	@param	array	$array		要转换的数组
 *	@return string		转换得到的json字符串
 *	@access public
 *
 *************************************************************/
function JSON($array) {
	arrayRecursive($array, 'urlencode', true);
	//print_r($array);
	$json = json_encode($array);
	//return urldecode($json);
	$kk = urldecode($json);
	//print_r($kk);
	//$array = arrayRecursive($array, 'urldecode', true);
 	//print_r($array);
	//return $array;
	return $kk;
}

function _td($t,$ishead=false,$colspan='',$style=''){
	$tt='&nbsp;';
	if(empty($t)){
		$t = $tt;
	}
	$style .=' class="tab_right_bottom" valign="middle" align="left" ';
	$span_style=$ishead ? "STYLE1" : "STYLE2";
	if(!empty($colspan)){
		$kk=intval($colspan);
		if($kk>1){
			$style .= ' colspan="'.$kk.'" ';
		}
	}
	return '<td '.$style.'>'.'<span class="'.$span_style.'">'.$t.'</span></td>';
}


function load_his_cache($his_cache_filename,&$array,$backup=false){
	if(file_exists($his_cache_filename)){
		$his_cache = file_get_contents($his_cache_filename);
		
		//try load backup
		if(empty($his_cache) && $backup!==false){
			if(file_exists($his_cache_filename.'_backup.txt')){
				$his_cache2 = file_get_contents($his_cache_filename.'_backup.txt');
				if(!empty($his_cache2)){
					$his_cache = $his_cache2;
				}
			}
		}
		
		if(!empty($his_cache)){
			echo 'Load history cache :' . $his_cache_filename .' OK!!!'.PHP_EOL;
			$kk= json_decode($his_cache,true);
			if(is_array($kk)){
				$total_count=0;
				foreach ($kk as $key => $value) {
					if(strcmp('total_count', $key)!=0){
						$array[$key]=$value;
						++$total_count;
					}
				}
				$array['total_count']=$total_count;
			}else{
				//skip;
			}			
			return true;
		}else{
			echo 'Load history cache :' . $his_cache_filename .' Error!!!'.PHP_EOL;
			return false;
		}
	}
	echo 'Not Found history cache !!!'.PHP_EOL;
	return false;
}

function save_his_cache($his_cache_filename,&$arraymame,$backup=false){

	//try save backup
	if($backup!==false){
		if(file_exists($his_cache_filename.'_backup.txt')){
			copy($his_cache_filename.'_backup.txt',$his_cache_filename.'_backup2.txt');
		}
		copy($his_cache_filename, $his_cache_filename.'_backup.txt');
	}

	load_his_cache($his_cache_filename,$arraymame);

	//echo print_r($arraymame,true);
	$data=json_encode($arraymame);
	$retVal = file_put_contents($his_cache_filename,$data);
	if($retVal){
		echo 'Save history cache :' . $his_cache_filename .' OK!!!'.PHP_EOL;
		return true;
	}
	echo 'Save history cache :' . $his_cache_filename .' Error!!!'.PHP_EOL;
	return false;

}

function instr($s1,$s2){
	if(stripos($s1, $s2)!==false){
		return true;
	}else{
		return false;
	}
}


function kis_debug($n,$v){
	if(is_array($v)){
		$v2 = print_r($v,true);
	}else{
		$v2 = empty($v)? ($v.'[is_empty]') : $v;
	}	
	echo '<!-- DEBUG ['.$n.']: '.PHP_EOL.$v2.PHP_EOL.'# DEBUG ['.$n.'] END -->'.PHP_EOL;
	return true;
}


function _del_middle_str($s,$s1,$s2,$delimiter=''){
/*
* 在 $s 中，删除从 $s1 开始直到 $s2 结束的字符串，并将结果用 $delimiter 连接后返回.
* //_del_middle_str('xxaabbccyy','aa','cc','$$')='xx$$yy';
*/	

//kis_debug('DEBUG,' . __FUNCTION__ . '() s=',$s);
	//echo 'DEBUG,' . __FUNCTION__ . '() s1='.$s1.', s2='.$s2;
	if(stripos($s,$s1)!==false){
		$arr = explode($s1, $s);
		//print_r($arr);
		$tt = $arr[0];
		$tt2 = $arr[1];
		$l = count($arr);
		if($l>2){
			//echo 'DEBUG,' . __FUNCTION__ . '() 结果超过一组，只处理第一个!!!';
			for ($i=2; $i <$l ; $i++) { 
				$tt2 .= $s1.$arr[$i];
			}
		}
		//kis_debug('tt',$tt);
		//kis_debug('tt2',$tt2);
		
		if(stripos($tt2,$s2)!==false){
			$arr2 = explode($s2,$tt2);
			//print_r($arr2);
			$l = count($arr2);
			$ttb = $arr2[1];
			if($l>2){
				//echo 'DEBUG,' . __FUNCTION__ . '() 结果超过一组，只处理第一个!!! #2.';
				for ($i=2; $i <$l ; $i++) { 
					$ttb .= $s2.$arr2[$i];
				}
			}
			return $tt.$delimiter.$ttb;
		}else{
			return $tt.$delimiter.$tt2;
		}
	}else{
		return $s;
	}
}


function bin_check($str1,$str2, $low=0, $high=0, $k=0) {
//二分比较，找出 $str1,$str2 之间，相同的字符数目
	if($low===0 && $high===0 && $k===0){
		//init
		$len1=strlen($str1);
		$len2=strlen($str2);
		$high=$len1>$len2?$len2:$len1;
	}
    if ($low <= $high && strlen($str1) >= $high && strlen($str2) >= $high) {
        $mid = intval ( ($low + $high) / 2 );
        $tmp_str1=substr($str1, 0,$mid);
		$tmp_str2=substr($str2, 0,$mid);
		//echo ( 'DEBUG: ' . __FUNCTION__ . '() low='.$low.',high='.$high.',k='.$k.',mid='.$mid. PHP_EOL) ;
		if(strcmp($tmp_str1, $tmp_str2)==0){
			$k=$mid;
			return bin_check ( $str1,$str2, $mid + 1, $high, $k);
        }else if($high-$low>=2) {
            return bin_check ( $str1,$str2, $low, $mid - 1, $k);
        }
    }
    return $k;
}

function get_same_str($str1,$str2){
	if(empty($str1) || empty($str2)){
		return '';
	}
/*	$len1=strlen($str1);
	$len2=strlen($str2);
	$len3=$len1>$len2?$len2:$len1;
	$same_len=0;
	for ($i=0; $i <$len3 ; $i++) { 
		$tmp_str1=substr($str1, 0,$i);
		$tmp_str2=substr($str2, 0,$i);
		if(strcmp($tmp_str1, $tmp_str2)==0){
			$same_len=$i;
			echo ( 'DEBUG: ' . __FUNCTION__ . '() i='.$i. PHP_EOL) ;
		}else{
			break;
		}
	}
	echo 'bin_check='.bin_check($str1,$str2). PHP_EOL;
*/
	$same_len = bin_check($str1,$str2);
	return substr($str1, 0,$same_len);

}

function url_get_path($u,$c=1){
	echo ( 'DEBUG: ' . __FUNCTION__ . '() url='.$u. ',c='.$c. PHP_EOL) ;
	$c = intval($c);
	if($c<1) {
		$c=1;
	}
	$k=explode('/', $u);
	$j=max(1,(count($k)-$c));
	$k=array_slice($k,0,$j);
	$k=implode('/', $k);
	echo ( 'DEBUG: ' . __FUNCTION__ . '() result='.$k. PHP_EOL) ;
	return $k;
}


function get_web_root($web){
	//echo ( 'DEBUG: ' . __FUNCTION__ . '() web='.$web. PHP_EOL) ;
	if(empty($web)){
		return '';
	}
	
	if(stripos($web, '//')!==false){
		$t=explode('//', $web);
		$t=$t[1];
	}else{
		$t=$web;
	}
	if(stripos($t, '/')===false){
		return $t;
	}
	$t2=explode('/', $t);
	return $t2[0];
}


/**
* 可以统计中文字符串长度的函数
* @param $str 要计算长度的字符串
* @param $type 计算长度类型，0(默认)表示一个中文算一个字符，1表示一个中文算两个字符
*
*/
function abslength($str)
{
    if(empty($str)){
        return 0;
    }
    if(function_exists('mb_strlen')){
        return mb_strlen($str,'utf-8');
    }
    else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}


/*   
* 中文截取，支持gb2312,gbk,utf-8,big5  
*  
* @param string $str 要截取的字串  
* @param int $start 截取起始位置  
* @param int $length 截取长度  
* @param string $charset utf-8|gb2312|gbk|big5 编码  
* @param $suffix 是否加尾缀  
*/
function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=false) { 
	if(function_exists("mb_substr")){  
       if(mb_strlen($str, $charset) <= $length) return $str;  
       $slice = mb_substr($str, $start, $length, $charset);  
	}else{  
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";  
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";  
		$re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";  
		$re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";  
		preg_match_all($re[$charset], $str, $match);  
		if(count($match[0]) <= $length) return $str;  
		$slice = join("",array_slice($match[0], $start, $length));  
	}
	if($suffix) return $slice."…"; 
	return $slice; 
} 

function drop_last_char($value,$last_char_len=1)
{
    return substr($value,0,strlen($value)-$last_char_len);
}


function high_performance_mysql_limit_sql($table_name,$id,$where,$limit,$offset,$fields_str='*'){
//High Performance MySQL
// 优化前SQL: SELECT * FROM member ORDER BY last_active LIMIT 50,5 
// 优化后SQL: SELECT * FROM member INNER JOIN (SELECT member_id FROM member ORDER BY last_active LIMIT 50, 5) USING (member_id) 

	$sql = 'SELECT '.$fields_str.' FROM '.$table_name.' INNER JOIN (SELECT '.$id.' FROM '.$table_name.' '.$where.' LIMIT '.$limit.', '.$offset.') tt USING ('.$id.') ';
	return $sql;
}

function hp_mysql_count_sql($table_name,$where){
    $sql = 'SELECT COUNT(*) as num FROM '.$table_name.' '.$where;
    return $sql;
}

function get_safe_input_for_mysql($value)
{
	// 去除斜杠
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	// 如果不是数字则加引号
	if (!is_numeric($value))
	{
		$value = "'". mysql_real_escape_string($value) . "'";
	}
	return $value;
}


function debug_table(&$ret,$skip_item_str='',$show_table_head=true,$delimiter=null)
{
	$skip_item_arr=array();
	if(!empty($skip_item_str)){
		if($delimiter===null){
			$delimiter=PHP_EOL;
		}
		$skip_item_arr = explode($delimiter, $skip_item_str);
	}
	$ids=array();
	$attr_arr=array();
	$jj=0;

	$t_src='';
	$t_src= '<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" class="printtab"><tbody>'.PHP_EOL;
	if($show_table_head){
		$t_src.='<tr>'.PHP_EOL;
	}
	foreach ($ret as $key => $value) {
		if($key!=='total_count'){
			foreach ($value as $key1 => $value1) {
				$kk='';
				if(is_array($value1)){
					$kk = $key1.'()';
				}else{
					$kk = $key1;
					if(!empty($skip_item_str)){
						foreach ($skip_item_arr as $skip_item_key => $skip_item_value) {
							if($skip_item_value==$key1){
								$kk='';
								break;
							}
						}
					}
					if(!empty($kk)){
						$attr_arr[$kk]=$kk;
					}
				}
				// echo 'DEBUG,' . __FUNCTION__ . '() a='.$key1 .', b='.$value1.', kk='.$kk.PHP_EOL;
				if(!empty($kk)){
					$ids[$kk] = $kk;
					$jj++;
					if($show_table_head){
						$t_src.='	'._td($kk,true).PHP_EOL;
					}
					
				}				
			}
			if($jj>0) break;			
		}
	}
	if($show_table_head){
		$t_src.='</tr>'.PHP_EOL;
	}
	
	$disp_index=0;
	foreach ($ret as $key => $value) {
		if($key!=='total_count'){
			$disp_index++;
			$t_src.='<tr>'.PHP_EOL;
			$tmp_attr_arr=array();
			foreach ($attr_arr as $key3 => $value3) {
				$tmp_attr_arr[$key3]=$value3;
			}
			foreach ($ids as $key2 => $value2) {
				// echo 'DEBUG,' . __FUNCTION__ . '() a='.$key2 .', b='.$value2.PHP_EOL;
				$kk='';
				if( isset($value[$key2]) ){
					$kk = $value[$key2];
				}else{
					$tt=drop_last_char($key2,2);
					if(isset($value[$tt])){
						if( is_array($value[$tt]) ){
							foreach ($value[$tt] as $key3 => $value3) {
								$kk .= $key3.':'.$value3.'<br/>';
							}
							$kk = drop_last_char($kk) .'.';
						}else{
							$kk='ERROR!'.$key2.'#'.$value2;
						}
					}else{
						if(isset($tmp_attr_arr[$key2])){
							if(isset($tmp_attr_arr[$key]['done'])){
								$kk='N/A';
								// $kk.='#'.$key;
								// $kk.='#'.$key2;
								// $kk.='#'.$value2;
							}else{
								$tmp_attr_arr[$key]['done']=1;
								$kk='attr:'.$key . '=' .$value ;
								// $kk.='#'.$key;
								// $kk.='#'.$key2;
								// $kk.='#'.$value2;
							}
						}else{
							$kk='MISS';
						}						
					}

					
				}
				$t_src.='	'._td($kk).PHP_EOL;
			}

			$t_src.='</tr>'.PHP_EOL;

		}
	}

	$t_src.= '</tbody></table>'.PHP_EOL; 
	// echo $t_src;
	return $t_src;
	// $ret['table_src']=$t_src;
	// $ret['page_body']=$t_src;
}


function NoRand($begin=0,$end=10,$limit=1){ 
	$rand_array=range($begin,$end); 
	shuffle($rand_array);//调用现成的数组随机排列函数 
	return array_slice($rand_array,0,$limit);//截取前$limit个 
} 


function kis_debug_table(&$ret,$skip_item_str='',$show_table_head=true,
	$delimiter=null,$options_arr=null)
{
	//ver 2014

  if($delimiter===null){
    $delimiter=PHP_EOL;
  }
  $link_arr=array();
  $cn_head=array();
  $head_width=array();
  if($options_arr!=null){
    // echo 'DEBUG,' . __FUNCTION__ . '() options_arr not null !'.PHP_EOL;
    if(isset($options_arr['link_arr']) && !empty($options_arr['link_arr'])) {
      // echo 'DEBUG,' . __FUNCTION__ . '() link_arr not null !'.PHP_EOL;
      if(is_array($options_arr['link_arr'])){
        foreach ($options_arr['link_arr'] as $tmp_key => $tmp_value) {
          $link_arr[$tmp_key]=$tmp_value;
        }
      }else{
        $link_arr = explode($delimiter, $options_arr['link_arr']);
      }
    }
    if(isset($options_arr['cn_head']) && !empty($options_arr['cn_head'])) {
      // echo 'DEBUG,' . __FUNCTION__ . '() cn_head not null !'.PHP_EOL;
      if(is_array($options_arr['cn_head'])){
        foreach ($options_arr['cn_head'] as $tmp_key => $tmp_value) {
          $cn_head[$tmp_key]=$tmp_value;
        }
      }else{
        $cn_head = explode($delimiter, $options_arr['cn_head']);
      }
    }
    if(isset($options_arr['head_width']) && !empty($options_arr['head_width'])) {
      // echo 'DEBUG,' . __FUNCTION__ . '() head_width not null !'.PHP_EOL;
      if(is_array($options_arr['head_width'])){
        foreach ($options_arr['head_width'] as $tmp_key => $tmp_value) {
          $head_width[$tmp_key]=$tmp_value;
        }
      }else{
        $head_width = explode($delimiter, $options_arr['head_width']);
      }
    }
  }
  // echo 'DEBUG,' . __FUNCTION__ . '() '.print_r($link_arr,true).PHP_EOL;
  
  $skip_item_arr=array();
  if(!empty($skip_item_str)){   
    $skip_item_arr = explode($delimiter, $skip_item_str);
  }
  $ids=array();
  $attr_arr=array();
  $jj=0;

  $t_src='';
  $t_src= '<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" class="printtab"><tbody>'.PHP_EOL;
  if($show_table_head){
    $t_src.='<tr>'.PHP_EOL;
  }
  foreach ($ret as $key => $value) {
    if($key!=='total_count'){
    	if(!is_array($value)){
    		// echo 'DEBUG,' . __FUNCTION__ . '() key='.$key .', value='.$value.'<br/>'.PHP_EOL;
    		break;
    	}
      foreach ($value as $key1 => $value1) {
        $kk='';
        if(is_array($value1)){
          $kk = $key1.'()';
        }else{
          $kk = $key1;
          if(!empty($skip_item_str)){
            foreach ($skip_item_arr as $skip_item_key => $skip_item_value) {
              if($skip_item_value==$key1){
                $kk='';
                break;
              }
            }
          }
          if(!empty($kk)){
            $attr_arr[$kk]=$kk;
          }
        }
        // echo 'DEBUG,' . __FUNCTION__ . '() a='.$key1 .', b='.$value1.', kk='.$kk.PHP_EOL;
        if(!empty($kk)){
          $ids[$kk] = $kk;
          $jj++;
          if($show_table_head){
          	$head_width_style = '';
            foreach ($head_width as $head_width_key => $head_width_value) {
            	// echo 'DEBUG,' . __FUNCTION__ . '() head_width_key='.$head_width_key .', head_width_value='.$head_width_value.', kk='.$kk.PHP_EOL;
            	 if($kk==$head_width_key){
            	 	$head_width_style = ' width="' . $head_width_value . '" ' ;
            	 	break;
            	 }
            }
            foreach ($cn_head as $cn_head_key => $cn_head_value) {
              if($kk==$cn_head_key){
                $kk=$cn_head_value;
                break;
              // }else{
                // echo 'DEBUG,' . __FUNCTION__ . '() cn_head_key='.$cn_head_key .', cn_head_value='.$cn_head_value.', kk='.$kk.PHP_EOL;
              }
            }

            $t_src.=' '._td($kk,true,'',$head_width_style).PHP_EOL;
          }
          
        }
      }
      if($jj>0) break;
    }
  }
  if($show_table_head){
    $t_src.='</tr>'.PHP_EOL;
  }
  
  $disp_index=0;
  foreach ($ret as $key => $value) {
    if($key!=='total_count'){
      $disp_index++;
      $t_src.='<tr>'.PHP_EOL;
      $tmp_attr_arr=array();
      foreach ($attr_arr as $key3 => $value3) {
        $tmp_attr_arr[$key3]=$value3;
      }
      foreach ($ids as $key2 => $value2) {
        // echo 'DEBUG,' . __FUNCTION__ . '() a='.$key2 .', b='.$value2.PHP_EOL;
        $kk='';
        if( isset($value[$key2]) ){
          $kk = $value[$key2];
        }else{
          $tt=drop_last_char($key2,2);
          if(isset($value[$tt])){
            if( is_array($value[$tt]) ){
              foreach ($value[$tt] as $key3 => $value3) {
                $kk .= $key3.':'.$value3.'<br/>';
              }
              $kk = drop_last_char($kk) .'.';
            }else{
              $kk='ERROR!'.$key2.'#'.$value2;
            }
          }else{
            if(isset($tmp_attr_arr[$key2])){
              if(isset($tmp_attr_arr[$key]['done'])){
                $kk='N/A';
                // $kk.='#'.$key;
                // $kk.='#'.$key2;
                // $kk.='#'.$value2;
              }else{
                $tmp_attr_arr[$key]['done']=1;
                $kk='attr:'.$key . '=' .$value ;
                // $kk.='#'.$key;
                // $kk.='#'.$key2;
                // $kk.='#'.$value2;
              }
            }else{
              $kk='MISS';
            }           
          }
        }
        $tmp_link_str='';
        foreach ($link_arr as $link_key => $link_value) {
          if($link_key==$key2){
            $tmp_link_str=$link_value;
            //code=>/civitas/data_showEstatesDetails.php?code=[code]|link
            $tmp_arr = explode('|', $tmp_link_str);
            if( (isset($tmp_arr[1]) && $tmp_arr[1]=='js') ){
              //TODO
            }elseif( (isset($tmp_arr[1]) && $tmp_arr[1]=='img') ){
              $tmp = str_ireplace('['.$link_key.']', $kk, $tmp_arr[0]);
              $kk = trim($kk);
              $tmp_link_str = '<img src="'.$kk.'" >'.$kk;
            }else{
              //default link mode
              $tmp = str_ireplace('['.$link_key.']', $kk, $tmp_arr[0]);
              if(stripos($tmp, '[code]')!==false && isset($value['code'])){
                $tmp = str_ireplace('[code]', $value['code'], $tmp);
              }
              $tmp = trim($tmp);
              $kk = trim($kk);
              $tmp_link_str = '<a href="'.$tmp.'" target="_BLANK">'.$kk.'</a>';
            }
            break;
          }
        }
        if(empty($tmp_link_str)){
          $tmp_link_str = $kk;
        }
        $t_src.=' '._td($tmp_link_str).PHP_EOL;
      }

      $t_src.='</tr>'.PHP_EOL;

    }
  }

  $t_src.= '</tbody></table>'.PHP_EOL; 
  // echo $t_src;
  return $t_src;
  // $ret['table_src']=$t_src;
  // $ret['page_body']=$t_src;
}

function html_tag_a($href,$title,$alt=''){
	if(empty($alt)){
		$alt = $title;
	}
	return '<a href="'.$href.'" title="'.$alt.'" target="_BLANK">'.$title.'</a>';
}

function kis_debug_table_2013(&$ret,$skip_item_str='',$show_table_head=true,$delimiter=null,$options_arr=null)
{
	if($delimiter===null){
		$delimiter=PHP_EOL;
	}
	$link_arr=array();
	if($options_arr!=null){
		// echo 'DEBUG,' . __FUNCTION__ . '() options_arr not null !'.PHP_EOL;
		if(isset($options_arr['link_arr']) && !empty($options_arr['link_arr'])) {
			// echo 'DEBUG,' . __FUNCTION__ . '() link_arr not null !'.PHP_EOL;
			if(is_array($options_arr['link_arr'])){
				foreach ($options_arr['link_arr'] as $tmp_key => $tmp_value) {
					$link_arr[$tmp_key]=$tmp_value;
				}
			}else{
				$link_arr = explode($delimiter, $options_arr['link_arr']);
			}
		}
	}
	// echo 'DEBUG,' . __FUNCTION__ . '() '.print_r($link_arr,true).PHP_EOL;
	
	$skip_item_arr=array();
	if(!empty($skip_item_str)){		
		$skip_item_arr = explode($delimiter, $skip_item_str);
	}
	$ids=array();
	$attr_arr=array();
	$jj=0;

	$t_src='';
	$t_src= '<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" class="printtab"><tbody>'.PHP_EOL;
	if($show_table_head){
		$t_src.='<tr>'.PHP_EOL;
	}
	foreach ($ret as $key => $value) {
		if($key!=='total_count'){
			foreach ($value as $key1 => $value1) {
				$kk='';
				if(is_array($value1)){
					$kk = $key1.'()';
				}else{
					$kk = $key1;
					if(!empty($skip_item_str)){
						foreach ($skip_item_arr as $skip_item_key => $skip_item_value) {
							if($skip_item_value==$key1){
								$kk='';
								break;
							}
						}
					}
					if(!empty($kk)){
						$attr_arr[$kk]=$kk;
					}
				}
				// echo 'DEBUG,' . __FUNCTION__ . '() a='.$key1 .', b='.$value1.', kk='.$kk.PHP_EOL;
				if(!empty($kk)){
					$ids[$kk] = $kk;
					$jj++;
					if($show_table_head){
						$t_src.='	'._td($kk,true).PHP_EOL;
					}
					
				}
			}
			if($jj>0) break;
		}
	}
	if($show_table_head){
		$t_src.='</tr>'.PHP_EOL;
	}
	
	$disp_index=0;
	foreach ($ret as $key => $value) {
		if($key!=='total_count'){
			$disp_index++;
			$t_src.='<tr>'.PHP_EOL;
			$tmp_attr_arr=array();
			foreach ($attr_arr as $key3 => $value3) {
				$tmp_attr_arr[$key3]=$value3;
			}
			foreach ($ids as $key2 => $value2) {
				// echo 'DEBUG,' . __FUNCTION__ . '() a='.$key2 .', b='.$value2.PHP_EOL;
				$kk='';
				if( isset($value[$key2]) ){
					$kk = $value[$key2];
				}else{
					$tt=drop_last_char($key2,2);
					if(isset($value[$tt])){
						if( is_array($value[$tt]) ){
							foreach ($value[$tt] as $key3 => $value3) {
								$kk .= $key3.':'.$value3.'<br/>';
							}
							$kk = drop_last_char($kk) .'.';
						}else{
							$kk='ERROR!'.$key2.'#'.$value2;
						}
					}else{
						if(isset($tmp_attr_arr[$key2])){
							if(isset($tmp_attr_arr[$key]['done'])){
								$kk='N/A';
								// $kk.='#'.$key;
								// $kk.='#'.$key2;
								// $kk.='#'.$value2;
							}else{
								$tmp_attr_arr[$key]['done']=1;
								$kk='attr:'.$key . '=' .$value ;
								// $kk.='#'.$key;
								// $kk.='#'.$key2;
								// $kk.='#'.$value2;
							}
						}else{
							$kk='MISS';
						}						
					}
				}
				$tmp_link_str='';
				foreach ($link_arr as $link_key => $link_value) {
					if($link_key==$key2){
						$tmp_link_str=$link_value;
						//code=>/civitas/data_showEstatesDetails.php?code=[code]|link
						$tmp_arr = explode('|', $tmp_link_str);
						if( (isset($tmp_arr[1]) && $tmp_arr[1]=='js') ){
							//TODO
						}else{
							//default link mode
							$tmp = str_ireplace('['.$link_key.']', $kk, $tmp_arr[0]);
							if(stripos($tmp, '[code]')!==false && isset($value['code'])){
								$tmp = str_ireplace('[code]', $value['code'], $tmp);
							}
							$tmp_link_str = '<a href="'.$tmp.'" target="_BLANK">'.$kk.'</a>';
						}
						break;
					}
				}
				if(empty($tmp_link_str)){
					$tmp_link_str = $kk;
				}
				$t_src.='	'._td($tmp_link_str).PHP_EOL;
			}

			$t_src.='</tr>'.PHP_EOL;

		}
	}

	$t_src.= '</tbody></table>'.PHP_EOL; 
	// echo $t_src;
	return $t_src;
	// $ret['table_src']=$t_src;
	// $ret['page_body']=$t_src;
}



function getidbyweight($aFileds) {	//有权重的随机选择
/***********  
$aFileds = $arrayName = array(array('id' =>'cat1' , 'weight'=>10)
		,array('id' =>'cat2' , 'weight'=>30)
		,array('id' =>'cat3' , 'weight'=>50)
	);
************/  
    global $_SGLOBAL;   
    $iCount=count($aFileds);   
    if($iCount>=2)   
    {   
        $iLine=0;   
        for ($i=0;$i<$iCount;$i++)   
        {   
            $aFileds[$i]['start']=$iLine+1;   
            $iLine +=$aFileds[$i]['weight'];   
            $aFileds[$i]['end']=$iLine;
        }
        // echo ('DEBUG,' . __FUNCTION__ . '() tmp array : '.print_r($aFileds,true) .PHP_EOL);
         
        $result=mt_rand(1, $iLine);   
        // echo ('DEBUG,' . __FUNCTION__ . '() mt_rand : '.$result .PHP_EOL);
        for ($i=0;$i<$iCount;$i++)   
        {   
            if($result>=$aFileds[$i]['start'] && $result<=$aFileds[$i]['end']){
            	// echo ('DEBUG,' . __FUNCTION__ . '() get id : '.$aFileds[$i]['id'] .PHP_EOL);
                return $aFileds[$i]['id'];
            }
        }  
    }
    elseif($iCount==1)   
    {   
        return $aFileds[0]['id'];   
    }   
       
}  


/**
* 多个连续空格只保留一个
*
* @param string $string 待转换的字符串
* @return unknown
*/
//static public 
function merge_spaces ( $string )
{
	return preg_replace ( "/\s(?=\s)/","\\1", $string );
}

//
function _str_key($s,$d=PHP_EOL,$n=' '){
	$ta =explode($d, $s);
	$t='';
	foreach ($ta as $key => $value) {
		if(!empty($value)){
			$t .= $value . $n;
		}
	}
	return $t;
}

function my_str_key($s){
	if(empty($s)) return '';

	$t = trim($s);
	// $t = str_ireplace('  ', ' ', $t);
	//去除多余的空格和换行符，只保留一个
	//$t = preg_replace("/([\s]{2,})/","\\1",$t);
	$t = merge_spaces($t);

	$t =_str_key($t);
	$t =_str_key($t,"\r");
	$t =_str_key($t,"\n");
	$t =_str_key($t,"\t");

	$t = merge_spaces($t);
	$t = trim($t);
		
	return $t;
}


function func_runtime_env_check()
{
	if(isset($GLOBALS['config']['runtime_env_check'])){
		$runtime_env_check=$GLOBALS['config']['runtime_env_check'];	
		if(v('runtime_debug')) echo PHP_EOL.'runtime_env_check =' . $runtime_env_check .' !'. PHP_EOL;
	}else{
		if(v('runtime_debug')) echo PHP_EOL.'NOT Set runtime_env_check !'. PHP_EOL;
		
		$runtime_env_check='';

		if(defined('SERVER_SOFTWARE')){
			//SERVER_SOFTWARE = bae/3.0
			$runtime_env_check=strtolower(SERVER_SOFTWARE);
			if(stripos($runtime_env_check,'bae')!==false){
				if(v('runtime_debug')){
					echo 'SERVER_SOFTWARE =' . SERVER_SOFTWARE .' !'. PHP_EOL;
				}
			}
			// $GLOBALS['config']['site_root_path'] = '';

		}elseif (defined('SAE_APPNAME')) {
			$runtime_env_check='sae';
			// $GLOBALS['config']['site_root_path'] = '';
			
		}else{
			//local php env
			$url = $_SERVER['PHP_SELF']; 
			//if(stripos($url,'teamtoy2b2097_mod_xp')!==false){
			//	$GLOBALS['config']['site_root_path'] = '/teamtoy2b2097_mod_xp';
			//}else{
				//echo $url;	///teamtoy2b2097_mod_xp/index.php
				$tt = str_ireplace('/index.php','',$url);
				// $GLOBALS['config']['site_root_path'] = $tt;
			//}
			$runtime_env_check='local';
		}

	}
	return $runtime_env_check;
}

function get_table_name($t){
	return $t;
}

function die403(){
	die('403 Access Denied/Forbidden');
}

function kis_dice($a=1,$b=6,$c=0)
{
	$ret = array('num'=>0,'msg'=>'');
	if(intval($a)<1){
		$ret['msg'] .= '0';
	}
	for ($i=0; $i <$a ; $i++) { 
		$t = mini_trpg_dice($b);
		$ret['num'] += $t;
		$ret['msg'] .= $t . '+';
	}
	if(strlen($ret['msg']>1)) $ret['msg']=drop_last_char($ret['msg']);
	if($c!=0){
		$ret['num'] += $c;
		$ret['msg'] .= '+' . $c ;	
	}	
	return $ret;
}

function mini_trpg_dice($d=6)		//1d6
{
	if($d<2){
		$d=2;
	}elseif ($d>100) {
		$d=100;
	}
	//range 是将1到$d 列成一个数组 
	$numbers = range (1,$d); 
	//shuffle 将数组顺序随即打乱 
	shuffle ($numbers); 
	//array_slice 取该数组中的某一段 
	$result = array_slice($numbers,0,1); 
	// echo print_r($result);
	return intval($result[0]);
}

 
function getIP() { 
	if (getenv('HTTP_CLIENT_IP')) { 
		$ip = getenv('HTTP_CLIENT_IP'); 
	}elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
		$ip = getenv('HTTP_X_FORWARDED_FOR'); 
	}elseif (getenv('HTTP_X_FORWARDED')) { 
		$ip = getenv('HTTP_X_FORWARDED'); 
	}elseif (getenv('HTTP_FORWARDED_FOR')) { 
		$ip = getenv('HTTP_FORWARDED_FOR'); 
	}elseif (getenv('HTTP_FORWARDED')) { 
		$ip = getenv('HTTP_FORWARDED'); 
	}else { 
		$ip = $_SERVER['REMOTE_ADDR']; 
	} 
	return $ip; 
}


function get_timestamp(){
	list($usec, $sec) = explode(" ", microtime());
	// echo microtime().PHP_EOL;
	// echo $usec.PHP_EOL;
	// echo $sec.PHP_EOL;
	$tt = ((float)$usec + (float)$sec);
	// echo $tt.PHP_EOL;
	$kk = sprintf("%.3f", $tt);  
	// echo $kk.PHP_EOL;
	return str_replace('.', '', $kk);
}

function jsDateGetTime(){
	return get_timestamp();
}

function get_skip_item_str_for_debug_table(&$ret,$show_item_arr){
	$skip_item_str = '';
    // $show_item_arr = array('title','code','create_date','modify_date','parent_id');
    $tmpArr = array();
    foreach ($ret as $key1 => $value1) {
        if(is_array($value1)){
            foreach ($value1 as $key2 => $value2) {
                if(!in_array($key2, $show_item_arr)){
                    if(!in_array($key2, $tmpArr))
                        array_push($tmpArr, $key2);
                }
                
            }
        }
    }
    $skip_item_str = implode(PHP_EOL, $tmpArr);
    return $skip_item_str;
}




## ############################################################################
## Password hashing
## ############################################################################

/**
 * Static function to abstract password encryption
 *
 * @param string $string String to encrypt
 * @param string $salt Salt value
 * @return string SHA1-encrypted and salted hash
 */
function hash_password($plaintext, $salt)
{
    return sha1("{$plaintext}_{$salt}");
}

/**
 * Generate a string suitable for use as a password salt
 *
 * @return string
 */
function generate_salt()
{
    $chars = array(
        'a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I',
        'j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R',
        's','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z',
        
        '1','2','3','4','5','6','7','8','9','0',
        
        '!','@','#','$','%','^','&','*','_','+','|'
    );

    $max_chars = count($chars) - 1;
    srand( (double) microtime() * 1000000);
    
    $salt_length = rand(8, 20);

    $retval = '';
    for($i = 0; $i < $salt_length; $i++)
    {
        $retval = $retval . $chars[rand(0, $max_chars)];
    }

    return $retval;
}


function basic_html($body='',$title=''){
	return '<!DOCTYPE html>
<html><head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<title>'.$title.'</title>
</head>
<body>
'.$body.'
</body>
</html>';
}