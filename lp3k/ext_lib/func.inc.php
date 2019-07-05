<?php
define( 'UNKNOW' , '[未知]' );
define( 'JS_VOID' , 'javascript:void(0);' );
define('CMS_CACHE_PATH', APP_ROOT.'cms'.DS.'caches'.DS);
define('HTML_CACHE_PATH', APP_ROOT.'cms'.DS.'caches'.DS);

$db_table_prefix = 'shdic_sc2015_';

/**
 * Load a template.
 * @param $name Template name without path and extension.
 */
function template_load($name) {
  global $tbs, $out;
  if (!isset($tbs)) {    
    include(TBS_ROOT.'tbs'.DS.'tbs_class_php5.php');
    $tbs = new clsTinyButStrong();
    // TODO: Set gzip compression on
  }
  if ($name) {
    // echo 'DEBUG:'.__METHOD__.'('.$name.')'.PHP_EOL;
    // $tbs->LoadTemplate("html/$name.html");
    if(file_exists($name)){
      // echo 'DEBUG2:'.__METHOD__.'('.TPLROOT.$name.')'.PHP_EOL;
      $tbs->LoadTemplate(TPLROOT.$name);
    }else{
      $tbs->LoadTemplate(TPLROOT.$name.'.html');
    }
    
    $tbs->Source = str_replace('../html/', 'html/', $tbs->Source);
  }
  return $tbs;
}


$env_magic_quotes_gpc=false;


function _rnd($min,$max) {
    return mt_rand($min,$max);
}

function used_time($pagestartime){
  $pageendtime = microtime();
  $starttime = explode(" ",$pagestartime); 
  $endtime = explode(" ",$pageendtime); 
  $totaltime = $endtime[0]-$starttime[0]+$endtime[1]-$starttime[1]; 
  $timecost = sprintf("%s",$totaltime); 
  // echo "页面运行时间: $timecost 秒"; 
  // echo "页面运行时间: ". used_time() ."秒"; 
  return $timecost;
}

function getArrayValueByPos($arr,$n){
  $i=0;
  if(!is_array($arr)) return false;
  // $debugMode=1;
  // if($debugMode) {
 //        echo 'DEBUG: '.__FUNCTION__.'() arr:'.implode(',',$arr).PHP_EOL;
 //        echo 'DEBUG: '.__FUNCTION__.'() n:'.$n.PHP_EOL;
 //    } 
  foreach ($arr as $key => $value) {
    if($i++ ==$n){
      // if($debugMode) {
     //        echo 'DEBUG: '.__FUNCTION__.'() get:'.implode(',',$value).PHP_EOL;
   //     } 
      return $value;
    }
  }
  return false;
}

function check_magic_quotes_gpc(){
  global $env_magic_quotes_gpc;
  if($env_magic_quotes_gpc===null){
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() ){
      $env_magic_quotes_gpc = true;
    }else{
      $env_magic_quotes_gpc = false;
    } 
  }
  return $env_magic_quotes_gpc;
}

function safe_json_str_decode($str,$env=null){
  if($env===null){
    if(check_magic_quotes_gpc()){
      return stripslashes($str);
    }
  }
  return $str;  
}

function max_len($x,$lv=0){
  $len=0;
  if($lv) echo 'DEBUG: '.__FUNCTION__.'() lv='.$lv.PHP_EOL;
  if(is_array($x)){
    foreach ($x as $key => $value) {
      if(is_array($value)){
        $len += max_len($value,$lv+1);
      }else{
        $len += strlen($x); 
      }
    }
  }else{
    return strlen($x);
  }
  return $len;
}


function arr_del($arr1,$key){
    $c = count($arr1);        
    $arrkey = array_search($key, $arr1);
    if ($arrkey !== false)
        array_splice($arr1, $arrkey, 1);
    if($c==count($arr1)){
        echo 'DEBUG: '.__FUNCTION__.'() Error! count:'. $c.'<br/>'.PHP_EOL;
    }
    return $arr1;
}


