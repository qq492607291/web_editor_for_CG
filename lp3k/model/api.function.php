<?php
define( 'USER_INFO' , "`id` ,  `id` as  `uid` , `name` , `mobile` , `tel` , `memo` , `pinyin` , `email` , `avatar_small` , `avatar_normal` , `level` , `timeline` , `is_closed`" );


function get_user_info_by_id( $uid )
{
	$table = real_table_name('user');
	if( $data = get_line( "SELECT " . USER_INFO . " FROM `".$table."` WHERE `id` = '" . intval( $uid ) . "'" , db() ) )
		if( strlen( $data['groups'] ) > 0 ) 
			$data['groups'] = explode('|', trim( $data['groups'] , '|' )) ;
	
	return $data;
	
}

function get_user_exp_buff_by_id($uid,&$data)
{
	$uid = intval($uid);

	$table = real_table_name('exp_buff');

	//SELECT sum(num) as num1 FROM `shdic_sc2015_exp_buff` WHERE `uid`=10000 AND `is_his`=0
	$tmp_sql=prepare("SELECT sum(num) as num1 FROM `".$table."` WHERE `uid` = ?i AND is_his=?i ",array($uid,0));
	if( $exp_fix=get_var($tmp_sql) ){
		if(intval($exp_fix)>0){//有未添加的经验
			$ret_op=player_exp_op($data['exp'],$data['exp_max'],$data['level'],$exp_fix);
			if(intval($ret_op['err_code'])==0){	//经验添加计算成功
				$data['exp'] = $ret_op['exp'];
				$data['exp_max'] = $ret_op['exp_max'];
				$data['level'] = $ret_op['level'];
				return $exp_fix;
			}	
		}
		return $exp_fix;
	}
	return false;
}

/** 获取用户（玩家）的扩展信息 */
function get_user_ext_info_by_id( $uid ,$init=false,$skip_exp=true)
{
	$uid = intval($uid);

	$table = real_table_name('user_info');
	if( $data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . $uid . "'" , db() ) ){
		if( strlen( $data['status'] ) > 0 ) 
			$data['status1'] = explode('|', trim( $data['status'] , '|' )) ;
		if( strlen( $data['position'] ) > 0 ) 
			$data['position1'] = explode('|', trim( $data['position'] , '|' )) ;

		if($skip_exp!=true){
			$data['exp_buff_sum']=get_user_exp_buff_by_id($uid,$data);
		}

	}else{		//没有该用户的扩展信息
		if($init==true){
			//随机初始化
			$num1 = rand( 3 , 7 );
			$num2 = rand( 3 , 7 );
			$num3 = rand( 3 , 7 );
			$num4 = rand( 3 , 7 );
			$num5 = rand( 3 , 7 );
			$loopMaxCount=10;
			while ($num1+$num2+$num3+$num4+$num5>26 && $loopMaxCount>0){
				$loopMaxCount++;
				$num1 = rand( 3 , 7 );
				$num2 = rand( 3 , 7 );
				$num3 = rand( 3 , 6 );
				$num4 = rand( 3 , 6 );
				$num5 = rand( 3 , 6 );
			}
			if($num1+$num2+$num3+$num4+$num5>26){
				$num1=5;
				$num2=5;
				$num3=5;
				$num4=5;
				$num5=5;
			}

			$tmp_sql = "INSERT INTO `".$table."` (`uid`, `status`, `position`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`) VALUES(?i, ?s, ?s, ?i, ?i, ?i, ?i, ?i );";
			$tmp_sql=prepare($tmp_sql,array(intval( $uid ),'正常','camp',$num1,$num2,$num3,$num4,$num5));
			run_sql($tmp_sql);

			$data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . $uid . "'" , db() );
		}

	}
	return $data;	
}


function player_hd_op($uid,$title,$cat,$op,$num,$getSum=1,$ud1=false,$ud2=false)
{
	$ret_data=array('err_code'=>0,'msg'=>'UNKNOW!','uid'=>$uid,'title'=>$title,'cat'=>$cat,'op'=>$op,'num'=>$num);
	$cat = intval($cat);
	$num = intval($num);
	if($cat<1){
		$ret_data['err_code']=1;
		return $ret_data;
	}
	if($num<1){
		$ret_data['err_code']=2;
		return $ret_data;
	}

	if($ud1===false){
		$ud1='null';
	}
	if($ud2===false){
		$ud2='null';
	}

	$cf_now = date('Y-m-d H:i:s');
	$table = real_table_name('hdop_buff');
	$tmp_sql ="INSERT INTO `".$table."`(`uid`, `title`, `is_his`, `category`, `op`, `num`, `int_ud2`, `int_ud1`,`create_date`, `modify_date`) VALUES (?i,?s,?i,?i,?i,?i,?s,?s,?s,?s)";
	$tmp_sql=prepare($tmp_sql,array($uid,$title,0,$cat,$op,$num,$ud2,$ud1,$cf_now,$cf_now));
	run_sql($tmp_sql);

	if($getSum==1){
		$tmp_sql ="SELECT sum(num) as total FROM `".$table."` WHERE `uid`=?i AND `is_his`=?i AND `category`=?i";
		$tmp_sql=prepare($tmp_sql,array($uid,0,$cat));
		$ret_data['sum_cat']=get_var($tmp_sql);
	}else{
		$ret_data['sum_cat']=false;
	}
	return $ret_data;
}

function player_hd_op_v1($uid,$title,$cat,$op,$num,$getSum=1)
{
	$ret_data=array('err_code'=>0,'msg'=>'UNKNOW!','uid'=>$uid,'title'=>$title,'cat'=>$cat,'op'=>$op,'num'=>$num);
	$cat = intval($cat);
	$num = intval($num);
	if($cat<1){
		$ret_data['err_code']=1;
		return $ret_data;
	}
	if($num<1){
		$ret_data['err_code']=2;
		return $ret_data;
	}

	$cf_now = date('Y-m-d H:i:s');
	$table = real_table_name('hdop_buff');
	$tmp_sql ="INSERT INTO `".$table."`(`uid`, `title`, `is_his`, `category`, `op`, `num`, `create_date`, `modify_date`) VALUES (?i,?s,?i,?i,?i,?i,?s,?s)";
	$tmp_sql=prepare($tmp_sql,array($uid,$title,0,$cat,$op,$num,$cf_now,$cf_now));
	run_sql($tmp_sql);

	if($getSum==1){
		$tmp_sql ="SELECT sum(num) as total FROM `".$table."` WHERE `uid`=?i AND `is_his`=?i AND `category`=?i";
		$tmp_sql=prepare($tmp_sql,array($uid,0,$cat));
		$ret_data['sum_cat']=get_var($tmp_sql);
	}else{
		$ret_data['sum_cat']=false;
	}
	return $ret_data;
}
function player_move($uid ,$pos_x,$pos_y)
{
	
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');	
	$homePosX=1000;
	$homePosY=1000;

	$table = real_table_name('user_info');
	if( $pc_data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . intval( $uid ) . "'" , db() ) ){
		$homePosX = $pc_data['pos_x'];
		$homePosY = $pc_data['pos_y'];
	}else{
		$ret_data['msg']='移动失败！#1';
		$ret_data['err_code']=1;
		return $ret_data;
	}

	if( (abs($homePosX-$pos_x)+abs($homePosY-$pos_y) )>1 ){
		$ret_data['msg']='移动失败！移动太快了吧！#2';
		$ret_data['err_code']=2;
		return $ret_data;
	}

	if(isset($pc_data['sp']) && intval($pc_data['sp'])>5 ){

		$sp = player_hd_op($uid,'地图移动',1,1,5,1);
		if(intval($sp['err_code'])==0){
			$sp_full = 100;
			$sp_used = intval($sp['sum_cat']);
			$sp_now = intval($pc_data['sp']);

			if($sp_used+$sp_now==$sp_full){
				$ret_data['msg'] .= 'SP check OK.';
			}else{
				$ret_data['msg'] .= 'SP check Error!';
			}

			$sp_now = $sp_now-5;

			$tmpSql="UPDATE `".$table."` SET `sp`=?i,`pos_x`=?i,`pos_y`=?i WHERE `uid`=?i AND `pos_x`=?i AND `pos_y`=?i ";
			$tmpSql = prepare($tmpSql ,array($sp_now,$pos_x,$pos_y,$uid,$homePosX,$homePosY) );
			run_sql($tmpSql);

			$ret_data['pos_x']=$pos_x;
			$ret_data['pos_x']=$pos_y;
			$ret_data['sp']=$sp_now;
		}
	}
	return $ret_data;	
}

