<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );
include_once APP_ROOT . DS .'ext'.DS.'sms'.DS.'sms.inc.php';

class guestController extends appController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		// if( is_mobile_request() ) return forward( 'client/' );
		if( is_login() ) return forward( '?c=dashboard' );
		
		// do login
		$data['title'] = $data['top_title'] = __('LOGIN_PAGE_TITLE');
		$data['css'][] = 'login_screen.css';

		$data['langs'] = @glob( AROOT . 'local/*.lang.php'  );

		$data['outVar']=array();
		$data['outVar']['email']=v('email');
		$data['outVar']['password']=v('password');
		$data['html_data']= '';

		return render( $data , 'web' , 'default' );
	}

	function reg()
	{
		// if( is_mobile_request() ) return forward( 'client/' );
		if( is_login() ) return forward( '?c=dashboard' );
		
		// do login
		$data['title'] = $data['top_title'] = '注册';

		$body = '';

		$body .= ' 很高兴在这里看到你！<br/>';
		$body .= '<br/><br/>'. '在线注册功能还没开始做 :) ，请在官方贴吧报名帖报名!  <br/>';
		$tt = 'http://tieba.baidu.com/p/3625670235';
		$body .= '<br/><br/><a href="'.$tt.'" target="new">官方贴吧报名帖'.$tt.'</a>';

		$data['html_data']= $body;
		return render( $data , 'web' , 'base' );
	}

	function i18n()
	{
		@session_write_close(); 
		$c = z(t(v('lang')));

		if( strlen($c) < 1 )
		{
			$c = c('default_language');
			if( strlen($c) < 1 ) $c = 'zh_cn';	
		}
		
		if( !isset(  $GLOBALS['language'][$c] ) )
		{
			$lang_file = AROOT . 'local' . DS . basename($c) . '.lang.php';
			if( file_exists( $lang_file ) )
				include_once( $lang_file );
		}

		$data['js_items'] = js_i18n( $GLOBALS['language'][$c] );

		return render( $data , 'ajax' , 'js' );

	}
	
	function login()
	{
		if( $user = login( v('email') , v('password') ) )
		{			
			foreach( $user as $key => $value ){
				$_SESSION[$key] = $value;
			}

			$disp_name = $_SESSION['uname']  .' ( ' . safe_email($_SESSION['email']) .' ) ';
			$_SESSION['dispname'] = $disp_name;
			update_user_online();

			return ajax_echo( __('LOGIN_OK_NOTICE') .jsforword('?c=dashboard'));

		}elseif( $user === null )
		{
			return ajax_echo( __('API_CONNECT_ERROR_NOTICE') );
		}
		else
		{
			return ajax_echo( __('LOGIN_BAD_ARGS_NOTICE') );
		}
	}
	
	function login2()
	{
		$tt = array();
		if( $user = login( v('email') , v('password') ) )
		{
			foreach( $user as $key => $value ){
				$_SESSION[$key] = $value;
			}

			$login_bonus=check_user_has_login_bonus(uid());			

			update_user_online();
			// $disp_name = $_SESSION['uname']  .' ( ' . safe_email($_SESSION['email']) .' ) ';
			// $_SESSION['dispname'] = $disp_name;

			// $tt = print_r($_SESSION,true);
			//$tt = array('message'=>__('LOGIN_OK_NOTICE'),'token'=>$_SESSION['token']);
			//$tt = array();
			foreach( $user as $key => $value ){
				$tt[$key] = $value;
			}
			$tt['message']=__('LOGIN_OK_NOTICE');
			$tt['login_time']=date('Y-m-d H:i:s');

			if(isset($login_bonus['err_code']) && $login_bonus['err_code']==0){
				// $tt['alert']='你已经获得过本轮[每小时一次]的登录奖励了。';
			}else{
				//todo
				$tt['alert']='你获得了本轮[每小时一次]的登录奖励！';
			}
			if(isset($tt['alert']) && isset($login_bonus['msg']))
				$tt['alert'].=$login_bonus['msg'];

			return ajax_echo(json_encode($tt));

		}elseif( $user === null )
		{
			$tt['message']=__('API_CONNECT_ERROR_NOTICE');
			return ajax_echo(json_encode($tt));
		}
		else
		{
			$tt['message']=__('LOGIN_BAD_ARGS_NOTICE');
			return ajax_echo(json_encode($tt));
		}
	}

	function reg2()
	{
		$tt = array('err_code'=>100,'message'=>'UNKNOW!');
		if( $user = pc_reg( v('email') , v('password') ) )
		{
			if(isset($user['err_code']) && intval($user['err_code'])>0){
				$tt['message']=$user['msg'];			
			}else{
				$tt['message']='注册成功！';
				$tt['err_code']=0;
				// $tt['login_time']=date('Y-m-d H:i:s');	
			}
			return ajax_echo(json_encode($tt));

		}elseif( $user === null )
		{
			$tt['message']=__('API_CONNECT_ERROR_NOTICE');
			return ajax_echo(json_encode($tt));
		
		}else
		{
			$tt['message']=__('LOGIN_BAD_ARGS_NOTICE');
			return ajax_echo(json_encode($tt));
		}
	}

	function logout()
	{
		foreach( $_SESSION as $key=>$value )
		{
			unset( $_SESSION[$key] );
		}
		
		forward('?c=guest');
	}

	function install()
	{
		if( is_installed() )
			return info_page( __('INSTALL_FINISHED') );
		elseif( intval(v('do')) == 1 )
		{
			db_init();			
		}
		else
		{
			$data['title'] = $data['top_title'] =  __('INSTALL_PAGE_TITLE') ;
			$data['outVar']=array();
			$data['outVar']['phpversion_lt_520']= version_compare(PHP_VERSION, '5.2.0' , '<')  ?' class="bad" ':'';
			$data['outVar']['phpversion']=phpversion();

			$data['outVar']['api_server_ck']='';
			if(   strtolower(str_replace('//' , '/' , $_SERVER['PHP_SELF'] )) != strtolower(str_replace('http://'.$GLOBALS['config']['site_domain'] , '' , c('api_server'))  ) ) {
				$data['outVar']['api_server_ck']= ' class="bad" '; 
			}

			$data['outVar']['api_server_url']='http://'.c('site_domain').$_SERVER['PHP_SELF'];
			$data['outVar']['api_server_conf']=c('api_server');

			return render( $data , 'web' , 'guest.install' );
		}
	}

/**

**/



}