<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );

class adminController extends appController
{
	function __construct()
	{
		parent::__construct();
		$this->check_login();
	}
	
	function index()
	{
		$data['title'] = $data['top_title'] = "用户列表";
		$data['outVar']=array();
		$data['html_data']= '';

		// $data['outVar']['debug_html']=shdic_pass_v2015('ef8e38e1b4e5',1); 

		$data['outVar']['nav_src']=user_nav_html('admin.index');
		

		$src = '';

		$table = real_table_name('user');
		$sql = "SELECT * FROM `".$table."` WHERE `is_closed` = 0 LIMIT 500";
		if( !$ret_data = get_data( $sql ) )
		{
			if( db_errno() == 0  )
				$src .= __('API_MESSAGE_EMPTY_RESULT_DATA');
			else
				$src .= __('API_MESSAGE_DATABASE_ERROR') . mysql_error() ;

		}

		if( is_array($ret_data) ){

			$item_src_tpl = file_get_contents(TPLROOT.'part/buddy.tpl.html');

			// clean password field
			foreach( $ret_data as $k=>$v )
			{
				$ret_data[$k]['password'] = null;
				unset($ret_data[$k]['password']);

				$item_src = $item_src_tpl;
				$k_str = 'pinyin;name;id;avatar_small;email';
				$k_arr = explode(';', $k_str);
				foreach ($k_arr as $kk) {
					if(isset($v[$kk])){
						$item_src = str_ireplace('[var.out.'.$kk.']', $v[$kk], $item_src);	
					}else{
						$item_src = str_ireplace('[var.out.'.$kk.']', 'MISS_'.$kk, $item_src);	
					}
				}

				$src .= $item_src . PHP_EOL;
			}
		}
		
		$data['outVar']['buddy_list']= $src;

		return render( $data , 'web' , 'admin.index' );
	}

	function add()
	{

		//ajax_echo( print_r( $_REQUEST , 1 ) );
		$name = z(t(v('name')));
		// remove spaces in name
		$name = str_replace( ' ' , '' , $name );
		if( strlen($name) < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );

		$email = z(t(v('email')));
		if( strlen($email) < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );

		$password = z(t(v('password')));
		if( strlen($password) < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );


		$params = array();
		$params['name'] = $name;
		$params['email'] = $email;
		$params['password'] = $password;

		if($content = send_request( 'user_sign_up' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			
			if( $data['err_code'] != 0 ) return render( array( 'code' => $data['err_code'] , 'message' => $data['err_msg'] ) , 'rest' );

			return render( $data , 'web' , 'admin.index' );
		}

		return render( array( 'code' => 100001 , 'message' => __('API_CONNECT_ERROR_NOTICE') ) , 'rest' );
	}


	function user_reset_password()
	{
		$params = array();
		$params['uid'] = intval(v('uid'));

		
		if($content = send_request( 'user_reset_password' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			return render( array( 'code' => 0 , 'data' => $data['data'] ) , 'rest' );
		}

		return render( array( 'code' => 100001 , 'message' => __('API_MESSAGE_CANNOT_CONNECT') ) , 'rest' );
	}

}