function get_player_maps_info_by_uid( $uid )
{
	
/*
	1，按照uid取该玩家当前做标
	2，返回做标附近地图信息
*/
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');	
	$ret_data['maps']=array();
	$homePosX=1000;
	$homePosY=1000;

	$table = real_table_name('user_info');
	if( $pc_data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . intval( $uid ) . "'" , db() ) ){
		$homePosX = $pc_data['pos_x'];
		$homePosY = $pc_data['pos_y'];
		$ret_data['sp']=$pc_data['sp'];
	}else{
		$ret_data['msg']='用户当前位置读取失败！';
		$ret_data['err_code']=1;
		return $ret_data;
	}
	
	$ret_data['pos_x']=$homePosX;
	$ret_data['pos_y']=$homePosY;

	$table = real_table_name('map_info');


	$base_sql ='SELECT `title`, `code`, `category`, `block_id`,`thumbnail_id`, `path_id`, `door_id`, `bg_img`, `pos_x`, `pos_y`, `ud1`, `ud2`, `ud3`, `ud4`, `ud5`, `ud6`, `ud7`, `ud8`, `ud9`, `parent_id`, `sort` FROM `'.$table.'` WHERE `is_his`=?i AND `parent_id`=?i AND `pos_x`>=?i AND `pos_x`<=?i AND `pos_y`>=?i AND `pos_y`<=?i ORDER BY `pos_x`,`pos_y` LIMIT 0 , 64 ';
	
    $step_x=3;
    $step_y=4;
    $tt = intval(v('step'));
    if ($tt>0){
        $step_x = $tt;
        $step_y = $tt+1;
    }
    
    $x1=$homePosX-$step_x;
    $x2=$homePosX+$step_x;
    $y1=$homePosY-$step_y;
    $y2=$homePosY+$step_y;

    $outVar['x_min']=$x1;
    $outVar['x_max']=$x2;
    $outVar['y_min']=$y1;
    $outVar['y_max']=$y2;
    $ret_data['xy']=array();
    $ret_data['xy']['x_min']=$x1;
    $ret_data['xy']['x_max']=$x2;
    $ret_data['xy']['y_min']=$y1;
    $ret_data['xy']['y_max']=$y2;

    $tmp_sql = prepare($base_sql ,array(0,0,$x1,$x2,$y1,$y2) );
    // echo $tmp_sql;
	if( $maps_data = get_data($tmp_sql , db() ) ){
		$ret_data['maps']=$maps_data;
	}

	return $ret_data;	
}

