<?php
if( !defined('IN') ) die('bad request');
include_once( CROOT . 'controller' . DS . 'core.class.php' );

ini_set( 'display_errors' , true );
error_reporting(E_ALL ^ E_NOTICE);

class admController extends coreController
{
	function __construct()
	{

		// 载入默认的
		parent::__construct();
		
		$this->check_login();
				
	}

	function check_login()
	{
		$ret_arr=array();
		api_header();
		if( !is_login() ) {
  			echo api_result_json($ret_arr,'你访问的内容，需要先登录！Need Login!',1001);
  			die();
		}

		if(isset($GLOBALS['config']['runtime_env_check'])){
			$runtime_env_check=$GLOBALS['config']['runtime_env_check'];
			if($runtime_env_check =='local'){
				//local dev ,logined ,pass
				return true;
			}
		}
		
		if( !is_admin() ){
  			die(api_result_json($ret_arr,'你访问的内容，需要管理员权限才能操作！',1002));	
		}
	}

	private function get_idx_by_val($arr,$val){
		if(is_array($arr))
		foreach ($arr as $key => $value) {
			if($value==$val){
				return $key;
			}
		}
		return false;
	}

/**


**/	

	function jsMiddleSchool()
	{
		$ret_arr=array();
		api_header();

		$code=v('adm');
		if($code=='2016'){
			$select_middleSchool=array();
			$dict_middleSchool=array();

		// select loc FROM `middle_school_info` GROUP BY loc ORDER BY id
			$tmp_sql="SELECT * FROM `middle_school_info` GROUP BY loc ORDER BY id ";
			$ret_sql = get_data($tmp_sql );
			if($ret_sql!=false){
				$idx = -1;
				$last_loc=null;
				foreach ($ret_sql as $key => $value) {
					
					if($last_loc!==$value['loc']){
						$idx++;
						$select_middleSchool[$idx]=$value['loc'];
						$dict_middleSchool[$idx]=array();
						$last_loc=$value['loc'];
					}

					// $dict_middleSchool[$idx][$value['id']]=$value['title'];
				}
			}


// SELECT * FROM `middle_school_info` order by loc desc,ybl2015+0 desc,ebl2015+0 desc
			$tmp_sql="SELECT * FROM `middle_school_info` order by loc desc,ybl2015+0 desc,ebl2015+0 desc ";
			$ret_sql = get_data($tmp_sql );
			if($ret_sql!=false){
				$idx = -1;
				$last_loc=null;
				foreach ($ret_sql as $key => $value) {
					
					if($last_loc!==$value['loc']){						
						$last_loc=$value['loc'];
						$idx=$this->get_idx_by_val($select_middleSchool,$last_loc);
					}

					// $dict_middleSchool[$idx][$value['id']]=$value['title'];
					$dict_middleSchool[$idx][]=$value['id'].'=='.$value['title'];
				}

				// print_r($select_middleSchool);
				// print_r($dict_middleSchool);
				foreach ($select_middleSchool as $key => $value) {
					echo 'mid_sch_select_key['.$key."] = '".$value."';".PHP_EOL;
				}

				foreach ($dict_middleSchool as $key => $value) {
					echo 'mid_sch_option_key['.$key."] = Array();".PHP_EOL;
					foreach ($value as $k2 => $v2) {
						echo "mid_sch_option_key[".$key."]['".$k2."'] = '".$v2."';".PHP_EOL;	
					}
					
				}
				die();
				die(api_result_json($ret_sql,'sql ok!'));
			}
		}
			
		die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1100));
	}


	function jsMajorConfig()
	{
		$ret_arr=array();
		api_header();

		$code=v('adm');
		if($code=='2016'){

			$tmp_sql="SELECT * FROM `major_config` limit 3000";
			$ret_sql = get_data($tmp_sql );
			if($ret_sql!=false){
				// die(api_result_json($ret_sql,'sql ok!'));
				$idx = 0;
				$cat1=null;
				foreach ($ret_sql as $k2 => $v2) {
					$cat_now = substr($v2['code'],0,2);
					if($cat1 != $cat_now){
						$cat1=$cat_now;
						$idx ++;
						$idx2 = 0;						
						echo 'maj_conf_select_key['.$idx."] = '".$v2['title']."';".PHP_EOL;
						echo 'maj_conf_option_key['.$idx."] = Array();".PHP_EOL;
					}else{
						$tt = $v2['code']."==".$v2['title'];
						$tt = substr($tt,2);
						echo "maj_conf_option_key[".$idx."][".$idx2."] = '".$tt."';".PHP_EOL;
					$idx2++;	
					}
					
				}
				die();
			}
		}			
		die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1100));
	}

	function fix_table_sch_inf_admission_score()	
	{
/*
//大学分数线,用于大学首页搜索

ALTER TABLE `school_info`
ADD COLUMN `min_score`  mediumint(4) NULL COMMENT '分数线' AFTER `sch_id`;

ALTER TABLE `school_info`
MODIFY COLUMN `min_score`  mediumint(4) NULL DEFAULT NULL COMMENT '去年/最低分数线' AFTER `sch_id`,
ADD COLUMN `min_score1`  mediumint(4) NULL COMMENT '文科分数线' AFTER `min_score`,
ADD COLUMN `min_score2`  mediumint(4) NULL COMMENT '理科分数线' AFTER `min_score1`,
ADD COLUMN `subject_cat`  tinyint(1) NULL COMMENT '1=文科2=理科' AFTER `min_score2`;

*/
		$ret_arr=array();
		api_header();

		$code=v('adm');
		if(empty($code) || intval($code)!=2016){
			die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1100));
		}

		// SELECT `uuid`, `code`, `school_title`, `major_title`, `pici`, `x2`, `plan2012`, `offer2012`, `lowest2012`, `plan2013`, `offer2013`, `lowest2013`, `plan2014`, `offer2014`, `lowest2014`, `yibenxian2012`, `erbenxian2012`, `yibenxian2013`, `erbenxian2013`, `yibenxian2014`, `erbenxian2014` FROM `school_admission_score` WHERE 1
		// select * from `school_admission_score` where `major_title` = 'all'
		$tmp_sql="SELECT * FROM `school_admission_score` where `major_title` = 'all' limit 3000";
		$ret_sql = get_data($tmp_sql );
		if($ret_sql===false){
			die(api_result_json($ret_arr,'检索失败！'.__METHOD__.'()'.$tmp_sql,1200));
		}	

