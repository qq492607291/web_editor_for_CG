<?php
define( 'UNKNOW' , '[未知]' );
define( 'JS_VOID' , 'javascript:void(0);' );
define('CMS_CACHE_PATH', APP_ROOT.'cms'.DS.'caches'.DS);
define('HTML_CACHE_PATH', APP_ROOT.'cms'.DS.'caches'.DS);

$db_table_prefix = 'shdic_wbd2016_';

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


function check_adm_passwd_by_api($api_id,$pwfn='upw'){
    global $debugMode, $time_log , $c,$a, $outVar;
    global $db_table_prefix;

    $upw = v($pwfn);
    if(empty($upw)) return false;

    $ret=array('op'=>false,'result'=>false,'msg'=>'');
    $adm_pw=get_adm_pw($api_id);
    if($adm_pw==simple_passwd($upw,'') ){
        //adm password ok
        $ret['op']=true;
        $ret['msg']='is adm !';
    }else{
        // $ret['msg']='password error !';
        if($adm_pw==strtolower($upw) || strtolower(substr($adm_pw,0,16))==strtolower(substr($upw,0,16)) ){
	        //adm password ok
	        $ret['op']=true;
	        $ret['msg']='is adm !';
	    }else{
	        $ret['msg']='password error !';
	    }  
    }
    return $ret;
}

function check_passwd_by_uuid($table,$api_id,$pwfn='upw'){
    global $debugMode, $time_log , $c,$a, $outVar;
    global $db_table_prefix;

    $uuid = v('uuid');
    if(empty($uuid)) return false;
    $upw = v($pwfn);
    if(empty($upw)) return false;

    // $return_message='';
    // if($debugMode){
    //     $return_message .= 'uuid='.print_r($uuid,true).PHP_EOL;
    //     $return_message .= 'upw='.print_r($upw,true).PHP_EOL;    
    // }

    $ret=array('uuid'=>$uuid,'op'=>false,'result'=>false,'msg'=>'');

    $tmp_sql = prepare('SELECT * FROM `'.$db_table_prefix.$table.'` WHERE `is_his`=?i AND `code`=?s ' ,array(0,$uuid));
    // echo $tmp_sql;
    $ret_info = get_line($tmp_sql);
    if($debugMode) $ret['msg'] .= print_r($ret_info,true);
    if($ret_info!==false){
        if(isset($ret_info['id']) && isset($ret_info['ud9']) ){
            if(!empty($ret_info['ud9'])){
                if( $ret_info['ud9']==simple_passwd($upw,$ret_info['id']) ){
                    //password ok
                    $ret['op']=true;
                    $ret['result']=$ret_info;
                    return $ret;
                }else{
                    if(get_adm_pw($api_id)==simple_passwd($upw,'') ){
                        //adm password ok
                        $ret['op']=true;
                        $ret['msg']='is adm !';
                        $ret['result']=$ret_info;
                        return $ret;
                    }else{
                        $ret['msg']='password error !';
                        return $ret;  
                    }  
                }
            }else if(get_adm_pw($api_id)==simple_passwd($upw,'') ){
                //adm password ok
                $ret['op']=true;
                $ret['msg']='is adm !';
                $ret['result']=$ret_info;
                return $ret;
            }
        }else{
            $ret['msg']='system error #2 !';            
            return $ret;
        }
    }
    $ret['msg']='system error !';
    return $ret;
}

function check_char_password_by_uuid($api_id,$pwfn='upw'){
    return check_passwd_by_uuid('character_info',$api_id,$pwfn);
}