function get_player_exploration_info_by_uid( $uid )
{
	$step = intval(v('step'));
/**
step=1;	//计划探索
	1，按照uid取该玩家当前做标
	2，当前做标是否可以探索？
		是，继续
		否，返回提示
	3，是否有未结束的地图探索记录？
		有，则显示
		无，则显示战术设置页面
		
step=2;	//确定探索
	1，记录战术设置
	2，创建探索记录

step=3;	//查看探索情况			NOT IN USE
	是否有未结束的地图探索记录？
		有，则显示；
		无，返回。

step=4;	//确认探索结果
	是否有待确认（包括中途失败）的地图探索记录？
		有，则显示；
			是中途失败
			是探索结束
		无，返回。

step=5;	//显示探索详情
	是否有地图探索的详细记录？
		有，则全部显示；
		无，返回。

*/
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__ . '#'.$step,'msg'=>'');	
	$ret_data['maps']=array();
	$homePosX=1000;
	$homePosY=1000;	

	switch ($step) {
		case 1:

			$table = real_table_name('user_info');
			$pc_data=get_user_ext_info_by_id($uid);
			if($pc_data!==false){
				$homePosX = $pc_data['pos_x'];
				$homePosY = $pc_data['pos_y'];
				$ret_data['sp']=$pc_data['sp'];
			}else{
				$ret_data['msg']='用户当前位置读取失败！';
				$ret_data['err_code']=1;
				return $ret_data;
			}

			$can_exp = check_map_pos_can_exp($uid,$homePosX,$homePosY);
			if( isset($can_exp['err_code']) && intval($can_exp['err_code'])>0 ){
				$ret_data['msg']='当前位置禁止探索！';
				$ret_data['msg'].=$can_exp['msg'];
				$ret_data['err_code']=2;
				return $ret_data;
			}
			if( isset($can_exp['map']['code']) ){
				$ret_data['m_id']=$can_exp['map']['code'];
			}
			if( isset($can_exp['map_block']['code']) ){
				$ret_data['mb_id']=$can_exp['map_block']['code'];
			}
			
			$table = real_table_name('hdop_buff');
			if( $op_data = get_line( "SELECT * FROM `".$table."` WHERE `category`=2 AND `uid` = '" . intval( $uid ) . "'" , db() ) ){
				
				$ret_data['msg']='正在['.$op_data['title'].']！';
				$ret_data['step']=3;
				return $ret_data;
			}

			$tmp_xy = $pc_data['pos_x'].'.'.$pc_data['pos_y'];
			$ret_data['msg']='准备探索['.$tmp_xy.']！';
			$ret_data['step']=2;
			return $ret_data;
			break;


		case 2:
			$pc_data=get_user_ext_info_by_id($uid);
			if($pc_data==false){
				$ret_data['msg']='用户当前位置读取失败！';
				$ret_data['err_code']=1;
				return $ret_data;
			}

			//TODO 战术设置

			$explore_time = 36;
			//读取探索时间
			$block_code = v('mb_id');
			$table = real_table_name('map_block_info');
			$tmp_sql=prepare("SELECT * FROM `".$table."` WHERE `code`= ?s ",array($block_code));
			if( $mb_data = get_line( $tmp_sql ) ){
				$ret_data['msg'].='(debug:get map_block_info ok )';
				if(isset($mb_data['explore_time']) && intval($mb_data['explore_time'])>0 ) {
					$explore_time = intval($mb_data['explore_time']);
					$ret_data['msg'].='(debug:get explore_time='.$explore_time.')';
				}
			}

			//$uid,$title,$cat,$op,$num,$getSum=1
			$tmp_xy = $pc_data['pos_x'].'.'.$pc_data['pos_y'];
			$sp = player_hd_op($uid, '探索地图'.$tmp_xy, 2, 3, $explore_time, 0);
			if(intval($sp['err_code'])==0){

				$spa=gen_exploration_info($uid,$pc_data);
				
				$ret_data['msg'].='开始探索['.$tmp_xy.']！';
				$ret_data['step']=3;
				$ret_data['op_log']=$spa;
				return $ret_data;
			}else{
				$ret_data['msg'].='意外失败！';
				$ret_data['step']=0;
				return $ret_data;
			}

			break;

		case 3:		//NOT IN USE
			
			$table = real_table_name('hdop_buff');
			if( $op_data = get_line( "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `category`=2 AND `op`=3 AND `uid` = '" . intval( $uid ) . "'" , db() ) ){
				
				//TODO
				$ee = check_explore_end($uid,$op_data);
				// if(intval($sp['err_code'])==0){
					
				// }
				$ret_data['msg']=$ee['msg'];
				$ret_data['ee']=$ee;
				return $ret_data;
			}else{
				$ret_data['msg']='意外失败！';
				$ret_data['err_code']=12;
				return $ret_data;
			}

			break;

		case 4:
			$table = real_table_name('hdop_buff');
			$cat =2;
			$op =5;
			$tmp_sql ="SELECT * FROM `".$table."` WHERE `is_his`=?i AND `category`=?i AND `op`!=?i AND `uid`=?i ";
			$tmp_sql=prepare($tmp_sql,array(0, $cat, $op, $uid));

			$ret_data['sql']=$tmp_sql;

			if( $op_data=get_data($tmp_sql) ){
				foreach ($op_data as $key => $value) {

					if(!isset($ret_data['op_loop'])){
						$ret_data['op_loop'] = $key;
					}else{
						$ret_data['op_loop'] .= ','.$key;
					}

					//TODO
					$ee = check_explore_end($uid, $value);
					$ret_data['msg'].=$ee['msg'];
					$ret_data['ee']=$ee;
/*
					if(isset($value['op']) && intval($value['op'])==3){
						//探索中，未结束的探索记录。

					}else if(isset($value['op']) && intval($value['op'])==4){
						//待确认（包括中途失败）的地图探索

					}
*/
				}
				return $ret_data;
			}else{
				$ret_data['msg']='sql error ! or return false !';
				return $ret_data;
			}
			break;

		case 5:
			$table = real_table_name('hdop_buff');
			$cat =2;
			$op =5;

			//非探索详情的记录（category=2，op=3或op=4的，应该只有一条记录）
			$tmp_sql ="SELECT * FROM `".$table."` WHERE `is_his`=?i AND `category`=?i AND `op`!=?i AND `uid`=?i ";		//order by id desc
			$tmp_sql=prepare($tmp_sql,array(0, $cat, $op, $uid));
			if( $op_data=get_line($tmp_sql) ){
				$tt = abs(diff_minute($op_data['modify_date']));
			}else{
				// $tt=1000;	//show all				
				$ret_data['err_code']=51;
				$ret_data['msg']='探索日志详情,读取异常！#'.$ret_data['err_code'];
				return $ret_data;
			}
			$ret_data['tt']=$tt;
			$ret_data['pass_time']=$tt;

			//总共有多少条探索详情的记录
			$log_max_count=0;
			$tmp_sql ="SELECT count(*) as num FROM `".$table."` WHERE `is_his`=?i AND `category`=?i AND `op`=?i AND `uid`=?i ";
			$tmp_sql=prepare($tmp_sql,array(0, $cat, $op, $uid));
			if( $count_data=get_var($tmp_sql) ){
				$log_max_count = intval($count_data);
			}else{
				$ret_data['err_code']=53;
				$ret_data['msg']='探索日志详情,读取异常！#'.$ret_data['err_code'];
				return $ret_data;
			}
			$ret_data['log_max_count']=$log_max_count;

			//显示前多少条探索日志
			$tmp_sql=prepare("SELECT * FROM `".$table."` WHERE `is_his`=?i AND `category`=?i AND `op`=?i AND `uid`=?i AND `num`<=?i ",array(0, $cat, $op, $uid, $tt));
			if( $op_data=get_data($tmp_sql) ){
				$ret_data['op5']=$op_data;
			}else{
				$ret_data['err_code']=52;
				$ret_data['msg']='探索日志详情,读取异常！#'.$ret_data['err_code'];
				return $ret_data;
			}
		
			if(count($op_data)>=$log_max_count){
				$ret_data['exp_done']=1;
			}else{
				$ret_data['exp_done']=0;
			}
			return $ret_data;

			break;

		default:
			$ret_data['msg']='非法操作！！！';
			$ret_data['err_code']=100;
			return $ret_data;
			break;
	}

	return $ret_data;	
}


