<?php
if( !defined('IN') ) die('bad request');
include_once( CROOT . 'controller' . DS . 'core.class.php' );

ini_set( 'display_errors' , true );
error_reporting(E_ALL ^ E_NOTICE);

class memberController extends coreController
{
	function __construct()
	{

		// 载入默认的
		parent::__construct();		
		$this->check_login();
				
	}

	function check_login()
	{
		if( !is_login() ) {
			// die('wa hahahah '.__METHOD__.'(DEBUG)');
			$ret_arr=array();
  			die(api_result_json($ret_arr,'你访问的内容，需要先登录！',1001));
		}	
	}
	
	function get_dingwei()
	{
		$ret_arr=array();
		api_header();

		$uid=uid();
		if ($uid==false || $uid==0){
	  		die(api_result_json($ret_arr,'登陆用户无效！'.__METHOD__.'() '.$uid,1001));
		}

		$tmp_sql=prepare("SELECT * FROM `user_location_info` WHERE `owner_uid` =?s limit 1",array($uid));

		$ret_sql=get_data($tmp_sql);
		if($ret_sql===false){
			die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$tmp_sql,1100));
		}

		$ret_sql=$ret_sql[0];

		$ret_arr[]=array('ui_id'=>'district','value'=>$ret_sql['area'],'op'=>1);
		$ret_arr[]=array('ui_id'=>'paiming3','value'=>$ret_sql['paiming'],'op'=>1);
		$ret_arr[]=array('ui_id'=>'school','value'=>$ret_sql['school_id'],'op'=>1);
		$ret_arr[]=array('ui_class'=>'subject_cat','value'=>$ret_sql['subject_cat'],'op'=>1);
		$ret_arr[]=array('ui_id'=>'total_number','value'=>$ret_sql['total_number'],'op'=>1);
		// $ret_arr[]=$ret_sql;
		// $ret_arr[]=$tmp_sql;
  		echo api_result_json($ret_arr,'sql ok!');
  		die();

	}

	function add_favorites()
	{
		return $this->op_favorites_uuid_rel(1,1);	//添加,收藏
	}

	function add_volunteer()
	{
		return $this->op_favorites_uuid_rel(1,5);	//添加,志愿
	}

	function del_favorites()
	{
		return $this->op_favorites_uuid_rel(2,1);	//删除,收藏
	}

	function del_volunteer()
	{
		return $this->op_favorites_uuid_rel(2,5);	//删除,志愿
	}

	private function op_favorites_uuid_rel($op,$cat=1)
	{
		$ret_arr=array();
		api_header();
		$cat_desc='收藏';
		if($cat==5) $cat_desc='志愿';

		$op_desc='添加';
		if($op!==1) $op_desc='删除';


		$uid=uid();
		if ($uid==false || $uid==0){
	  		die(api_result_json($ret_arr,'登陆用户无效！'.__METHOD__.'() '.$uid,1001));
		}

		$code=v('scode');
		$ret_src='';

		if(!empty($code) ){			
			$cf_now = date('Y-m-d H:i:s');
  			// $ret_src.='init';
  			// $cat=1;
  			$ret_src.=$op_desc;			
			// echo "debug:".$tmp_sql;

			$count=get_favorites_uuid_rel_count($uid,$cat,$code);
			if($count===false){
				die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$tmp_sql,1102));
			}

			if($op==1){
				//add
				if(intval($count)==0){
					$ret_add=add_favorites_uuid_rel($uid,$cat,$code);

					if($ret_sql){
						$ret_src.='成功！';
						die(api_result_json($ret_arr,$ret_src));
					}else{
						$ret_src.='失败！';
						$ret_src.=' sql:'.$tmp_sql;
						die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1101));
					}		

				}else{
					$ret_src.='失败！已经存在'.$cat_desc.'记录！';				
					die(api_result_json($ret_arr,$ret_src));
				}

			}else{
				//del
				if(intval($count)>0){
					$ret_sql = del_favorites_uuid_rel($uid,$cat,$code);

					if($ret_sql){
						$ret_src.='成功！';
						die(api_result_json($ret_arr,$ret_src));
					}else{
						$ret_src.='失败！';
						$ret_src.=' sql:'.$tmp_sql;
						die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$tmp_sql,1101));
					}
				}

				$ret_src.='失败！';

			}

    	}

    	die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code.$ret_src,1100));

	}


	function get_favorites()
	{
		$ret_arr=array();
		api_header();

		$uid=uid();
		if ($uid==false || $uid==0){
	  		die(api_result_json($ret_arr,'登陆用户无效！'.__METHOD__.'() '.$uid,1001));
		}

		
		$cf_now = date('Y-m-d H:i:s');
		$cat=1;
		$ret_src='';

		$tmp_sql = prepare('SELECT count(*) as num FROM `favorites_uuid_rel` WHERE `is_his`=0 AND uid=?s and category=?s limit 32' ,array($uid,$cat)); 
		// echo "debug:".$tmp_sql;
		$count=get_var($tmp_sql);
		if($count===false){
			die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$tmp_sql,1102));
		}
		if(intval($count)==0){
			die(api_result_json($ret_arr,'您还没有收藏过！',110));
		}

		$tmp_sql = prepare('SELECT id,uuid FROM `favorites_uuid_rel` WHERE `is_his`=0 AND uid=?s and category=?s limit 32' ,array($uid,$cat)); 

		// echo "debug:".$tmp_sql;

		$ret_sql=get_data($tmp_sql);
		if($ret_sql===false){
			die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$tmp_sql,1102));
		}
		$ret_src.='成功！';
		die(api_result_json($ret_sql,$ret_src));

	}

	
}


?>