function check_map_password_by_uuid($api_id,$pwfn='upw'){
    return check_passwd_by_uuid('map_info',$api_id,$pwfn);
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

function api_result_json($data,$return_message='success',$return_code=0,$count=null,$page_div=''){
  if($count===null) $count=count($data);
  return json_encode(
    array('return_code'=>$return_code
        ,'return_message'=>$return_message
        ,'run_time'=> date('Y-m-d H:i:s')
        ,'count'=>$count
        ,'page_div'=>$page_div
        ,'data'=>$data
        )
  );
}

function simple_passwd($pw,$salt){
    return md5($pw.$salt);
}

function get_adm_pw($api_id){
    global $debugMode, $time_log , $c,$a, $outVar;
    global $db_table_prefix;

    $kv_key = $db_table_prefix.$api_id.'_adm_pw';
    $value=kget($kv_key);

    if(empty($value)){
        $value = md5('taotao0714');
        kset($kv_key,$value);
    }   

    return $value;
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


function check_user_has_login_bonus($uid){
	//检查用户是否已经获取过了登录奖励

	// $lbt = get_login_bonus_time();
	// 	if(!empty($lbt)){
	// 	$tmp_arr = explode('-', $lbt);        
	// }

	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');	

	$table = real_table_name('online');
	$cf_now = date('Y-m-d H:i:s');
	$cf_check = substr($cf_now, 0,13);
	$cf_check_today = substr($cf_now, 0,10);

	// run_sql('TRUNCATE TABLE  `shdic_sc2015_online`');

	$msg='';
	$msg .= 'uid='.$uid;
	$msg .= ',now='.$cf_now;
	$msg .= ',check='.$cf_check;
	$tt = get_var( "SELECT `last_active` FROM `".$table."` WHERE `uid` = '" . intval($uid) . "' LIMIT 1" );
	
	$msg .= ',last_active='.$tt;
	//fixme,demo期间简化为每个小时一次登录奖励！
	if(!empty($tt)){
	    if(stripos($tt, $cf_check_today)!==false){
	    	//上一次登陆也是今天
			if(stripos($tt, $cf_check)!==false){
				// $msg .= ',stripos($tt, $cf_check)='.stripos($tt, $cf_check);
				// $msg .= ',对应时间段已经登录过了!';
				//对应时间段已经登录过了
			}else{
				$ret_data['err_code'] = 3;
			}
	    }else{
	      // $msg .= ',stripos($tt, $cf_check)=false';
	      $ret_data['err_code'] = 2;
	      //上一次登陆不是今天
	      daily_maintenance($uid);
	    }
		
	}else{
		$ret_data['err_code'] = 1;
	}
	$ret_data['msg'] = $msg;
	return $ret_data;
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

function check_explore_end($uid,$data){
/*
SELECT `id`, `uid`, `title`, `is_his`, `category`, `op`, `num`, `create_date`, `modify_date` FROM `shdic_sc2015_hdop_buff` WHERE 1

	category=2,地图探索
		op=3 探索中，未结束的探索记录。
			num=探索分钟数
			
		op=4 待确认（包括中途失败）的地图探索
		op=5 探索过程中的详细信息

*/
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');	
	$ret_data['exp_done']=0;

	if(isset($data['op']) && isset($data['category']) && intval($data['category'])==2){
		//base check
	}else{
		$ret_data['err_code']=1;
		$ret_data['msg']='miss !';
		return $ret_data;
	}

	$table = real_table_name('hdop_buff');

	if(intval($data['op'])==3){
		//比较 modify_date 到现在的时间差 ，超过 num 分钟就结束
		$tt = diff_minute($data['modify_date']);
		// $ret_data['tt'] = $tt;
		if(abs(diff_minute($data['modify_date']))>=intval($data['num'])){

			$cf_now = date('Y-m-d H:i:s');
			$tmp_sql ="UPDATE `".$table."` SET `is_his`=1,`modify_date`=?s WHERE `is_his`=0 AND `id`=?i AND `uid`=?i ";
			$tmp_sql=prepare($tmp_sql,array($cf_now,intval($data['id']),$uid));
			run_sql($tmp_sql);

			$sp = player_hd_op($uid, $data['title'], 2, 4, $data['num'], 0);
			if(intval($sp['err_code'])==0){
				$ret_data['msg']='探索结束['.$data['title'].']！';
			}
			$ret_data['run']=2;
			$ret_data['exp_done']=1;

		}else{
			//探索中，未结束
			$ret_data['run']=1;
			$ret_data['msg']='探索中...['.$data['title'].']！';
		}
		return $ret_data;

	}else if(intval($data['op'])==4){
		//待确认（包括中途失败）的地图探索
		//TODO

    	$ret_data['run']=3;
    	$ret_data['msg']='等待确认['.$data['title'].']！';
    	return $ret_data;

	}else if(intval($data['op'])==5){
		//op=5 探索过程中的详细信息

		//暂定30秒一条打怪或者探索的log

		$rnd_evt = get_rand_event(2,3);
		if(isset($rnd_evt['err_code']) && intval($rnd_evt['err_code'])==0){
			$ret_data['msg']=$rnd_evt['msg'];
			$ret_data['evt']=$rnd_evt;
		}
		return $ret_data;

	}else{
		$ret_data['err_code']=2;
		$ret_data['msg']='error op! ';
		return $ret_data;
	}

}

/*
2，随机事件
		1，营地随机事件
		2，地图随机事件
		3，探索随机事件
SELECT `id`, `ffuid`, `title`, `desc`, `is_his`, `category`, `sub_category`, `create_date`, `modify_date` FROM `shdic_sc2015_event_info` WHERE 1
*/
function get_rand_event($cat1,$cat2){
	$ret_data=array('err_code'=>1,'func_name'=>__FUNCTION__,'msg'=>'什么也没发现!');
	$c1 = intval($cat1);
	$c2 = intval($cat2);
	if($c1>0 && $c2>0 ){
		//base check
	}else{
		$ret_data['msg'].='#0';
		return $ret_data;
	}
	
	$rand=_rnd(1,100);
	if($rand<25){
		$ret_data['msg'].='#'.$rand.'%';
		return $ret_data;
	}	

	//FIXME 随机效率待提高

	$table = real_table_name('event_info');
	$where = prepare("`is_his`=0 AND `category`= ?i AND `sub_category`= ?i ",array($cat1,$cat2));
	$count_sql="SELECT count(*) as kk FROM `".$table."` WHERE ".$where;
	if( $count = get_var( $count_sql ) ){
		$count = intval($count);
		if($count>0){
			$rand=_rnd(1,$count-1);
			$tmp_sql="SELECT id FROM `".$table."` WHERE ".$where;
			$id=0;
			$idx=0;
			if( $ids_data = get_data( $tmp_sql ) ){
				foreach ($ids_data as $key => $value) {
					$idx =$idx+1;
					if($idx==$rand && isset($value['id'])) {
						$id=$value['id'];
					}
				}
			}
			if(!empty($id)){
				$tmp_sql=prepare("SELECT * FROM `".$table."` WHERE `is_his`=0 AND `id`= ?s ",array($id));
				if( $evt_data = get_line( $tmp_sql ) ){
					$ret_data['err_code']=0;
					$ret_data['msg'] =$evt_data['title'];
					$ret_data['event'] =$evt_data;
					return $ret_data;
				}
			}
		}
	}

	$ret_data['msg'].='(error!)';
	return $ret_data;	
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

function _fix_html_code($t){
  $t = str_ireplace('<', '&lt;', $t);
  $t = str_ireplace('>', '&gt;', $t);
  return $t;
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
                $kk='attr:'.$key . '=' .implode($value,';')  ;
                // $kk.='#'.$key;
                // $kk.='#'.$key2;
                // $kk.='#'.$value2;
              }
            }else{
              $kk='MISS';
            }           
          }
        }
        $kk=_fix_html_code($kk);
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
              if(stripos($tmp, '[id]')!==false && isset($value['id'])){
                $tmp = str_ireplace('[id]', $value['id'], $tmp);
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
	Daily maintenance   换日维护操作
*/

function daily_maintenance($uid=false){

	//清理零散经验值记录
	daily_maintenance_clear_exp_buff($uid);

	//回复SP
	daily_recover_sp($uid);

}

function daily_maintenance_clear_exp_buff($uid){	//TODO

/*
	1，将用户的零散经验值记录，合并到用户扩展信息上，并将对应的零散记录标记为历史！
	2，超过多久的历史就可以清除掉了！
*/
	$cf_now = date('Y-m-d H:i:s');
	// $tmp_sql = "UPDATE `".real_table_name('exp_buff')."` SET is_his=?i,modify_date=?s WHERE `uid` = ?i AND is_his=?i ";
	// $tmp_sql=prepare($tmp_sql,array(1,$cf_now,$uid,0));
	// run_sql($tmp_sql);

	// $tmp_sql = "Update `".$table."` Set exp=?i,exp_max=?i,level=?i WHERE `uid` = ?i ";
	// $tmp_sql=prepare($tmp_sql,array($exp,$exp_max,$level,$uid));
	// run_sql($tmp_sql);

}

function daily_recover_sp($uid){
	$itmName='sp';
	$num='100';
	return player_ext_op_by_uid($uid,$itmName,$num);
}

/**


**/
function get_HP_page_result($table_name,$id,$where,$limit,$offset,$fields_str='*'){
//High Performance MySQL
  // $ret_data= array('return_code'=>0
  //       ,'return_message'=>''
  //       ,'count'=>''
  //       ,'data'=>0,'success'=>false,'rows'=>array());

  global $debugMode, $time_log , $c,$a, $outVar;

  $ret=array();
  $count=0;

  $debugMode=true;
  $debugMsg='';

  $sql1 = 'SELECT count('.$id.') as num FROM '.$table_name.' '.$where.''; 
  // echo __METHOD__.'() sql1='.$sql1.PHP_EOL;
  if($debugMode) $debugMsg.='sql1='.$sql1.'#';
  $ret_sql1=get_var($sql1);
  if($ret_sql1!==false){
    $count=intval($ret_sql1);
    if($count==0){
      return get_array_result_json($ret,0,'没有符合条件的记录！'.$debugMsg,'',0);
    }
  }else{
    return get_array_result_json($ret,1,' SQL ERROR ! '. $debugMsg,'',0);
  }

  $sql = 'SELECT '.$fields_str.' FROM '.$table_name.' INNER JOIN (SELECT '.$id.' FROM '.$table_name.' '.$where.' LIMIT '.intval($limit).', '.intval($offset).') tt USING ('.$id.') ';

  if($debugMode) $debugMsg.='sql='.$sql.'#';
  // echo __METHOD__.'() sql='.$sql.PHP_EOL;

  // $mck=md5($table_name.$id.$where.$limit.$offset.$fields_str);
  $mck=md5(strtolower($sql));
  // $mck=HTML_CACHE_PATH.'webjson'.DS.$table_name.$mck.'.json';
  // if(file_exists($mck)){
  //   $mcjson = file_get_contents($mck);
  //   $ret=json_decode($mcjson,true);
  //   return get_array_result_json($ret,0,'success','',$count);
  // }
  $cc=kis_get_cache($mck,$table_name);
  if($cc!==false){
    return get_array_result_json($cc,0,'success !'.$debugMsg,'',$count);
  }

  $ret_sql=get_data($sql);
  if($ret_sql===false){
    return get_array_result_json($ret,2,' SQL ERROR ! '. $debugMsg,'',$count);
  }

  // file_put_contents($mck, json_encode($ret_sql));
  kis_set_cache($mck,$ret_sql,$table_name);
  return get_array_result_json($ret_sql,0,'success !'.$debugMsg,'',$count);
}

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

function init_bae_redis(){
  global $redis;

  if($redis!==null && $redis!==false){
    return $redis;
  }

  $runtime_env_check='';

  if(defined('SERVER_SOFTWARE')){     //SERVER_SOFTWARE = bae/3.0
    $runtime_env_check=strtolower(SERVER_SOFTWARE);
    if(stripos($runtime_env_check,'bae')!==false){
      $runtime_env_check='bae';      
    }
  }

  if($runtime_env_check !== 'bae'){
    $redis=false;
    return false;
  }

  /*从平台获取数据库名*/
  $dbname = "UDICLzcDirLTMJFuxFSD"; //数据库名称

  /*从环境变量里取host,port,user,pwd*/
  $host = 'redis.duapp.com';
  $port = '80';
  $user = User_AK; //用户AK
  $pwd = User_SK;  //用户SK

  try {
    /*建立连接后，在进行集合操作前，需要先进行auth验证*/
    $redis = new Redis();
    $ret = $redis->connect($host, $port);
    if ($ret === false) {
      // die($redis->getLastError());
      $redis=false;
      return false;
    }

    $ret = $redis->auth($user . "-" . $pwd . "-" . $dbname);
    if ($ret === false) {
      // die($redis->getLastError());
      return false;
    }

    /*接下来就可以对该库进行操作了，具体操作方法请参考phpredis官方文档*/
    $redis->flushdb();
    $ret = $redis->set("key", "value");
    if ($ret === false) {
      // die($redis->getLastError());
      $redis=false;
      return false;
    } else {
      // echo "OK";
      return true;
    }

  } catch (RedisException $e) {
    // die("Uncaught exception " . $e->getMessage());
    $redis=false;
    return false;
  }
}

/**
var_dump($redis->GET('fake_key')); #(nil) //return bool(false)
$redis->SET('animate', "anohana"); //return bool(true)
var_dump($redis->GET('animate')); //return string(7) "anohana"
**/

function set_redis($key,$value=null){
  global $redis;

  if($redis===null) init_bae_redis();
  if($redis===false) return false;
 
  try {
    // /*建立连接后，在进行集合操作前，需要先进行auth验证*/
    // $redis = new Redis();
    // $ret = $redis->connect($host, $port);
    // if ($ret === false) {
    //   // die($redis->getLastError());
    //   $redis=false;
    //   return false;
    // }

    // $ret = $redis->auth($user . "-" . $pwd . "-" . $dbname);
    // if ($ret === false) {
    //   // die($redis->getLastError());
    //   return false;
    // }

    /*接下来就可以对该库进行操作了，具体操作方法请参考phpredis官方文档*/
    // $redis->flushdb(); //清空当前数据库中的所有 key 。
    $ret = $redis->set($key, $value);
    if ($ret === false) {
      // die($redis->getLastError());
      return false;
    } else {
      // echo "OK";
      return true;
    }

  } catch (RedisException $e) {
    // die("Uncaught exception " . $e->getMessage());
    return false;
  }
}

function get_redis($key){
  global $redis;

  if($redis===null) init_bae_redis();
  if($redis===false) return false;
 
  try {   
    $ret = $redis->get($key);
    if ($ret === false) {
      // die($redis->getLastError());
      return false;
    } else {
      // echo "OK";
      return $ret;
    }

  } catch (RedisException $e) {
    // die("Uncaught exception " . $e->getMessage());
    return false;
  }
}

function redis_get_allkeys($key){
  global $redis;

  if($redis===null) init_bae_redis();
  if($redis===false) return false;
 
  try {
    // $keyWithUserPrefix = $redis->keys('user*');
    $ret = $redis->keys($key);
    if ($ret === false) {
      // die($redis->getLastError());
      return false;
    } else {
      // echo "OK";
      return $ret;
    }

  } catch (RedisException $e) {
    // die("Uncaught exception " . $e->getMessage());
    return false;
  }
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
  // echo '<!-- DEBUG: '.__METHOD__.'()'.PHP_EOL;
  // echo print_r($arr,true);
  // echo '-->'.PHP_EOL;
  $tmp_num_arr=array();
  for ($i=0; $i <$max ; $i++) { 
    $id=''.$i;
    if($is_num){    //数字模式
      if(isset($arr[$key.$id])){
        $tmp_num_arr[]=intval($arr[$key.$id]);
      }else{
        $tmp_num_arr[]='0';
      }
    }else{        //文字模式
      if(isset($arr[$key.$id])){
        $tt=$arr[$key.$id];  
        $tt=trim($tt);
        if( $tt=='null' ){
          $tt='null'.$i;
        }        
      }else{
        $tt='miss'.$i;
      }
      $tmp_num_arr[]="'".$tt."'";
    }
    
  }
  // echo '<!-- DEBUG: '.__METHOD__.'()'.PHP_EOL;
  // echo print_r($tmp_num_arr,true);
  // echo '-->'.PHP_EOL;

  $ret_src=implode($delimiter, $tmp_num_arr);
  // echo '<!-- DEBUG: '.__METHOD__.'()'.PHP_EOL;
  // echo 'ret_src='.$ret_src;
  // echo '-->'.PHP_EOL;

  return $ret_src;
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

/**

      build_static_html
      
**/

function fix_assets_path($src,$assets,$app_root=null,$assets_path=null){
  if(empty($app_root)){
    $app_root='./';
  }
  if(empty($assets_path)){
    $assets_path='assets/';
  }else if(substr($assets_path, -1)!='/'){
    $assets_path .='/';
  }
  return str_ireplace('"static_html/'.$assets_path.$assets.'"', '"'.$app_root.$assets_path.$assets.'"', $src);
}

function build_static_html($src,$outVar,$opt){
  global $debugMode, $time_log , $c,$a;

  // echo '<!-- DEBUG: '.__METHOD__.'() -->'.PHP_EOL;
  // file_put_contents('static_html/'.$a.'.org.html', $src);

  $delimiter='index.php';

  $dsp_mode=false;
  $dsp_api='';
  $app_root=null;
  if(isset($outVar['dsp_mode']) && intval($outVar['dsp_mode'])==1){
    $dsp_mode=true;
    $app_root=$outVar['dsp_root'];      //'/demo/web20160415/';
    if(isset($outVar['dsp_api']) && !empty($outVar['dsp_api'])){
      $dsp_api='[%dbpath%]dsp?readform&p=';
    }else{
      $dsp_api='[%dbpath%]dsp?readform&p=';
    }
  }

  // $src=fix_assets_path($src,'style.css',$app_root);
  // $src=fix_assets_path($src,'jquery-1.8.3.min.js',$app_root);
  // $src=fix_assets_path($src,'unslider.min.js',$app_root);
  // $src=fix_assets_path($src,'jquery.valign-0.0.2.min.js',$app_root); 

  if($dsp_mode){
    $src=str_ireplace('src="static_html/assets/', 'src="'.$app_root.'assets/', $src);
  }else{
    $src=str_ireplace('src="static_html/assets/', 'src="./assets/', $src);
  }  

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
      if($pos===false){
        $pos=stripos($tmp_src, "'");
        $tmp_fn=_cut_middle_str($tmp_src,'?',"'");
      }else{
        $tmp_fn=_cut_middle_str($tmp_src,'?','"');
      }
      if(stripos($tmp_fn, "&")!==false){
        $tmp_fn=str_ireplace('c=guest&a=', '', $tmp_fn); 
      }else{
        $tmp_fn=str_ireplace('a=', '', $tmp_fn); 
      }

      if(stripos($tmp_fn, "&")===false){
        if($tmp_fn!='index'){
          $new_fn='page_'.$tmp_fn;
        }else{
          $new_fn=$tmp_fn;
        }
        if($dsp_mode){
          // dsp?readform&p=homepage
          $tmp_src=str_ireplace($delimiter.'?c=guest&a='.$tmp_fn, $dsp_api.$new_fn.'.html', $tmp_src);
          $tmp_src=str_ireplace($delimiter.'?a='.$tmp_fn, $dsp_api.$new_fn.'.html', $tmp_src);          
        }else{
          $tmp_src=str_ireplace($delimiter.'?c=guest&a='.$tmp_fn, './'.$new_fn.'.html', $tmp_src);  
          $tmp_src=str_ireplace($delimiter.'?a='.$tmp_fn, './'.$new_fn.'.html', $tmp_src);
        }        
      }
      $ret_arr[]=$tmp_src;
     }
  }
  // echo print_r($ret_arr);
  // return implode($ret_arr, '');
  $static_html=implode($ret_arr, '');

  // echo '<!-- DEBUG: static_html='.$static_html.' -->'.PHP_EOL;
  $login_span_delimiter='id="login_span"';
  $login_span =_cut_middle_str($static_html,$login_span_delimiter,'</span>');
  if(empty($login_span)){
    die(__METHOD__.'() Error! #login_span error!');
  }
  echo '<!-- DEBUG: login_span='.$login_span.' -->'.PHP_EOL;
  // echo $login_span;
  $static_html=str_ireplace($login_span, '>'.LOGIN_SPAN_HTML_STATIC, $static_html);

  // file_put_contents('static_html/'.$a.'.html', $static_html);
  if($a!='index'){
    $a='page_'.$a;
  }
  file_put_contents($a.'.html', $static_html);
  return $static_html;
}

function getIp()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR”")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    /*
  处理多层代理的情况
  或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
  */
  if (false !== strpos($realip, ',')){
      $realip = reset(explode(',', $realip));
  }
    return $realip;
}