function gen_exploration_info($uid,&$pc_data){	//TODO 产生全部探索详情
/**
1,player_hd_op 探索log
探险过程中的临时物品		hd_op op=5
			num =显示序号, int_ud1=获取到的物品的id，int_ud2获取到的物品的数量（损失的内容直接从背包中减去）
			探险结束确认时，部分带走，没带走的清空记录。
*/
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__ . '#'.$uid,'msg'=>'');
	if(!$pc_data || !isset($pc_data['pos_x']) || !isset($pc_data['pos_y']))	{
		$ret_data['msg']='非法操作！！！';
		$ret_data['err_code']=100;
		return $ret_data;
	}
	$msg='';
	$count = _rnd(50,100);
	// kis_log('count='.$count,__FUNCTION__);
	$tmp_xy = $pc_data['pos_x'].'.'.$pc_data['pos_y'];

	//get map_block block_id
	$table = real_table_name('map_info');
	$tmp_sql = prepare("SELECT `block_id` FROM `".$table."` WHERE `is_his`=0 AND `pos_x`=?s AND `pos_y`=?s ",array($pc_data['pos_x'],$pc_data['pos_y']));
	if( $block_id = get_var( $tmp_sql ) ){
		$msg .= ';tmp_sql='.$tmp_sql;
		$msg .= ';get block_id='.$block_id;
	}else{
		//error
		$ret_data['err_code']=11;
		$ret_data['msg']='数据异常！#'.$ret_data['err_code'];
		return $ret_data;
	}
	// kis_log($msg,__FUNCTION__);

	//get loot_set_id
	$table = real_table_name('map_block_info');
	$tmp_sql =prepare("SELECT `loot_set_id` FROM `".$table."` WHERE `is_his`=0 AND (`id`=?s OR `code`=?s ) ",array($block_id,$block_id));
	if( $loot_set_id = get_var( $tmp_sql ) ){
		$msg = ';tmp_sql='.$tmp_sql;
		$msg .= ';get loot_set_id='.$loot_set_id;
		// kis_log($msg,__FUNCTION__);
	}else{
		//error
		$ret_data['err_code']=12;
		$ret_data['msg']='数据异常！#'.$ret_data['err_code'];
		return $ret_data;
	}

	//get loot_set_data
	$table = real_table_name('simple_config');
	$tmp_sql = prepare("SELECT * FROM `".$table."` WHERE `is_his`=?i AND `category`=?i AND `parent_id`=?i ORDER BY `sort` LIMIT 100 ",array(0,3,$loot_set_id) ); 
	if( $loot_set_data = get_data($tmp_sql) ){
		$msg = ';tmp_sql='.$tmp_sql;
		$msg .= ';get loot_set_data count='.count($loot_set_data);
		// kis_log($msg,__FUNCTION__);
		$msg='';
	}else{
		$ret_data['err_code']=200;
		$ret_data['msg']='数据异常！#'.$ret_data['err_code'];
		return $ret_data;
	}

	$log_done=false;
	$ret_data['logs']=array();
	for ($i=0; $i < $count ; $i++) { 
		$int_ud1=false;
		$int_ud2=false;
		$rnd=_rnd(1,100);
		$msg='(debug:rnd='.$rnd.'.)';		//DEBUG
/*

*/
		if($rnd>30){	//loot something
			$int_ud1=false;
			$int_ud2=false;
			$tmp_arr=array();
			$tmp2_arr=array();
			foreach ($loot_set_data as $key => $value) {

				// if($log_done==false) kis_log(json_encode($value),__FUNCTION__);

				//判断掉落几率
				if(isset($value['ud1']) && isset($value['ud2']) && intval($value['ud2'])>$rnd){
					$tmp_arr[]=$value['ud1'];	//item id
					//延后 判断百分比上限、下限
					if(isset($value['ud6'])){
						$tmp2_arr[]=intval($value['ud6']);	//每次最多拾取多少个
					}else{
						$tmp2_arr[]=1;
					}
					
				}
			}

			// kis_log('count(tmp_arr)='.count($tmp_arr),__FUNCTION__);
			// kis_log('count(loot_set_data)='.count($loot_set_data),__FUNCTION__);

			$log_done=true;

			if(count($tmp_arr)>0){
				//在所有达到掉落几率的物品中，再随机出一个本次最终的唯一掉落物

				if(count($tmp_arr)>2){	//超过5样物品可能掉落时，判断百分比上限、下限


					$msg.='(debug:count='.count($tmp_arr).'.)';		//DEBUG

					$tmp_arr=array();
					$tmp2_arr=array();
					foreach ($loot_set_data as $key => $value) {
						//判断掉落几率
						if(isset($value['ud1']) && isset($value['ud2']) && intval($value['ud2'])>$rnd){

							// 判断百分比上限ud4、下限ud3
							if(isset($value['ud3']) && isset($value['ud4']) && $rnd >=intval($value['ud3']) && $rnd<=intval($value['ud4'])){
								$tmp_arr[]=$value['ud1'];	//item id
								if(isset($value['ud6'])){
									$tmp2_arr[]=intval($value['ud6']);	//每次最多拾取多少个
								}else{
									$tmp2_arr[]=1;
								}
							}
						}
					}

					if(count($tmp_arr)>0){
						//ok
					}else{
						$int_ud1=false;
						$int_ud2=false;	
						$msg .= '几声意外的声响传来，你谨慎的停下了搜索，仔细观察四周！';
					}
				}

				if(count($tmp_arr)>0){
					$rnd_id=_rnd(0,count($tmp_arr)-1);
					$int_ud1=$tmp_arr[$rnd_id];				
					$int_ud2=_rnd(1,$tmp2_arr[$rnd_id]);
					$itm_name = get_item_name($int_ud1);
					$msg .= '你找到了['.$itm_name.']x'.$int_ud2.'！';

					//DEBUG 找到第二样物品
					$rnd2=_rnd(1,6);
					if($rnd2==6 && count($tmp_arr)>2){
						$rnd2_id=_rnd(0,count($tmp_arr)-1);
						if($rnd2_id!=$rnd_id){
							$rnd_id=$rnd2_id;
							$int_ud1=$tmp_arr[$rnd_id];	
							$int_ud2=_rnd(1,$tmp2_arr[$rnd_id]);
							$itm_name = get_item_name($int_ud1);
							$msg .= '你又找到了['.$itm_name.']x'.$int_ud2.'！';
						}
					}

				}

			}else{
				$int_ud1=false;
				$int_ud2=false;	
				$msg .= '你仔细的搜索四周，但是什么也没找到！';
			}
			
		}else{
			//nothing
			$int_ud1=false;
			$int_ud2=false;	
			$msg .= '什么也没发生!';
		}
		$sp1 = player_hd_op($uid, $msg, 2, 5, $i, 0,$int_ud1,$int_ud2);
		$ret_data['logs'][] = $sp1;
	}
	return $ret_data;
}


function get_player_exploration_loot_info_by_uid( $uid )
{
/**
返回探索中拾取的物品，供玩家确认！ 拿走哪些？拿不走的（比如背包装不下的）等于丢弃掉了！
*/

//	FIXME 
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__ . '#'.$uid,'msg'=>'');	
	// $ret_data['loot']=get_pc_item_info_by_uid($uid,'loot');

	$table = real_table_name('hdop_buff');
	$tmp_sql = "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `op`=5 AND `uid` = '" . intval( $uid ) . "' AND `int_ud1`!=0 AND `int_ud2`!=0 limit 150 ";
	$data = get_data( $tmp_sql );
	$ret_data['loot']=$data;
	
	return $ret_data;
}

/*

*/
function init_item_for_new_player_by_uid( $uid ,$skip_check=false)
{
	$table = real_table_name('pc_item_info');
	$count_is_zero=false;
	if($skip_check==false){
		$count_is_zero = get_var( "SELECT count(*) as total FROM `".$table."` WHERE `main_category`=2 AND `is_his`=0 AND uid` = '" . intval( $uid ) . "'" , db() );
	}
	
	if($count_is_zero!=false && intval($count_is_zero)>0){
		return false;
	
	}else{
		//初始化
		$cf_now = date('Y-m-d H:i:s');
		$tpl_sql = "INSERT INTO `".$table."` (`title`, `is_his`, `main_category`, `category`, `sub_category`, `item_id`, `original_id`, `max_holding`, `max_stack`, `single_weight`, `quality`, `in_use`, `num1`, `num2`, `durable`, `create_date`, `modify_date`, `uid`) VALUES(?s,?i,?i,?i,?i,?i,?i,?i,?i, ?i, ?i, ?i, ?s, ?s, ?s, ?s, ?s, ?s);";
		$tmp_sql=prepare($tpl_sql,array('一套衣服', 0,2,2,5, 11, 0,10,1, 1500, 1, 1, '0', '0', '100',$cf_now,$cf_now, $uid));
		run_sql($tmp_sql);

		run_sql(prepare($tpl_sql,array('瓶装饮用水1000ml', 0,2,1,2, 1, 0,15,1, 1000, 1, 0, '0', '0', '100',$cf_now,$cf_now, $uid)));
		run_sql(prepare($tpl_sql,array('方便面', 0,2,1,1, 2, 0,15,1, 450, 1, 0, '0', '0', '100',$cf_now,$cf_now, $uid)));
		run_sql(prepare($tpl_sql,array('餐刀', 0,2,3,1, 6, 0,100,1, 250, 1, 0, '0', '0', '100',$cf_now,$cf_now, $uid)));
		run_sql(prepare($tpl_sql,array('一套衣服#2', 0,1,2,5, 14, 0,10,1, 1000, 1, 0, '0', '0', '150',$cf_now,$cf_now, $uid)));
	}
	return true;	
}

