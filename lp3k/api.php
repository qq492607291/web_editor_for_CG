<?php

if(!isset($_GET['c']) || !isset($_GET['a']) ){
	die('Access Denied/Forbidden');
}

define( 'DS' , DIRECTORY_SEPARATOR );
define( 'APP_ROOT' , dirname( __FILE__ ) . DS  );

date_default_timezone_set("Asia/Shanghai");
// header("Content-Type:text/html;charset=utf-8");
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

//define( 'KIS_APP_ROOT' , dirname( dirname( APP_ROOT ) ) . DS );
define( 'KIS_APP_ROOT' ,APP_ROOT );
define( 'AROOT' , KIS_APP_ROOT);
define( 'CROOT' , KIS_APP_ROOT.'_lp'. DS.'core'. DS  );
//include_once KIS_APP_ROOT.'ext_lib'. DS.'comm.function.php';
include_once CROOT. 'lib'.DS.'core.function.php';

//@include_once( AROOT . 'lib' . DS . 'app.function.php' );

//include_once('php'. DS .'comm.inc.php');
//include_once('php'. DS .'func.inc.php');
//include_once('php'. DS .'map.inc.php');


define('SPACE', '&nbsp;');

/*if($ContentType =='text/html'){
	echo '<body style="background:#cce8cf;">'.PHP_EOL;
}*/


/*
foreach ($_SERVER as $key => $value) {
	echo $key.'='.$value.'<br/>'.PHP_EOL;
}
*/


/**

*/


/**

*/


/*
$tt='';
foreach ($_GET as $key => $value) {
  $tt .= 'GET:'.$key . '=' . $value.PHP_EOL;
}
foreach ($_POST as $key => $value) {
  $tt .= 'POST:'.$key . '=' . $value.PHP_EOL;
}
foreach ($_SERVER as $key => $value) {
  $tt .= '_SERVER:'.$key . '=' . $value.PHP_EOL;
}
echo $tt;
*/


/**


**/

/**

*/


function time_elapsed_second($startdate,$enddate){
	$second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
	return $second;
}



/**


**/

function load_json_config($fileName){
	if(file_exists($fileName)){
		$json_string=file_get_contents($fileName);
		if(empty($json_string)) return false;
		$json = json_decode($json_string, true);	// 把JSON字符串转成PHP数组
		return $json;	
	}
	return false;
}
function save_json_config($fileName,$json){
	if(file_exists($fileName)){
		$json_string=file_get_contents($fileName);
		if(empty($json_string)) return false;
		$json_string = json_encode($json);
		file_put_contents($fileName, $json_string);
	}
	return false;
}

function getfiles($path,$add_path=1){
	$list=array();
	if ($handle=opendir($path)){
		while (false !== ($file = @readdir($handle))) {

			$fullpath=$path.'/'.$file;
			if(	!(	substr($file,0,1)=='.' and is_dir($fullpath) )
			and in_array( strtolower(substr($file,-3)), array ('jpg','gif','png'))
			){
				if($add_path){
					$list[]=$path.'/'.$file;
				}else{
					$list[]=$file;
				}	
			}
		
		}
		return $list;
	}
}

/**

	copy from comm.inc.php

*/

function get_sql_table_name(){
    global $sql_table_name;
    $sql_table_name = 'staff_checkinout'; 
    return $sql_table_name;
}

function init_return_array()
{
	$ret = array('return_code' =>0,'return_message' =>'','appver'=>0,'update_url'=>'');
	return $ret;
}

function debug_log($app,$msg){
	//skip
}

function _dev_debug($method,$src){
    // _dev_debug(__METHOD__,'['.$book_title.'] ! ');
  echo PHP_EOL.'<!-- DEBUG: '.$method.'() '.PHP_EOL.$src.PHP_EOL.' -->'.PHP_EOL;
}

/**
 
	copy from comm.function.php

**/

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

function _today_str(){
	return date('Y-m-d');
}