$lastColorId=null;
function get_color($id=false){
  global $lastColorId;
  $debugMode = get_func_debug_mode(__METHOD__);
  if($debugMode) echo 'DEBUG: '.__METHOD__.'() id='. $id.'<br/>'.PHP_EOL;

  if($id && strlen($id)>3 && stripos($id, '#')===false){
    return $id;
  }

  $arr = explode(',', 'ffffff,dddddd,aaaaaa,888888,666666,444444,000000,ffb7dd,ff88c2,ff44aa,ff0088,c10066,a20055,8c0044,ffcccc,ff8888,ff3333,ff0000,cc0000,aa0000,880000,ffc8b4,ffa488,ff7744,ff5511,e63f00,c63300,a42d00,ffddaa,ffbb66,ffaa33,ff8800,ee7700,cc6600,bb5500,ffee99,ffdd55,ffcc22,ffbb00,ddaa00,aa7700,886600,ffffbb,ffff77,ffff33,ffff00,eeee00,bbbb00,888800,eeffbb,ddff77,ccff33,bbff00,99dd00,88aa00,668800,ccff99,bbff66,99ff33,77ff00,66dd00,55aa00,227700,99ff99,66ff66,33ff33,00ff00,00dd00,00aa00,008800,bbffee,77ffcc,33ffaa,00ff99,00dd77,00aa55,008844,aaffee,77ffee,33ffdd,00ffcc,00ddaa,00aa88,008866,99ffff,66ffff,33ffff,00ffff,00dddd,00aaaa,008888,cceeff,77ddff,33ccff,00bbff,009fcc,0088a8,007799,ccddff,99bbff,5599ff,0066ff,0044bb,003c9d,003377,ccccff,9999ff,5555ff,0000ff,0000cc,0000aa,000088,ccbbff,9f88ff,7744ff,5500ff,4400cc,2200aa,220088,d1bbff,b088ff,9955ff,7700ff,5500dd,4400b3,3a0088,e8ccff,d28eff,b94fff,9900ff,7700bb,66009d,550088,f0bbff,e377ff,d93eff,cc00ff,a500cc,7a0099,660077,ffb3ff,ff77ff,ff3eff,ff00ff,cc00cc,990099,770077');
  $c = count($arr);

  if($id===false){
    if($debugMode) echo 'DEBUG: '.__METHOD__.'() mode 1.<br/>'.PHP_EOL;
    if($lastColorId==null) {
      $n=1;
      $lastColorId=1;
    }else{
      $n = mt_rand(0,$c-1);
      $max = 10;
      while ( $n== $lastColorId && $max>0 ) {
        $n = mt_rand(0,$c-1);
        $max--;
      }
      $lastColorId=$n;
    }   
  }else if(stripos($id, '#')!==false){
    if($debugMode) echo 'DEBUG: '.__METHOD__.'() mode 2.<br/>'.PHP_EOL;
    $tmpArr = explode('#', $id);
    $ccid = $tmpArr[count($tmpArr)-1];    
    if(strlen($ccid)==6) {
      if($debugMode) echo 'DEBUG: '.__METHOD__.'() #2 return='. $ccid.'<br/>'.PHP_EOL;
      return $ccid;
    }else{
      if($debugMode) echo 'DEBUG: '.__METHOD__.'() #2 ccid='. $ccid.'<br/>'.PHP_EOL;
      $n = $ccid;
      $n = fmod(+$id,$c);
    }
  }else if(+$id==intval($id)){ 
    if($debugMode) echo 'DEBUG: '.__METHOD__.'() mode 3.<br/>'.PHP_EOL;
    $n = fmod(+$id,$c);
  }else{
    if($debugMode) echo 'DEBUG: '.__METHOD__.'() mode else:<br/>'.PHP_EOL;
    // $n = fmod($id,$c);
    $n = mt_rand(0,$c-1);  
  }

  if($debugMode) echo 'DEBUG: '.__METHOD__.'() return='. $arr[$n].'<br/>'.PHP_EOL;
  
  return $arr[$n];
}

function tab(){
    return "\t";
}