function get_pc_item_info_by_uid( $uid , $mode )
{
	$table = real_table_name('pc_item_info');
	switch ($mode) {
		case 'equip':
			$sql = "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `main_category`=2 AND `in_use`=1 AND `uid` = '" . intval( $uid ) . "'";
			break;

		case 'bank':
			$sql = "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `main_category`=1 AND `uid` = '" . intval( $uid ) . "'";
			break;

		case 'package':
			$sql = "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `main_category`=2 AND `in_use`!=1 AND `uid` = '" . intval( $uid ) . "'";
			break;

		// case 'loot':
		// 	$sql = "SELECT * FROM `".$table."` WHERE `is_his`=0 AND `main_category`=3 AND `uid` = '" . intval( $uid ) . "'";
		// 	break;
		
		default:
			"SELECT * FROM `".$table."` WHERE `is_his`=0 AND `main_category`=2 AND `uid` = '" . intval( $uid ) . "'";
			break;
	}

	if( $data = get_data( $sql , db() ) ){
		//ok	
	}else{
		//init
		init_item_for_new_player_by_uid($uid,true);
		//get
		$data = get_data( $sql , db() );
	}
	return $data;	
}

function get_player_equip_info_by_uid( $uid )
{
	return get_pc_item_info_by_uid($uid,'equip');
}

function get_player_bank_info_by_uid( $uid )
{
	return get_pc_item_info_by_uid($uid,'bank');
}

function get_player_package_info_by_uid( $uid )
{
	return get_pc_item_info_by_uid($uid,'package');
}


function get_item_category_info()
{
	$data=array();
	$table = real_table_name('simple_config');
	if( $all_data = get_data( "SELECT `id`, `title`, `code`,`parent_id`, `ud1`, `ud2` FROM `".$table."` WHERE `is_his`=0 AND `category`=2 " , db() ) ){
	//SELECT `id`, `title`, `code`, `is_his`, `category`, `ud1`, `ud2`, `ud3`, `ud4`, `ud5`, `ud6`, `ud7`, `ud8`, `ud9`, `create_date`, `modify_date`, `parent_id`, `sort` FROM `shdic_sc2015_simple_config` WHERE 1

		foreach ($all_data as $key => $value) {
			if (isset($value['parent_id'])) {
				$parent_id = intval($value['parent_id']);
				if($parent_id==0){
					$p_id = $value['id'];
				}
			}
		}

		foreach ($all_data as $key => $value) {
			if (isset($value['parent_id'])) {
				$parent_id = intval($value['parent_id']);
				if($parent_id>0 && $parent_id==$p_id) {
					$data[]=$value;
				}
			}
		}

		foreach ($data as $key1 => $value1) {
			if (isset($value['parent_id'])) {
				$p1_id = intval($value1['id']);
				foreach ($all_data as $key => $value) {
					if (isset($value['parent_id'])) {
						$parent_id = intval($value['parent_id']);
						if($parent_id==$p1_id){
							if(!isset($data[$key1]['sub_category'])){
								$data[$key1]['sub_category']=array();
							}
							$data[$key1]['sub_category'][]=$value;
						}
					} //end if
				} //end foreach
			} //end if
		} //end foreach
	}
	return $data;	
}


function show_item_info_by_uid( $uid )
{
	$table = real_table_name('item_info');
	if( $data = get_data( "SELECT * FROM `".$table."` WHERE `ffuid` = '" . intval( $uid ) . "'" , db() ) ){
		
	}
	return $data;
}

function show_event_info_by_uid( $uid )
{
	$table = real_table_name('event_info');
	if( $data = get_data( "SELECT * FROM `".$table."` WHERE `ffuid` = '" . intval( $uid ) . "'" , db() ) ){
		
	}
	return $data;	
}

function debug_rand_event_by_uid( $uid )
{
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');
	$d = rand( 1 , 100 );
	if($d<10){		
		$ret_data['msg']='你还没找到什么，就弄伤了自己！';
		//(#'.$d.' vs. 10%)
		return $ret_data;
	}elseif ($d<40) {
		$ret_data['msg']='什么也没发生.';
		// (#'.$d.' vs. 30%)
		return $ret_data;
	}else{
		$ret_data['msg']='你感觉要发生什么事情... ';
		//(#'.$d.' vs. 60%)
	}

	$table = real_table_name('event_info');
	if( $evt_data = get_data( "SELECT * FROM `".$table."` WHERE `is_his` = '0' " , db() ) ){
		
		$evt = rand( 0 , count($evt_data)-1);
		// $ret_data['msg'] .= $evt .'/'. count($evt_data);
		if(isset($evt_data[$evt]['desc'])){
			$br='<br/>';
			$evt_desc = $br.'【事件】'.$evt_data[$evt]['desc'].$br;	
		}else{
			$evt_desc = 'err2!';
		}		

		$data=player_exp_op_by_uid($uid,4,3);	//表示,4=添加D12,3=+3		
		// $ret_data['msg']=$data['msg'];
		$ret_data['msg'] .=$evt_desc .$data['msg'];

	}else{
		$ret_data['msg'] .= '结果什么也没发生！';
	}

	return $ret_data;	
}

function player_exp_op( $exp ,$exp_max,$level,$num=null)
{
	$ret_data=array('err_code'=>0,'msg'=>'UNKNOW!','exp'=>0,'exp_max'=>0,'level'=>0,'num'=>0);
	if($num==null){
		$ret_data['err_code']='1';
		return false;
	}
	$fix = intval($num);
	if($fix==0){
		$ret_data['err_code']='2';
		return false;
	}
	if($fix>0){
		$msg = '你增长了['.$fix.']点经验！';
	}else{
		$msg = '你损失了['.abs($fix).']点经验！';
	}
	$exp = intval($exp);
	$exp_max = intval($exp_max);
	$level = intval($level);
	$exp_new = $exp + $fix;

	if($exp_new>$exp_max){		
		$exp = $exp_new-$exp_max;
		$exp_max = $exp_max *2 ;
		$level = $level+1;
		$msg .= '升到'.$level.'级啦！';
		$kk=10;
		while ( $exp>=$exp_max && $kk>0) {
			$kk =$kk-1;
			$exp = $exp-$exp_max;
			$exp_max = $exp_max *2 ;
			$level = $level+1;
			$msg .= '升到'.$level.'级啦！';
		}
		if($exp>=$exp_max && $kk<=0){
			$exp=0;
			$msg .= '达到升级上限啦！';
		}

	}else if($exp_new<0){
		$msg .= '经验降到底啦！';
		$exp=0;
	}else{
		$exp = $exp_new;
	}
	$ret_data['msg']=$msg;
	$ret_data['exp']=$exp;
	$ret_data['exp_max']=$exp_max;
	$ret_data['level']=$level;
	$ret_data['num']=$fix;	
	return $ret_data;
}