/**

      public function code

**/

function _get_url_domain($bookUrl){
  $tmpSrc=$bookUrl;
  $delimiter='$$$';
  $tmpSrc=str_ireplace('http://', $delimiter, $tmpSrc);
  $tmpArr=explode('/', $tmpSrc);
  $tt = $tmpArr[0];
  $ret=str_ireplace($delimiter,'http://', $tt);
  return $ret;
}

function get_domain_key($tmpUrl){
  $domain='';
  $URI_PARTS = parse_url($tmpUrl);
  if(!isset($URI_PARTS["port"]) || empty($URI_PARTS["port"])){
    $URI_PARTS["port"]=80;
  } 
  if(!isset($URI_PARTS["scheme"]) || empty($URI_PARTS["scheme"])){
    $URI_PARTS["scheme"]="http";
  }
  if(!isset($URI_PARTS["host"]) || empty($URI_PARTS["host"])){
    $tt=_get_url_domain($tmpUrl);
    $URI_PARTS["host"]=$tt;
  }
  $domain = strtolower($URI_PARTS["scheme"].'_'.$URI_PARTS["host"].'_'.$URI_PARTS["port"]);
  return $domain;
}

function mkFolder($path)
{  
    if(!is_readable($path))
    {  
        // is_file($path) or mkdir($path,0700);
      if(is_file($path)){
        return false;
      }else{
        mkdir($path,0700);
        return true;
      }
    }
    return false;
}

?>
<?php