function get_array_result_json($array,$return_code=0,$return_message='',$run_time='',$count=0){
    global $debugMode, $time_log;
    if(empty($run_time)) $run_time=date('Y-m-d H:i:s');
    $data= array('return_code'=>$return_code
        ,'return_message'=>$return_message
        ,'run_time'=>$run_time
        ,'count'=>$count,'success'=>false,'data'=>array());
  
    if(is_array($array)){
        $data['success']=true;
        foreach ($array as $key => $value) {
          $data['data'][$key]=$value;  
        }
    }else if($array!=null){
        $data['success']=true;
        $data['data'][]=$array;
    }
   
    return $data;
}

function api_result_json($data,$return_message='success',$return_code=0,$count=null){
  if($count===null) $count=count($data);
  return json_encode(
    array('return_code'=>$return_code
        ,'return_message'=>$return_message
        ,'run_time'=> date('Y-m-d H:i:s')
        ,'count'=>$count
        ,'data'=>$data
        )
  );
}



function safe_email($email){
  $arr = explode('@', $email);
  if(strlen($arr[0]>6)){
    $arr[0] = substr($arr[0],0,3) . '...' . substr($arr[0],-2);
  }
  return $arr[0]. '#AT#'. $arr[1];
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
	$kk = uniqid('',true);  //53d1bc74439ba0.80927708
	$kk = explode('.', $kk);
	$kk= $kk[0];
	// $kk = uniqid();    //53d1bdd7b0b6b
	$jj=1;
	if(strlen($kk)>13){
	$jj=strlen($kk)-12; //-13+1
	}
	$chars = md5(uniqid(mt_rand(), true));
	$uuid = substr($kk, 0, 8).$hyphen
	.substr($kk, 8, 4).$hyphen;
	$uuid .= substr($kk, 12, $jj).substr($chars, 12,(4-$jj)).$hyphen
	.substr($chars, 16, 4).$hyphen
	.substr($chars, 20, 12);
	return $prefix.$uuid;
}

function drop_last_char($value,$last_char_len=1)
{
    return substr($value,0,strlen($value)-$last_char_len);
}

function hp_mysql_count_sql($table_name,$where){
    $sql = 'SELECT COUNT(*) as num FROM '.$table_name.' '.$where;
    return $sql;
}

function get_login_bonus_time(){
    $key = 'sc1_login_bonus_time';
    $default = '8-17';
    $tt = kget($key);
    if(empty($tt)){
      kset($key,$default);
      return $default;
    }
    return $tt;
}


function kis_log($log,$app=''){
	$cf_now = date('Y-m-d H:i:s');
	$table=real_table_name('debug_log');
	$tmp_sql=prepare("INSERT INTO `".$table."`(`cf1`, `app`, `log`) VALUES (?s,?s,?s) ",array($cf_now,$app,$log));
	run_sql($tmp_sql);
	return $tmp_sql;
}	

/**
 * 时间差计算
 *
 * @param Timestamp $time
 * @return String Time Elapsed
 * @author Shelley Shyan
 * @copyright http://phparch.cn (Professional PHP Architecture)
 */
/*
$past = 2052345678; // Some timestamp in the past
$now  = time();     // Current timestamp
$diff = $now - $past;

echo '发表于' . time2Units($diff) . '前';
*/
function time2Units ($time)
{
   $year   = floor($time / 60 / 60 / 24 / 365);
   $time  -= $year * 60 * 60 * 24 * 365;
   $month  = floor($time / 60 / 60 / 24 / 30);
   $time  -= $month * 60 * 60 * 24 * 30;
   $week   = floor($time / 60 / 60 / 24 / 7);
   $time  -= $week * 60 * 60 * 24 * 7;
   $day    = floor($time / 60 / 60 / 24);
   $time  -= $day * 60 * 60 * 24;
   $hour   = floor($time / 60 / 60);
   $time  -= $hour * 60 * 60;
   $minute = floor($time / 60);
   $time  -= $minute * 60;
   $second = $time;
   $elapse = '';

   $unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day',
                    '小时'=>'hour', '分钟'=>'minute', '秒'=>'second'
                    );

   foreach ( $unitArr as $cn => $u )
   {
       if ( $$u > 0 )
       {
           $elapse = $$u . $cn;
           break;
       }
   }

   return $elapse;
}