function player_exp_op_by_uid( $uid ,$op , $num=0)
{
	$uid = intval( $uid );
	$table = real_table_name('user_info');
	if( $data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . $uid . "'" , db() ) ){

		$data['exp_buff_sum']=get_user_exp_buff_by_id($uid,$data);

		$exp = intval($data['exp']);
		$exp_max = intval($data['exp_max']);
		if($exp_max==0) $exp_max=100;
		$level = intval($data['level']);
		if($level==0) $level=1;
		$num = intval($num);
		$msg = '';
		$fix = false;
		switch (intval($op)) {
			case 1:
				$fix = -$num;
				break;
			case 2:
				$fix = $num;
				break;
			case 3:
				$fix = $num + rand( 1 , 6);	//D6				
				break;
			case 4:
				$fix = $num + rand( 1 , 12);	//D12
				break;
			case 5:				
				$fix = $num + rand( 1 , 20);	//D20
				break;
			case 6:				
				$fix = $num + rand( 1 , 100);	//D100
				break;
			
			default:
				$fix = false;
				break;
		}

		$ret_op=player_exp_op($exp,$exp_max,$level,$fix);
		
		if(intval($ret_op['err_code'])==0){
			$msg = '';
			
			if(intval($ret_op['exp'])!=intval($data['exp']) ){
				$msg = $ret_op['msg'];
				// $msg .= '状态刷新啦！';
				$fix = $ret_op['num'];
				$cf_now = date('Y-m-d H:i:s');
				$table = real_table_name('exp_buff');
				$tmp_sql ="INSERT INTO `".$table."`(`uid`, `title`, `is_his`, `category`, `op`, `num`, `create_date`, `modify_date`) VALUES (?i,?s,?i,?i,?i,?i,?s,?s)";
				$tmp_sql=prepare($tmp_sql,array($uid,$msg,0,1,$op,$fix,$cf_now,$cf_now));
				run_sql($tmp_sql);
			}
			// $msg .= '#4';
			// $data['outVar']=array();
			// $data['outVar']['msg'] = $msg;
			// $data['outVar']['exp'] = $exp;
			// $data['outVar']['exp_max'] = $exp_max;
			// $data['outVar']['level'] = $level;
			// $data['outVar']['tmp_sql'] = $tmp_sql;

			if(is_array($ret_op)) foreach ($ret_op as $key => $value) {
				if($key!='msg'){
					$data[$key] = $value;
				} 
			}
			$data['msg'] = $msg;
			
		}else{
			$data['msg'] = '没有获得任何经验！';
		}
	}
	return $data;	
}


function player_add_item( $uid ,$itmName , $itmDesc)
{
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'参数异常！');
	if(empty($itmName)){
		$ret_data['msg']='物品名称为空！'.$itmName;
		$ret_data['err_code']='#1';
		return $ret_data;
	}else if(empty($itmDesc)){
		$ret_data['msg']='物品描述为空！'.$itmDesc;
		$ret_data['err_code']='#2';
		return $ret_data;
	}
	$ret_data['itmName']=$itmName;
	$ret_data['itmDesc']=$itmDesc;

	$uid = intval( $uid );
	$table = real_table_name('item_info');
	$check_data = get_var( "SELECT count(*) as kk FROM `".$table."` WHERE `title` like '%" . $itmName . "%' or `desc` like '%" . $itmDesc . "%'" , db() );
	if( $check_data !==false ){

		if(intval($check_data)>0){	//已经存在类似的!
			$ret_data['err_code']='#3';
			$ret_data['msg']='已经存在类似的物品信息!';
			return $ret_data;
		}		
	}

	$cat1 = v('cat1');
	$cat2 = v('cat2');
	$weight = v('weight');
	$quality = v('quality');
	$num1 = v('num1');
	$num2 = v('num2');
	
	$stack = v('stack');
	$durable = v('durable');

	$cat1=intval($cat1);
	$cat2=intval($cat2);
	$weight=intval($weight);
	$durable=intval($durable);

	$cf_now = date('Y-m-d H:i:s');

//INSERT INTO `shdic_sc2015_item_info`(`id`, `ffuid`, `title`, `desc`, `is_his`, `category`, `sub_category`, `max_holding`, `max_stack`, `single_weight`, `quality`, `in_use`, `num1`, `num2`, `durable`, `create_date`, `modify_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16],[value-17])

	$tmp_sql ="INSERT INTO `".$table."`(`ffuid`, `title`, `desc`,`is_his`, `category`, `sub_category`,`max_stack`, `single_weight`, `quality`, `num1`, `num2`, `durable`, `create_date`, `modify_date`) VALUES (?i,?s,?s,?i,?i,?i,?s,?i,?i,?i,?i,?i,?s,?s)";
	$tmp_sql=prepare($tmp_sql,array($uid,$itmName,$itmDesc,0,$cat1,$cat2,$stack,$weight,$quality,$num1,$num2,$durable,$cf_now,$cf_now));
	run_sql($tmp_sql);

	$data=player_exp_op_by_uid($uid,4,3);	//表示,4=添加D12,3=+3		
	// $ret_data['msg']=$data['msg'];
	$ret_data['msg']='因为捐献了新发现的物品【'.$itmName.'】('.$itmDesc.')!'.$data['msg'];

	return $ret_data;	
}

function player_add_event( $uid ,$itmName , $itmDesc)
{
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'参数异常！');
	if(empty($itmName)){
		$ret_data['msg']='事件名称为空！'.$itmName;
		$ret_data['err_code']='#1';
		return $ret_data;
	}else if(empty($itmDesc)){
		$ret_data['msg']='事件描述为空！'.$itmDesc;
		$ret_data['err_code']='#2';
		return $ret_data;
	}
	$ret_data['itmName']=$itmName;
	$ret_data['itmDesc']=$itmDesc;

	$uid = intval( $uid );
	$table = real_table_name('event_info');
	$check_data = get_var( "SELECT count(*) as kk FROM `".$table."` WHERE `title` like '%" . $itmName . "%' or `desc` like '%" . $itmDesc . "%'" , db() );
	if( $check_data !==false ){

		if(intval($check_data)>0){	//已经存在类似的!
			$ret_data['err_code']='#3';
			$ret_data['msg']='已经存在类似的事件信息!';
			return $ret_data;
		}
		
	}
	$cf_now = date('Y-m-d H:i:s');
	$tmp_sql ="INSERT INTO `".$table."`(`ffuid`, `title`, `desc`,`is_his`, `category`, `sub_category`, `create_date`, `modify_date`) VALUES (?i,?s,?s,?i,?i,?i,?s,?s)";
	$tmp_sql=prepare($tmp_sql,array($uid,$itmName,$itmDesc,0,0,0,$cf_now,$cf_now));
	run_sql($tmp_sql);

	$data=player_exp_op_by_uid($uid,4,3);	//表示,4=添加D12,3=+3		
	$ret_data['msg']='因为公告了新发现的事件【'.$itmName.'】('.$itmDesc.')!'.$data['msg'];

	return $ret_data;	
}