// UPDATE `school_info` SET `code`=[value-1],`is_done`=[value-2],`verkey`=[value-3],`title`=[value-4],`ud1`=[value-5],`ud2`=[value-6],`ud3`=[value-7],`ud4`=[value-8],`ud5`=[value-9],`ud6`=[value-10],`ud7`=[value-11],`ud8`=[value-12],`ud9`=[value-13],`cf1`=[value-14],`cf2`=[value-15],`majorInfo`=[value-16],`sch_id`=[value-17],`min_score`=[value-18] WHERE 1

		$idx = 0;
		$cat1=null;
		foreach ($ret_sql as $k => $v) {
			$sch_code = $v['code'];

			$tmp3_sql=prepare("SELECT * FROM `school_info` WHERE `code` =?s limit 1 ",array($sch_code));
			$ret_sch_info=get_line($tmp3_sql);
			if($ret_sch_info!==false){

				$sch_min_score=intval($ret_sch_info['min_score']);

				$min_score = $v['lowest2014'];
				$min_score = intval($min_score);

				if($min_score<$sch_min_score){
					$sch_min_score=$min_score;
				}

				if(stripos($v['x2'], '理工类')!=false){
					$tmp2_sql=prepare("UPDATE `school_info` SET `min_score2`=?i, `is_subject_cat2`=?i, `min_score`=?i WHERE `code` =?s limit 1 ",array($min_score,1,$sch_min_score,$sch_code));
				}else{
					$tmp2_sql=prepare("UPDATE `school_info` SET `min_score1`=?i, `is_subject_cat1`=?i, `min_score`=?i WHERE `code` =?s limit 1 ",array($min_score,1,$sch_min_score,$sch_code));
				}

				echo red_span($v['school_title']).'<br/>'.PHP_EOL;
				if($ret2_sql = run_sql($tmp2_sql )){
					// echo $v['school_title'] . ' fix ok '.$min_score.PHP_EOL;
				}else{
					echo $v['school_title'] . ' fix ERROR!!! '.$min_score.PHP_EOL;
				}

			}
			
		}

		die();
	}


	function js_university_comp_ranking()
	{
		$ret_arr=array();
		api_header();

		$code=v('adm');
		if($code=='2016'){

			$tmp_sql="SELECT * FROM `university_comp_ranking` order by ranking limit 3000";
			$ret_sql = get_data($tmp_sql );
			if($ret_sql!=false){
				// die(api_result_json($ret_sql,'sql ok!'));
				$idx = 0;
				$cat1=null;
				foreach ($ret_sql as $k => $v) {
					$idx ++;
					echo 'uni_rank_select_key['.$idx."] = '".$v['title']."';".PHP_EOL;
					// $tt=$v['title'].'**';
					$tt=$v['location'].'=='.$v['nature'];
					echo 'uni_rank_option_key['.$idx."] = '".$tt."';".PHP_EOL;
				}
				die();
			}
		}			
		die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1100));
	}


	function js_uni_base_info()
	{
		$ret_arr=array();
		api_header();

		$code=v('adm');
		if($code=='2016'){

			$tmp_sql="SELECT `code`, `ud1` as nature, `ud2` as location, `ud3` , `ud6` as title,`salary5`,`ind0` as industry FROM `shdic_crx_p2015qq176806817_school` order by code limit 3000";			
			$ret_sql = get_data($tmp_sql );
			if($ret_sql!=false){
				// die(api_result_json($ret_sql,'sql ok!'));
				$idx = 0;
				$cat1=null;

				echo 'var uni_bsk = new Object(); //select_key'.PHP_EOL;
				echo 'var uni_bok = new Array(); //option_key'.PHP_EOL;

				foreach ($ret_sql as $k => $v) {
					$score1='0';
					$score2='0';					
					$tmp_sql2=prepare("SELECT * FROM `school_info` Where code=?s limit 1",array($v['code']));
					if($ret_sql2 = get_line($tmp_sql2 )){
						if(isset($ret_sql2['min_score1']) && intval($ret_sql2['min_score1'])>0){
							$score1=intval($ret_sql2['min_score1']);
						}
						if(isset($ret_sql2['min_score2']) && intval($ret_sql2['min_score2'])>0){
							$score2=intval($ret_sql2['min_score2']);
						}
					}

					$idx ++;
					echo 'uni_bsk['.$idx."] = '".$v['code']."';".PHP_EOL;
					$tt=trim($v['title']).'|';
					$tt.=$v['location'].'|'.$v['nature'].'|';
					$tt.=$v['salary5'].'|'.$v['industry'].'|';
					$tt.=$score1.'|'.$score2.'|';

					$ud3='kk'.$v['ud3'];
					if(stripos($ud3, '本科')!==false){
						$tt.='bk';
					}
					if(stripos($ud3, '专科')!==false){
						$tt.='zk';
					}
					echo 'uni_bok['.$idx."] = '".$tt."';".PHP_EOL;
				}
				die();
			}
		}			
		die(api_result_json($ret_arr,'检索参数无效！'.__METHOD__.'()'.$code,1100));
	}

}


?>