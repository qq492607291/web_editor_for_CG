<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );

class buddyController extends appController
{
	function __construct()
	{
		parent::__construct();
		$this->check_login();
	}
	
	function index()
	{
		$data['title'] = $data['top_title'] = __('MEMBER_PAGE_TITLE');
		$data['js'][] = 'jquery.tagsinput.js';
		render( $data , 'web' , 'card' );
	}

	function data()
	{
		$data['title'] = $data['top_title'] = "用户列表";
		$data['outVar']=array();
		$data['html_data']= '';
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

			$item_src_tpl = file_get_contents(TPLROOT.'part\buddy.tpl.html');

			// clean password field
			foreach( $ret_data as $k=>$v )
			{
				$ret_data[$k]['password'] = null;
				unset($ret_data[$k]['password']);

				$item_src = $item_src_tpl;
				$k_str = 'pinyin;name;id;avatar_small;email';
				$k_arr = explode(';', $kk);
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

	function groups()
	{
		$params = array();
		
		if($content = send_request( 'groups' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			
			if( $data['err_code'] != 0 ) return render( array( 'code' => $data['err_code'] , 'message' => $data['err_msg'] ) , 'rest' );
			return render( array( 'code' => 0 , 'data' => $data['data'] ) , 'rest' );

		}

		return null;
	}

	function update_groups()
	{
		$uid = intval(v('uid'));
		if( $uid < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );

		$groups = z(t(v('groups')));
		// remove spaces in name
		$groups = str_replace( ',' , '|' , $groups );
		
		$params = array();
		$params['uid'] = $uid;
		$params['groups'] = $groups;
		
		if($content = send_request( 'user_update_groups' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			
			if( $data['err_code'] != 0 ) return render( array( 'code' => $data['err_code'] , 'message' => $data['err_msg'] ) , 'rest' );

			return render( array( 'code' => 0 , 'data' =>  array( 'html' => render_html( array( 'item' => $data['data'] ) , AROOT . 'view' 
						. DS . 'layout' . DS . 'ajax' . DS . 'widget' . DS . 'buddy.tpl.html'  ) ) ) , 'rest' );
		}

		return render( array( 'code' => 100001 , 'message' => __('API_CONNECT_ERROR_NOTICE') ) , 'rest' );

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

			return render( array( 'code' => 0 , 'data' =>  array( 'html' => render_html( array( 'item' => $data['data'] ) , AROOT . 'view' 
						. DS . 'layout' . DS . 'ajax' . DS . 'widget' . DS . 'buddy.tpl.html'  ) ) ) , 'rest' );
		}

		return render( array( 'code' => 100001 , 'message' => __('API_CONNECT_ERROR_NOTICE') ) , 'rest' );
	}

	function admin_user()
	{
		$uid = intval(v('uid'));
		if( $uid < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );

		if( intval(v('set')) == 1 ) $level = '9';
		else $level = '1';

		$params = array();
		$params['uid'] = $uid;
		$params['level'] = $level;

		
		if($content = send_request( 'user_level' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			if( $data['err_code'] != 0 ) return render( array( 'code' => $data['err_code'] , 'message' => $data['err_msg'] ) , 'rest' );
			
			return render( array( 'code' => 0 , 'data' =>  array( 'html' => render_html( array( 'item' => $data['data'] ) , AROOT . 'view' 
						. DS . 'layout' . DS . 'ajax' . DS . 'widget' . DS . 'buddy.tpl.html'  ) ) ) , 'rest' );
		}

		return render( array( 'code' => 1000012 , 'message' => __('API_CONNECT_ERROR_NOTICE').$content ) , 'rest' );
	}

	function user_close()
	{

		$uid = intval(v('uid'));
		if( $uid < 1 ) return render( array( 'code' => 100002 , 'message' => __('BAD_ARGS') ) , 'rest' );
		
		
		$params = array();
		$params['uid'] = $uid;

		if($content = send_request( 'user_close' ,  $params , token()  ))
		{
			$data = json_decode($content , 1);
			if( $data['err_code'] != 0 ) return render( array( 'code' => $data['err_code'] , 'message' => $data['err_msg'] ) , 'rest' );
			
			return render( array( 'code' => 0 , 'data' => $data['data'] ) , 'rest' );
		}

		return render( array( 'code' => 100001 , 'message' => __('API_CONNECT_ERROR_NOTICE') ) , 'rest' );
	}

	

	
}