function player_attr_op_by_uid( $uid ,$attr_id , $num=0)
{
	$attr_id = intval($attr_id);
	$itmName='attr'.$attr_id;
	return player_ext_op_by_uid($uid,$itmName,$num,array('mode'=>1));

	
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');
	if($attr_id>=1 && $attr_id<=5){
		//ok
	}else{
		$ret_data['err_code']='#1';
		return $ret_data;
	}
	$uid = intval( $uid );
	$table = real_table_name('user_info');
	if( $data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . $uid . "'" , db() ) ){
		$msg = '';
		$fix = intval($num);
		$itmName='attr'.$attr_id;
		// $itmValue = intval($data[$itmName]);
		// $itmValue = $itmValue+$fix;
		// $cf_now = date('Y-m-d H:i:s');
		$table = real_table_name('exp_buff');
		$tmp_sql ="UPDATE  `".$table." SET `".$itmName."`=`".$itmName."` + ?i, WHERE `uid` =?i ";
		$tmp_sql=prepare($tmp_sql,array($fix,$uid));
		run_sql($tmp_sql);

		foreach ($data as $key => $value) {
			if($key==$itmName){
				$ret_data[$key]=$value+$fix;
			}else{
				$ret_data[$key]=$value;
			}
		}
		$ret_data['msg']='属性['.$attr_id.']增加了['.$fix.']点！';
	}
	return $ret_data;	
}

function player_ext_op_by_uid( $uid ,$itmName , $itmVal,$op=false)
{	
	$ret_data=array('err_code'=>0,'func_name'=>__FUNCTION__,'msg'=>'');
	if(!empty($itmName) && !empty($itmVal)){
		//ok
	}else{
		$ret_data['err_code']='1';
		$ret_data['msg']='parameter error!';
		return $ret_data;
	}
	$uid = intval( $uid );
	$table = real_table_name('user_info');
	if( $data = get_line( "SELECT * FROM `".$table."` WHERE `uid` = '" . $uid . "'" , db() ) ){
		$msg = '';
		// $cf_now = date('Y-m-d H:i:s');
		if($op && isset($op['mode']) && intval($op['mode'])==1){	//mode:1=add
			$itmVal = intval($itmVal);
			$ret_data['msg']='属性['.$itmName.']增加了['.$itmVal.']点！';			
			$tmp_sql ="UPDATE  `".$table."` SET `".$itmName."`=`".$itmName."` + ?i WHERE `uid` =?i ";
			$tmp_sql=prepare($tmp_sql,array(intval($itmVal),$uid));
		}else{
			$tmp_sql ="UPDATE  `".$table."` SET `".$itmName."`=?s WHERE `uid` =?i ";
			$tmp_sql=prepare($tmp_sql,array($itmVal,$uid));
			$ret_data['msg']='user_info ['.$itmName.'] set to ['.$itmVal.']!';
		}		
		run_sql($tmp_sql);
		$ret_data['sql']=$tmp_sql;

		// $ret_data['sql'].=kis_log($tmp_sql,__FUNCTION__);
		// $tt = md5($tmp_sql);
		// $ret_data['sql'].=kis_log($tmp_sql.$tt,__FUNCTION__.$tt);

		foreach ($data as $key => $value) {
			if($key==$itmName){
				if($op && isset($op['mode']) && intval($op['mode'])==1){
					$ret_data[$key]=$value+$itmVal;
				}else{
					$ret_data[$key]=$itmVal;
				}
				
			}else{
				$ret_data[$key]=$value;
			}
		}
		
	}else{
		$ret_data['err_code']='2';
		$ret_data['msg']='user_info not found or error!';
	}
	return $ret_data;	
}

function get_user_full_info_by_id( $uid )
{
	$table = real_table_name('user');
	return get_line( "SELECT * FROM `".$table."` WHERE `id` = '" . intval( $uid ) . "'" );
}

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



function close_user_by_id( $uid )
{
	$table = real_table_name('user');
	$sql = "UPDATE `".$table."` SET `is_closed` = '1' , `level` = 0  , `email` = CONCAT( `email` , 'closed-" . intval($uid) . '-' . time() . "' ) , `name` = CONCAT( `name` ,'" . intval($uid) . "' ) WHERE `id`  = '" . intval($uid) . "' LIMIT 1";
	run_sql( $sql );
}

function get_user_settings_by_id( $uid )
{
	$table = real_table_name('user');
	$sql = "SELECT `settings` FROM `".$table."` WHERE `id` = '" . intval($uid) . "' LIMIT 1";
	if( $settings = get_var($sql) )//
		return $array = unserialize( $settings );
	elseif( db_errno() == 0 )
		return array();
	else
		echo 'DBERROR-' . db_errno();	
		
	return false;
}

function get_group_unames( $group )
{
	$table = real_table_name('user');
	$sql = "SELECT `name` FROM `".$table."` WHERE `is_closed` = 0 AND `groups` LIKE '%|" . s(strtoupper($group)) . "|%'";
	if( $data = get_data( $sql ) )
		foreach( $data as $item )
			$unames[] = $item['name'];

	return isset($unames)?$unames:false;	
}

function get_group_names()
{
	if( !isset($GLOBALS['TT2_GNAMES']) )
	{
		$table = real_table_name('user');
		$sql = "SELECT `groups` FROM `".$table."` WHERE `is_closed` = 0 ";
		$groupstring = '|';
		if( $data = get_data( $sql ) )
			foreach( $data as $item  )
				if( strlen(trim($item['groups'])) > 1 )
					$groupstring = $groupstring . strtoupper($item['groups']).'|';

		if( $groupstring == '|' ) 
			$groups = false;
		else
		{
			$groups = explode( '|' ,  trim( $groupstring , '|' ) );
			if( is_array( $groups ) )
			{
				$groups  = array_unique($groups);
				foreach(  $groups as $k => $v )
					if( strlen(trim($v)) < 1 )
						unset($groups[$k]);		
			}
			
		} 
		

		$GLOBALS['TT2_GNAMES'] = $groups;	
	}
	

	return $GLOBALS['TT2_GNAMES']	;
}

function update_user_settings_array( $array )
{
	$table = real_table_name('user');
	$sql = "UPDATE `".$table."` SET `settings` = '" . s( serialize($array) ) . "' WHERE `id` = '" . intval( $_SESSION['uid'] ) . "' LIMIT 1";
	run_sql( $sql );
}