function diff_minute($s1,$s2=''){
	if(empty($s1)){
		return false;
	}
	if(empty($s2)){
		$s2 = date('Y-m-d H:i:s');
	}
	//PHP计算两个时间差的方法 
	$startdate=strtotime($s1);
	$enddate=strtotime($s2);
	// $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
	// $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
	// $minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
	// $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
	// echo $date."天<br>";
	// echo $hour."小时<br>";
	// echo $minute."分钟<br>";
	// echo $second."秒<br>";
	return floor(($startdate-$enddate)%86400/60);
}

function _kis_encrypt($s,$uid=false){
  if(empty($s)) return '';
  $k='90ab47f93bdc95d5d8e59129c450f3d0';
  if($uid!==false){$k.=md5($uid);}
  return encrypt($s, 'E', $k);
}
function _kis_decrypt($s,$uid=false){
  if(empty($s)) return '';
  $k='90ab47f93bdc95d5d8e59129c450f3d0';
  if($uid!==false){$k.=md5($uid);}
  $ret=encrypt($s, 'D', $k);
  if($ret==''){
    $s=str_ireplace(' ','+',$s);    //fix for url
    $ret=encrypt($s, 'D', $k);
  }
  return $ret;
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
              $tmp_link_str = '<img src="'.$kk.'" >'.$kk;
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


/**


**/

function kis_get_cache($mck,$table_name=''){
  return false;
  // $mck=md5(strtolower($sql));
  $mck=HTML_CACHE_PATH.'webjson'.DS.$table_name.$mck.'.json';
  if(file_exists($mck)){
    $mcjson = file_get_contents($mck);
    $ret=json_decode($mcjson,true);
    return $ret;
  }
  return false;
}

function kis_set_cache($mck,$data,$table_name=''){  
  return false;
  // $mck=HTML_CACHE_PATH.'webjson'.DS.$table_name.$mck.'.json';
  // file_put_contents($mck, json_encode($data));
}



/**
 	
 	copy from ext_lib/comm.function.php

*/

function high_performance_mysql_limit_sql($table_name,$id,$where,$limit,$offset,$fields_str='*'){
//High Performance MySQL
// 优化前SQL: SELECT * FROM member ORDER BY last_active LIMIT 50,5 
// 优化后SQL: SELECT * FROM member INNER JOIN (SELECT member_id FROM member ORDER BY last_active LIMIT 50, 5) USING (member_id) 

	$sql = 'SELECT '.$fields_str.' FROM '.$table_name.' INNER JOIN (SELECT '.$id.' FROM '.$table_name.' '.$where.' LIMIT '.$limit.', '.$offset.') tt USING ('.$id.') ';
	return $sql;
}



function get_highcharts_str($arr,$key,$max,$is_num=1,$delimiter=',')
{
  $tmp_num_arr=array();
  for ($i=0; $i <$max ; $i++) { 
    $id=''.$i;
    if($is_num){
      if(isset($arr[$key.$id])){
        $tmp_num_arr[]=$arr[$key.$id];
      }else{
        $tmp_num_arr[]='0';
      }
    }else{
      if(isset($arr[$key.$id]) && strtolower(trim($arr[$key.$id]))!='null'  ){
        $tmp_num_arr[]="'".$arr[$key.$id]."'";
      }else{
        $tmp_num_arr[]="'&nbsp;'";
      }
    }
    
  }
  return implode($delimiter, $tmp_num_arr);
}

function wait_import($value)
{
  if(empty($value) || $value=="数据待导入" ){
    return red_span('数据待导入');
  }else{
    return red_span('[wait]'.$value);
  }  
}

function red_span($value='')
{
  return '<span style="color:#f00">'.$value.'</span>'.PHP_EOL;
}




function load_config($file, $key = '', $default = '', $reload = false) {
  static $configs = array();
    if (!$reload && isset($configs[$file])) {
    if (empty($key)) {
      return $configs[$file];
    } elseif (isset($configs[$file][$key])) {
      return $configs[$file][$key];
    } else {
      return $default;
    }
  }
  $path = CMS_CACHE_PATH.'configs'.DS .$file.'.php';
  // echo $path;
  if (file_exists($path)) {
    return $configs[$file] = include $path;
  }
  if (empty($key)) {
    return $configs[$file];
  } elseif (isset($configs[$file][$key])) {
    return $configs[$file][$key];
  } else {
    return $default;
  }
}


/**

      fopy from ext_lib/comm.function.php

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

function debug($msg1,$mode=0){
  global $debugMode, $time_log , $c,$a, $outVar;
  
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
  if ($debugMode) {
    $time_log.= '<div style="background-color:#c8c8c8;">DEBUG['.$mode.']:' . $msg . PHP_EOL .'<br/></div>'.PHP_EOL;
  }else{
    $time_log.= '<!-- DEBUG:'.PHP_EOL .$msg.PHP_EOL .' -->'.PHP_EOL; 
  }
  return true;
}

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
  $cachedatatxt = md5($startUrl.$post_data.$user_agent.$header.$follow_loc.$cookie_file.$CURLOPT_REFERER    .$CURLOPT_TIMEOUT.date("Ymd")).".txt";
  // $cachedatatxt_mini=$cachedatatxt;
  // //debug('tmp-dir='._get_tempdir()); 
  // $cachedatatxt  = _get_tempdir() . $cachedatatxt ;
  
  // if($ret= kis_cache_get($cachedatatxt_mini)){
  //   if(!empty($ret)){
  //     return $ret;
  //   }
  // }

  // 1. 初始化
  $ch = @curl_init();
  // 2. 设置选项，包括URL
  @curl_setopt($ch, CURLOPT_URL, $startUrl);
  if (empty($user_agent)==0){
    // $user_agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';  //IE 6.0
    // $user_agent='Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)';  //IE 7.0
    $user_agent='Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)'; //IE 8.0
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
  @curl_setopt($ch, CURLOPT_HEADER, $header);       // 只需返回HTTP header
  @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    // 返回结果，而不是输出它
  @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_loc);   //启用时会将服务器服务器返回的“Location:”放在header中
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
  
  // kis_cache_set($cachedatatxt_mini,$output);
  return $output;
}

function _get_page($startUrl,$ref='def',$cookie_file='def'){
  $result = _get_url($startUrl,'','',0,0,$cookie_file,$ref);
  return $result;
}

function fix_res_path($src,$res){
    return str_ireplace('"static_html/'.$res.'"', '"'.$res.'"', $src);
}

function build_static_html($src){
  $delimiter='index.php';

  $src=str_ireplace('"static_html/style.css"', '"style.css"', $src);
  $src=fix_res_path($src,'jquery-1.8.3.min.js');
  $src=fix_res_path($src,'unslider.min.js');
  $src=fix_res_path($src,'jquery.valign-0.0.2.min.js');

  $src=str_ireplace('src="static_html/', 'src="./', $src);

  $arr=explode($delimiter, $src);
  // echo print_r($arr);
  $ret_arr=array();  
  // <li class="with1"><a href="index.php?a=page_b0">园区分布</a>
  foreach ($arr as $key => $value) {
    if($key==0){
      $ret_arr[]=$arr[0];
    }else{
      $tmp_src=$delimiter.$value;
      $pos=stripos($tmp_src, '"');
      // echo print_r($pos);
      // echo PHP_EOL;
      if($pos!==false){
        $tmp_fn=_cut_middle_str($tmp_src,'a=','"');
        // echo print_r($tmp_fn);
        // echo PHP_EOL;
        $tmp_src=str_ireplace($delimiter.'?a='.$tmp_fn, './'.$tmp_fn.'.html', $tmp_src);
        $ret_arr[]=$tmp_src;
      }else{
        die(__METHOD__.'() Error!');
      }
    }
  }
  // echo print_r($ret_arr);
  return implode($ret_arr, '');
}

?>
<?php