function _time_str(){
	return date('Y-m-d H:i:s');
}

function get_month($day=null){
	if($day==null){
		$m= date('m');
	}else{
		//转换成时间戳
		$timestrap=strtotime($day);	
		//格式化，取出月份
		$m= date('m',$timestrap);
	}
	return intval($m);
}

function get_year($day=null){
	if($day==null){
		$y= date('Y');
	}else{
		//转换成时间戳
		$timestrap=strtotime($day);	
		//格式化，取出月份
		$y= date('Y',$timestrap);
	}
	return intval($y);
}

function kis_debug_table(&$ret,$skip_item_str='',$show_table_head=true,
	$delimiter=null,$options_arr=null)
{
	//ver 2014
	if( ! is_array($ret) ){
		die(__METHOD__.'() parm error! Need a Array!');
	}

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

            $t_src.=' '. _td($kk,true,'',$head_width_style).PHP_EOL;
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
            $kk='Nil';
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

function drop_last_char($value,$last_char_len=1)
{
    return substr($value,0,strlen($value)-$last_char_len);
}

function _td($t,$ishead=false,$colspan='',$style=''){
	//echo __METHOD__.$t;
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

/**

*/

function html_span($txt,$color='#f00'){
	if(substr($color, 0,1)!='#'){
		$color='#'.$color;
	}
	return '<span style="color: '.$color.';">'.$txt.'</span>';
}

/**

*/

function get_month_days($ymd){
	$time = strtotime($ymd);
    $mday = $time["mday"];
    $mon = $time["mon"];
    $year = $time["year"];
        
    if($mon==4||$mon==6||$mon==9||$mon==11){
        $day = 30;
    }elseif($mon==2){
        if(($year%4==0&&$year%100!=0)||$year%400==0){
            $day = 29;
        }else{
            $day = 28;
        }
    }else{
        $day = 31;
    }
    return $day;
}

function get_local_DbPath(){
	global $localDbPath;
	return $localDbPath.'\\';
}



function getDebugInfo(){
    $tt='GET:'.PHP_EOL;
  $tmpP='';
  foreach ($_GET as $key => $value) {
    $tt .= $key . '=' . $value.PHP_EOL;
    $tmpP .= $key . '=' . $value.'&';
  }
  //$tt.='POST:'.PHP_EOL;
  $tt2='';
  foreach ($_POST as $key => $value) {
    $tt2 .= $key . '=' . $value.PHP_EOL;
  }
  if(!empty($tt2)){
    $tt.='POST:'.PHP_EOL.$tt2;
  }

  if(isset($_GET['timestamp'])){
    $sVerifyTimeStamp = $_GET['timestamp'];
  }else{
    $sVerifyTimeStamp = time();
  }

  $tmpFN='tmp/tmp'.$sVerifyTimeStamp.'.tmp.txt';
  //$tmpSrc=file_get_contents($tmpFN);
  //$tmpSrc.='--------- --------- --------- --------- --------- '.PHP_EOL.PHP_EOL.PHP_EOL.$tmpP;
  $tmpSrc=$tmpP;
  $tmpSrc.=PHP_EOL.PHP_EOL.PHP_EOL.$tt;
  file_put_contents($tmpFN, $tmpSrc);  
}


function get_wechat_msg_time_by_staffCode_YMD($StaffCode,$ymd){
  //SELECT `id`, `StaffCode`, `CHECKTIME`, `MachineAlias` FROM `staff_checkinout` WHERE 1
  //SELECT * FROM  `staff_checkinout` WHERE  `StaffCode` =  '1417'
  global $debug_mode;

  $ymd2=date('Y-m-d H:i:s',strtotime($ymd));
  // if($ymd2<'2018-10-01'){
  //   $tableFix='_his';
  // }else{
 $tableFix='';
  // }
  $tmp_sql =" SELECT min(MSG_TIME) as time1 ,max(MSG_TIME) as time2 FROM `wechat_msg".$tableFix."` WHERE MOD(`StaffCode`+0 ,10000)=".intval($StaffCode)." AND `MSG_TIME` = '".$ymd2."' "; 
  $sql_ret =get_line($tmp_sql);
  if($debug_mode){
    echo 'tmp_sql='.$tmp_sql.PHP_EOL;
    echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  }
  if($sql_ret && isset($sql_ret['time1']) && isset($sql_ret['time2'])){
    if(!empty($sql_ret['time1']) && !empty($sql_ret['time2'])){
      return $sql_ret;    
    }
  }
  return false;
}


function add_new_wechat_msg($staffcode,$CHECKTIME,$MESSAGE,$mode=1){
  //global $debug_mode;
  ks_acl();
/*
INSERT INTO `staff_checkinout`(`id`, `StaffCode`, `CHECKTIME`, `MESSAGE`) VALUES ([value-1],[value-2],[value-3],[value-4])
*/
  

  $staffcodeNew=fmt_staffcode($staffcode);

  $CHECKTIME=ymd_time_fmt($CHECKTIME);
  
  //SELECT * FROM `leave_info_diff` WHERE 
  $tmp_sql2=" SELECT count(*) as num FROM `wechat_msg` WHERE `StaffCode`+0=?i AND `MSG_TIME`=?s ";
  $tmp_sql2 =prepare($tmp_sql2,array($staffcodeNew,$CHECKTIME));
  $sql_ret2 =get_var($tmp_sql2);
  if($sql_ret2){
    if(intval($sql_ret2)>0){
      if($mode==1) echo html_span($staffcode.'-'.$CHECKTIME.'-'.$MESSAGE.' exist').PHP_EOL;  
      return array('retCode'=>1000,'retMsg'=>'exist');
    }else{
      if($mode==1) echo 'sql_ret='.print_r($sql_ret2,true).PHP_EOL; 
      return false;
    }
  }

  $tmp_sql =" INSERT INTO `wechat_msg`( `StaffCode`, `MSG_TIME`, `MESSAGE`) VALUES (?s,?s,?s) ";  
  $tmp_sql =prepare($tmp_sql,array($staffcodeNew,$CHECKTIME,$MESSAGE));
  $sql_ret =run_sql($tmp_sql);
  //if($debug_mode){
    if($mode==1) {
      echo 'tmp_sql='.$tmp_sql.PHP_EOL;
      echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
    }
  //}
  return array('retCode'=>0,'retMsg'=>$sql_ret);;
}

function fmt_staffcode($staffcode){
  $debug_mode=0;
  if($debug_mode) echo '<br/>'.PHP_EOL;
  if($debug_mode) echo __METHOD__.'() in staffcode='.$staffcode;
  $step_id=1;
  $_staffcode=trim($staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=str_replace('#', '', $_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=str_replace('`', '', $_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=str_replace("'", '', $_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=str_replace(PHP_EOL, '', $_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=str_replace(' ', '', $_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=trim($_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  $_staffcode=0+intval($_staffcode);
  if($debug_mode) echo __METHOD__.'() #'.$step_id++. ' _staffcode='.$_staffcode.'<br/>'.PHP_EOL;
  
  $_staffcode=substr('00000'.$_staffcode,-5);
  if($debug_mode) echo __METHOD__.'() out staffcode='.$_staffcode;
  return $_staffcode;
}

function ymd_fmt($leaveDate){
  $leaveDate=date_format(date_create($leaveDate),'Y-m-d');
  return $leaveDate;
}

function YmdHis_fmt($leaveDate){
  //date('Y-m-d H:i:s');
  $leaveDate=date_format(date_create($leaveDate),'Y-m-d H:i:s');
  return $leaveDate;
}

function ymd_time_fmt($leaveDate){
  //date('Y-m-d H:i:s');
  $leaveDate=date_format(date_create($leaveDate),'Y-m-d H:i:s');
  return $leaveDate;
}


function add_new_Messsage($taskMode,$staffcode,$CHECKTIME2,$MESSAGE,$debugMode=1){
  //global $debug_mode;
  ks_acl();

  $staffcodeNew=fmt_staffcode($staffcode);
  $CHECKTIME=ymd_time_fmt($CHECKTIME2);

  if($taskMode==1){
    $sql_table_name='wechat_msg';
  }else{
     die(__METHOD__.'() Invalid parameters !');
  }
  
  $tmp_sql2=" SELECT count(*) as num FROM `".$sql_table_name."` WHERE `StaffCode`+0=?i AND `MSG_TIME`=?s ";
  $tmp_sql2 =prepare($tmp_sql2,array($staffcodeNew,$CHECKTIME));
  $sql_ret2 =get_var($tmp_sql2);
  if($sql_ret2){
    if(intval($sql_ret2)>0){
      if($debugMode==1) echo html_span($staffcode.'-'.$CHECKTIME.'-'.$MESSAGE.' exist').PHP_EOL;  
      return array('retCode'=>1000,'retMsg'=>'exist');
    }else{
      if($debugMode==1) echo 'sql_ret='.print_r($sql_ret2,true).PHP_EOL; 
      return false;
    }
  }

  $tmp_sql =" INSERT INTO `".$sql_table_name."`( `StaffCode`, `MSG_TIME`, `MESSAGE`) VALUES (?s,?s,?s) ";  
  $tmp_sql =prepare($tmp_sql,array($staffcodeNew,$CHECKTIME,$MESSAGE));
  $sql_ret =run_sql($tmp_sql);
  if($debugMode==1) {
      echo 'tmp_sql='.$tmp_sql.PHP_EOL;
      echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  }
  return array('retCode'=>0,'retMsg'=>$sql_ret);;
}

/**
     * 将unicode转换成字符
     * @param int $unicode
     * @return string UTF-8字符
     **/
    function unicode2Char($unicode){
        if($unicode < 128)     return chr($unicode);
        if($unicode < 2048)    return chr(($unicode >> 6) + 192) .
                                      chr(($unicode & 63) + 128);
        if($unicode < 65536)   return chr(($unicode >> 12) + 224) .
                                      chr((($unicode >> 6) & 63) + 128) .
                                      chr(($unicode & 63) + 128);
        if($unicode < 2097152) return chr(($unicode >> 18) + 240) .
                                      chr((($unicode >> 12) & 63) + 128) .
                                      chr((($unicode >> 6) & 63) + 128) .
                                      chr(($unicode & 63) + 128);
        return false;
    }
 
    /**
     * 将字符转换成unicode
     * @param string $char 必须是UTF-8字符
     * @return int
     **/
    function char2Unicode($char){
        switch (strlen($char)){
            case 1 : return ord($char);
            case 2 : return (ord($char{1}) & 63) |
                            ((ord($char{0}) & 31) << 6);
            case 3 : return (ord($char{2}) & 63) |
                            ((ord($char{1}) & 63) << 6) |
                            ((ord($char{0}) & 15) << 12);
            case 4 : return (ord($char{3}) & 63) |
                            ((ord($char{2}) & 63) << 6) |
                            ((ord($char{1}) & 63) << 12) |
                            ((ord($char{0}) & 7)  << 18);
            default :
                trigger_error('Character is not UTF-8!', E_USER_WARNING);
                return false;
        }
    }

/**
     * 全角转半角
     * @param string $str
     * @return string
     **/
    function sbc2Dbc($str){
        return preg_replace(
            // 全角字符 
            '/[\x{3000}\x{ff01}-\x{ff5f}]/ue',
            // 编码转换
            // 0x3000是空格，特殊处理，其他全角字符编码-0xfee0即可以转为半角
            '($unicode=char2Unicode(\'\0\')) == 0x3000 ? " " : (($code=$unicode-0xfee0) > 256 ? unicode2Char($code) : chr($code))',
            $str
        );
    }
/**
     * 半角转全角
     * @param string $str
     * @return string
     **/
    function dbc2Sbc($str){
        return preg_replace(
            // 半角字符 
            '/[\x{0020}\x{0020}-\x{7e}]/ue',  
            // 编码转换
            // 0x0020是空格，特殊处理，其他半角字符编码+0xfee0即可以转为全角
            '($unicode=char2Unicode(\'\0\')) == 0x0020 ? unicode2Char（0x3000） : (($code=$unicode+0xfee0) > 256 ? unicode2Char($code) : chr($code))',
            $str
        );
    }

function get_update_time_for_leave_info(){
  //SELECT `uuid`, `StaffCode`, `StaffName`, `leaveDate`, `leaveType`, `NumberOfHours`, `notes` FROM `leave_info` WHERE 1
  //global $debug_mode;
  $tmp_sql =" SELECT * FROM `leave_info` order by `leaveDate` desc limit 1 "; 
  $sql_ret =get_line($tmp_sql);
  if($sql_ret && isset($sql_ret['leaveDate'])){
    return $sql_ret['leaveDate'];
  }
  /*if($debug_mode){
    echo 'tmp_sql='.$tmp_sql.PHP_EOL;
    echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  }*/
  return false;
}

function show_update_time($just_echo=true){
  $leave_info_update_day=get_update_time_for_leave_info();
  $_html= '请假数据更新时间：'.$leave_info_update_day;
  $_html.= PHP_EOL;

  if($just_echo){
    echo $_html;
  }
  return $_html;
}

function add_new_leave_info_with_check($staffcode,$StaffName,$leaveDate,$leaveType,$NumberOfHours,$notes,$report_mode=0){
  //global $debug_mode;
  ks_acl();

  $tmp_sql =" INSERT INTO `leave_info`(`uuid`, `StaffCode`, `StaffName`, `leaveDate`, `leaveType`, `NumberOfHours`, `notes`) VALUES (?s,?s,?s,?s,?s, ?s,?s) ";  

  $staffcode=fmt_staffcode($staffcode);
  $leaveDate=ymd_fmt($leaveDate);
  $uuid=md5($staffcode.'-'.$leaveDate);

  //SELECT * FROM `leave_info_diff` WHERE 
  $tmp_sql2=" SELECT count(*) as num FROM `leave_info` WHERE `uuid`=?s ";
  $tmp_sql2 =prepare($tmp_sql2,array($uuid));
  $sql_ret2 =get_var($tmp_sql2);
  if($sql_ret2){
    if(intval($sql_ret2)>0){
      if($report_mode==0) echo html_span($staffcode.'-'.$leaveDate.' exist').PHP_EOL; 

      $tmp_sql2=" SELECT * FROM `leave_info` WHERE `uuid`=?s limit 1";
      $tmp_sql2 =prepare($tmp_sql2,array($uuid));
      $sql_ret2 =get_line($tmp_sql2);
      if($sql_ret2 && isset($sql_ret2['leaveType'])){
        if($sql_ret2['leaveType']==$leaveType && $sql_ret2['NumberOfHours']+0==$NumberOfHours+0){
          return array('retCode'=>0,'retMsg'=>'exist'); 
        }else{
          if($report_mode==2) echo ' '.$leaveDate.'</br>'.PHP_EOL;
          return array('retCode'=>0,'retMsg'=>'exist leaveType='.$sql_ret2['leaveType']);
        }
      }
      return array('retCode'=>0,'retMsg'=>'exist');
    }else{
      echo 'sql_ret='.print_r($sql_ret2,true).PHP_EOL;  
      return false;
    }
  }

  $tmp_sql =prepare($tmp_sql,array($uuid, $staffcode,$StaffName,$leaveDate,$leaveType,$NumberOfHours,$notes));
  $sql_ret =run_sql($tmp_sql);
  //if($debug_mode){
    echo 'tmp_sql='.$tmp_sql.PHP_EOL;
    echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  //}
  return array('retCode'=>0,'retMsg'=>$sql_ret);;
}

/**
     ___  ___       ___   _   __   _  
    /   |/   |     /   | | | |  \ | | 
   / /|   /| |    / /| | | | |   \| | 
  / / |__/ | |   / / | | | | | |\   | 
 / /       | |  / /  | | | | | | \  | 
/_/        |_| /_/   |_| |_| |_|  \_| 

*/

$debug_sql_str='';
$close_api_debug=false;

///////////////////////////////////////////////////////////////////////////////////////////////////
$app_start_time = microtime(true);
$mtime=explode(' ',microtime());
// $appStartTime=$mtime[1]+$mtime[0];  
$appStartTime=$mtime[1].substr(round($mtime[0],2), 2);  

//die($localDbPath);

$c='api';
$a='auto';
$tt = v('c') ;  if($tt) $c=$tt;
$tt = v('a') ;  if($tt) $a=$tt;

ks_acl();

op_log($c.'.'.$a);


$debug_mode=0;
$tt = v('debug') ;
if(intval($tt)>0) $debug_mode=intval($tt);

$ret_obj='';
$ret_arr=array();

$sql_table_name = get_sql_table_name();

$ret_array['return_code']=0;
$ret_array['return_message']='';
//$ret_array['return_type']=0;


if(function_exists($c.'_'.$a)){
	$ret_array=call_user_func($c.'_'.$a,$c,$a);
  echo 'ok!'.json_encode($ret_array);  
	die();
}

die('Access Denied/Forbidden');

/**


**/

function time_check($timeInit){
  if(empty($timeInit)){
    return false;
  }
    $d=abs(time()-strtotime($timeInit));
    if($d<=60){
        return true;
    }

    return false;
}

function receive_sms($c,$a){
    $debug_mode =v('debug');
    if(!empty($debug_mode)){
        getDebugInfo();
    }  

    $sendWeiXinOnly=true;
    $sendWeiXinOnly=false;

    $staffCode=v('staffcode');
    $CHECKTIME=substr( v('CHECKTIME'),0,19);
    $Messsage=trim(v('Messsage'));

    if(empty($staffCode) or empty($CHECKTIME) or empty($Messsage)){
      die(__METHOD__.'() Invalid parameters !');
    }
    
    if(time_check($CHECKTIME)==false){
      add_new_Messsage(1,$staffCode,$CHECKTIME,$Messsage,2);
      die('Invalid time!');
    }
    
    $notNew=get_wechat_msg_time_by_staffCode_YMD($staffCode,$CHECKTIME);

    if($notNew==false){
        $sqlret=add_new_wechat_msg($staffCode,$CHECKTIME,$Messsage,1);

        if($Messsage=='?' || strtolower($Messsage)=='help'|| strlen($Messsage)<=2){
            $txt='亲爱的'.$staffCode.',当前测试功能(回复编号即可)：';
            $txt.=PHP_EOL.'101.查询最近5次打卡记录';
            $txt.=PHP_EOL.'102.查询最近5次请假记录';
        }else{

            if(intval($Messsage)>=100){
                $txt=sub_cmd($Messsage,$staffCode);
            }else{
                $txt=null;
            }
        }
            
        if(!empty($txt)){
            sendWX($staffCode,$txt);
            echo $txt;
        }
        return $sqlret;
               
    }
    return array('retCode'=>1001,'retMsg'=>'skip!');  
}

function sub_cmd($message,$staffCode){
    $cmdId=intval($message);
    if($cmdId<100){
        return __METHOD__.'() Invalid parameters !';
    }
    switch ($cmdId) {
      case 100:
        return 'test100 @'._time_str();
        break;

      case 101:
        return get_sms_checkinout_by_staffCode($staffCode);
        break;

    case 102:
        return task102($staffCode);
        break;


      default:
        return __METHOD__.'() Invalid parameters !!';
        break;
    }
    return __METHOD__.'() Invalid parameters !!!';
}

function task102($staffCode,$max=5){
  $retSrc=$staffCode.'最近5次请假记录:'.PHP_EOL;
  $retSrc.=show_update_time(false);

  $tableFix='';
  $debug_mode=false;
  
  $tmp_sql =" SELECT * FROM `leave_info".$tableFix."` WHERE MOD(`StaffCode`+0 ,10000)=".intval($staffCode)." ORDER By `leaveDate` DESC "; 
  if($max && $max>0){
    $tmp_sql.=' limit '.$max;
  }
  $sql_ret =get_data($tmp_sql);
  if($debug_mode){
    echo 'tmp_sql='.$tmp_sql.PHP_EOL;
    echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  }
  if($sql_ret){
    
    foreach ($sql_ret as $key => $value) {
      $retSrc.=$value['leaveDate'].' '.$value['leaveType'] .' '.$value['NumberOfHours'].' '.$value['notes'].PHP_EOL;
    }
    return $retSrc;
  }
  $retSrc.='查询失败！';
  return false;
}
function get_sms_checkinout_by_staffCode($StaffCode,$max=5){
  //SELECT `id`, `StaffCode`, `CHECKTIME`, `MachineAlias` FROM `sms_checkinout` WHERE 1
  $tableFix='';
  $debug_mode=false;
  
  $tmp_sql =" SELECT * FROM `sms_checkinout".$tableFix."` WHERE MOD(`StaffCode`+0 ,10000)=".intval($StaffCode)." ORDER By `CHECKTIME` DESC "; 
  if($max && $max>0){
    $tmp_sql.=' limit '.$max;
  }
  $sql_ret =get_data($tmp_sql);
  if($debug_mode){
    echo 'tmp_sql='.$tmp_sql.PHP_EOL;
    echo 'sql_ret='.print_r($sql_ret,true).PHP_EOL; 
  }
  if($sql_ret){
    $retSrc=$StaffCode.'最近5次打卡记录:'.PHP_EOL;
    foreach ($sql_ret as $key => $value) {
      $retSrc.=$value['CHECKTIME'] .' '.$value['MachineAlias'].PHP_EOL;
    }
    return $retSrc;
  }
  return false;
}

function send2_wx2($c,$a){
  $staffCode=v('sc');
  $txt=trim(v('Messsage'));
  sendWX($staffCode,$txt);
}

function sendWX($staffCode,$txt){
    $uid=$staffCode;

    $AppName='php';

    $url='http://192.168.10.38:8095/CompanyWeChat/SendMessage.asmx';
    $soapMessage='<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'.
        '  <soap:Body>' .
        '    <SendUserMessage xmlns="http://tempuri.org/">' .
        '      <UserCode>'. $uid.'</UserCode>' .
        '      <MessageContent>'.$txt.'</MessageContent>' .
        '      <AppName>'.$AppName.'</AppName>' .
        '    </SendUserMessage>' .
        '  </soap:Body>' .
        '</soap:Envelope>';

    //$ret=ew_ClientUrl($url,$soapMessage,'POST');
    $ret=do_post($url,$soapMessage);
    
    //var_dump($ret);
    var_dump(utf8_to_gb2312($ret));
}

// HTTP request by cURL
// Note: cURL must be enabled in PHP
function ew_ClientUrl($url, $postdata = "", $method = "GET") {
    if (!function_exists("curl_init"))
        die("cURL not installed.");
    $ch = curl_init();
    $method = strtoupper($method);
    if ($method == "POST") {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    } elseif ($method == "GET") {
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $postdata);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function do_post($url, $data)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: text/xml; charset=utf-8"  
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

function get_url_contents($url)
{
    if (ini_get("allow_url_fopen") == "1")
        return file_get_contents($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result =  curl_exec($ch);
    curl_close($ch);

    return $result;
}
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