function add_todo( $text , $is_public = 0 , $uid = null )
{
	if( $uid == null || intval($uid) < 1 ) $uid = $_SESSION['uid'];
	
	$table = real_table_name('todo');
	$sql = "INSERT INTO `".$table."` ( `content` ,  `timeline` , `owner_uid` ) VALUES ( '" . s( $text ) . "'  , NOW() , '" . intval( $uid ) . "' ) ";
	run_sql( $sql );
	
	if( db_errno() != 0 ) return false;
	$lid = last_id();
	
	$table = real_table_name('todo_user');
	$sql = "INSERT INTO `".$table."` ( `tid` , `uid` , `is_public` ,`last_action_at` ) VALUES ( '" . intval( $lid ) . "' , '" . intval($uid) . "', '" . intval( $is_public ) . "' , NOW() )";
	run_sql( $sql );
	
	if( db_errno() != 0 ) return false;
	
	$table = real_table_name('todo_history');
	$sql = "INSERT INTO `".$table."` ( `tid` , `uid` , `content` , `type` , `timeline` ) VALUES ( '" . intval($lid) . "' , '" . intval($uid) . "' , '".__('TODO_CREATED')."' , 1 , NOW() )";
	
	run_sql( $sql );
	if( db_errno() != 0 ) return false;
	
	
	
	return $lid;
}

function get_todo_info_by_id( $tid , $write_db = null )
{
	if( $write_db != null ) $write_db = db();
	
	$table = real_table_name('todo');
	if(!$tinfo = get_line( "SELECT *,`id` as `tid` FROM `".$table."` WHERE `id` = '" . intval($tid) . "' LIMIT 1" , $write_db )) return false;
	
	$table = real_table_name('todo_user');
	// 检查todo是否已经被所有人删除
	if(!$owner_info = get_line( "SELECT * FROM `".$table."` WHERE `is_follow` = 0 AND `tid` = '" . intval( $tid ) . "'" )) return false;
	
	if( ($owner_info['uid'] != intval( $_SESSION['uid'] )) &&  ($owner_info['is_public'] != 1) ) return false;
	//if( $owner_info['is_public'] != 1 ) return false;
	
	
	
	// $table = real_table_name('todo_user');
	$data = $tinfo;
	$data['details'] = get_line( "SELECT * FROM `".$table."` WHERE `tid` = '" . intval($tid) . "' AND `uid` = '" . intval($_SESSION['uid']) . "' LIMIT 1" , $write_db );

	$table = real_table_name('todo_history');
	$hdata = get_data( "SELECT * FROM `".$table."` WHERE `tid` = '" . intval($tid) . "' ORDER BY `timeline` DESC LIMIT 100" , $write_db );
	
	
	if( is_array( $hdata ) )
	foreach( $hdata as $hitem )
	{
		$huids[] = $hitem['uid'];	
	}
	
		
	if( isset( $huids ) && is_array( $huids ) )
	{
		
		$table = real_table_name('user');
		$sql = "SELECT " . USER_INFO . " FROM `".$table."` WHERE `id` IN ( " . join( ' , ' , $huids ) . " )  ";
		
		if($udata = get_data( $sql ))
		{
			foreach( $udata as $uitem )
			{
				$uarray[$uitem['id']] = $uitem;
			}
			
			//print_r( $uarray );
			
			if( isset( $uarray ) )
			{
				foreach( $hdata as $k=>$hitem )
				{
					if( isset( $uarray[$hitem['uid']] ) )
						$hdata[$k]['user'] = $uarray[$hitem['uid']];
				}
			}
						
		}		
		
	}
	
	
	//print_r( $hdata );
	
	$data['history'] = $hdata;
	
	$table = real_table_name('user');
	$sql = "SELECT  " . USER_INFO . " FROM `".$table."` WHERE `id` IN ( SELECT `uid` FROM `todo_user` WHERE `tid` = '"  . intval($tid) . "' AND `is_follow` = 1 )  ";
	$data['people'] = get_data( $sql );
	
	$data['owner'] = get_line( "SELECT " .  USER_INFO . " FROM `".$table."` WHERE `id` = '" . intval($owner_info['uid']) . "' LIMIT 1 " );
	
	return $data;

}


function get_user_todo_list_by_uid( $uid = null )
{
	
	return false;	
	
}

function get_todo_text_by_id( $tid )
{
	$table = real_table_name('todo');
	return get_var("SELECT `content` FROM `".$table."` WHERE `id` = '" . intval( $tid ) . "' LIMIT 1");
}

function get_feed_by_id( $fid )
{
	$table = real_table_name('feed');
	if($feed = get_line("SELECT * FROM `".$table."` WHERE `id` = '" . intval( $fid ) . "' LIMIT 1"))
	{
		$table = real_table_name('user');
		$feed['user'] = get_line("SELECT " . USER_INFO . " FROM `".$table."` WHERE `id` = '" . intval($feed['uid']) . "'");
		return $feed;	
	}
	

	return false ;
}


function my_join( $sql ,  $array , $field , $as_field )
{

}

function send_notice( $uid , $content , $type = 1 , $data = null )
{
	$table = real_table_name('notice');
	$sql = "INSERT INTO `".$table."` ( `to_uid` , `content` , `type` , `data` , `timeline` ) VALUES( '" . intval( $uid ) . "' , '" . s($content) . "' , '" . intval( $type ) . "' , '" . serialize($data) . "' , NOW() )";
	run_sql( $sql );
	
	if( db_errno() != 0 ) die( db_error() );
	else
	{
		do_action('SEND_NOTICE_AFTER', array( 'uid' => $uid , 'content' => $content , 'type' => $type , 'data' => $data ) );
		return true;
	} 
}

function add_history( $tid , $content )
{
	$table = real_table_name('todo_history');
	$sql = "INSERT INTO `".$table."` ( `tid` , `uid` , `content` , `type` , `timeline` ) VALUES ( '" . intval($tid) . "' , '" . intval(uid()) . "' , '" . s( $content ) . "' , 1 , NOW() )";
	run_sql( $sql );
	return db_errno() == 0;
}


function publish_feed( $content , $uid , $type = 0 , $tid = 0  )
{
	if( is_mobile_request() ) $device = 'mobile';
	else $device = 'web';

	$tid = intval($tid);
	if( $type == 2 && $tid > 0 ){
		$table = real_table_name('todo_history');
		$comment_count = get_var( "SELECT COUNT(*) FROM `".$table."` WHERE `tid` = '" . intval($tid) . "' AND `type` = 2 " , db()) ;
	}else
		$comment_count = 0;

	$table = real_table_name('feed');
	$sql = "INSERT INTO `".$table."` ( `content` , `tid` , `uid` , `type` ,`timeline` , `device` , `comment_count` ) VALUES ( '" . s($content) . "' , '" . intval( $tid ) . "', '" . intval( $uid ) . "'  , '" . intval( $type ) . "' , NOW() , '" . s( $device ) . "' , '" . intval( $comment_count ) . "' )";
	run_sql( $sql );

	$lid = last_id();
	
	if( db_errno() != 0 )
		return  false;
	else
	{
		if( $comment_count > 0 && $type == 2 && $tid > 0 )
		{
			$sql = "UPDATE `".$table."` SET `comment_count` = '" . intval( $comment_count ) . "' WHERE `tid` = '" . intval( $tid ) . "' AND `comment_count` != '" . intval( $comment_count )  . "' ";
			run_sql( $sql );	
		}
		
		return $lid ;
	}
		
}

//end.
