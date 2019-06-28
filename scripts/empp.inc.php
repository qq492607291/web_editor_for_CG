<?php
date_default_timezone_set('PRC');

if(!isset($_GET['c']) || !isset($_GET['a']) ){
	die('Access Denied/Forbidden');
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

/*
 +-------------------------------
 *    @socket连接移动EMPP
 +-------------------------------
 *    By:Walk Mop
 *    QQ:724300270
 +--------------------------------
 */
error_reporting(E_ALL);
set_time_limit(0);

$port = 9981;
$ip = "211.136.163.68";
//发送的手机号及内容
$mobile = $_GET['c'];
$content =utf8_to_gb2312($_GET['a']);

if(strpos($content, '[timestamp]')){
	$content =str_replace('[timestamp]', time(), $content);
}

//平台帐号密码
$accountId = '10657109018769';
$password = "xujiahuilu*100130";

$serviceId = "okikixia10013*6";

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket < 0) {
    echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
}

$result = socket_connect($socket, $ip, $port);
if ($result < 0) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
}

$Timestamp = date("mdHis");

//消息头
$Command_Id = pack("N",1);
$Sequence_Id = pack("N",1);
//消息体
$account = $accountId.pack("C*",0,0,0,0,0,0,0);	//加二进制的0补全到21位
$accountMD5 = $accountId.pack("C*",0,0,0,0,0,0,0,0,0);	//加9个二进制的0

$AuthenticatorSource = md5($accountMD5.$password.$Timestamp,true);
$Version = pack("H",'1.0');
$Timestamp = pack("N",$Timestamp);

$Message = $Command_Id.$Sequence_Id.$account.$AuthenticatorSource.$Version.$Timestamp;
$Total_Length = pack("N",strlen($Message)+4);

$out = '';
$in = $Total_Length.$Message;

if(!socket_write($socket, $in, strlen($Message)+4)) {
    echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
}
//--------------------------接受移动返回消息-----------------------------------------
$out = socket_read($socket,37);
$arryResult = unpack("C*",$out);
foreach($arryResult as $key=>$value){
	//消息需要的话自己组下
	var_dump($arryResult);
}

/* 
	没激活的此处可能需要写激活代码，也可以去平台激活帐号
*/

//===========================短信发送=================================================

//消息头
$Command_Id = pack("N",4);
$Sequence_Id = pack("N",0);
//消息体,保留字段全为0
$Msg_Id = pack("C*",0,0,0,0,0,0,0,0,0,0);
$Pk_total = pack("h",1);
$Pk_number = pack("h",1);
$Registered_Delivery = pack("h",1); //返回状态
$Msg_Fmt = pack("C",15); //含GB汉字格式
$ValId_Time = pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$At_Time = pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //即时发送
$DestUsr_tl = pack("N",1);
$moblieAscii = '';
for($i=0;$i<strlen($mobile);$i++){
	$moblieAscii .= pack("C",ord(substr($mobile,$i,1)));
}
$Dest_terminal_Id = $moblieAscii.pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //手机号补全到32字节
$Msg_Length = pack("C",strlen($content));
$contentAscii = '';
for($i=0;$i<strlen($content);$i++){
	$contentAscii .= pack("C",ord(substr($content,$i,1)));
}
$Msg_Content = $contentAscii;
$Msg_src = pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //保留字段，默认抓包内容
$Src_Id = $account; //帐号取上面的21位
$Service_Id = pack("C*",48,0,0,0,0,0,0,0,0,0);
//==========以下保留字段===============
$LinkID = pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$Msg_level = pack("C",1);
$Fee_UserType = pack("C",2);
$Fee_terminal_Id = pack("C*",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$Fee_terminal_type = pack("C",0);
$TP_pId = pack("C",0);
$TP_udhi = pack("C",0);
$FeeType = pack("CC",48,49);
$FeeCode = pack("C*",48,0,0,0,0,0);
$Dest_terminal_type = pack("C",0);

$Message = $Command_Id.$Sequence_Id.$Msg_Id.$Pk_total.$Pk_number.$Registered_Delivery.$Msg_Fmt.$ValId_Time.$At_Time.$DestUsr_tl.$Dest_terminal_Id.$Msg_Length.$Msg_Content.$Msg_src.$Src_Id.$Service_Id.$LinkID.$Msg_level.$Fee_UserType.$Fee_terminal_Id.$Fee_terminal_type.$TP_pId.$TP_udhi.$FeeType.$FeeCode.$Dest_terminal_type;
$Total_Length = pack("N",strlen($Message)+4);

$in = $Total_Length.$Message;

if(!socket_write($socket, $in, strlen($Message)+4)) {
    echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
}

//下面可以接受发送返回的状态

echo "关闭SOCKET...\n";
socket_close($socket);
echo "关闭OK\n";
?>
