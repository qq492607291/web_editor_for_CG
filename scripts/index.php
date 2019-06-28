<?php
/**
KS 492607291@qq.com
**/
date_default_timezone_set("Asia/Shanghai");
// $cf1 = date('Y-m-d H:i:s');
// $cf1 = substr($cf1,0,10);
// die($cf1);

function transcribe($aList, $aIsTopLevel = true) 
{
   if( !function_exists('get_magic_quotes_gpc') ) return $aList;

   $gpcList = array();
   $isMagic = get_magic_quotes_gpc();
  
   foreach ($aList as $key => $value) {
       if (is_array($value)) {
           $decodedKey = ($isMagic && !$aIsTopLevel)?stripslashes($key):$key;
           $decodedValue = transcribe($value, false);
       } else {
           $decodedKey = stripslashes($key);
           $decodedValue = ($isMagic)?stripslashes($value):$value;
       }
       $gpcList[$decodedKey] = $decodedValue;
   }
   return $gpcList;
}

//$_GET = transcribe( $_GET ); 
//$_POST = transcribe( $_POST ); 
//$_REQUEST = transcribe( $_REQUEST );

function v( $str )
{
	return isset( $_REQUEST[$str] ) ? $_REQUEST[$str] : false;
}


/**

**/

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<!-- jQuery CDN--><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<title>Simple Dev Tools</title>
<style type="text/css">
body{
	transition: background-color 1.5s ease;
	background-color: #D1EAF7
	/*background-image: linear-gradient(90deg, #e3e1fc, #f6ffbe);*/
}
#div_page{
	margin:50px;
}
#div_names{
	margin-left:50px;
	margin-right:50px;
	margin-top:20px;
	margin-bottom:20px;
}
.button_player{
	width:100%;
	text-align:left;
}
#textarea_log_input{
	height:300px;
	text-align:left;
	width:100%;
}
#div_log_output{
	float:left;
	width:100%;
}
#textarea_log_output{
	width:100%;
	height:300px;
}
.button_filter, .button_controller{
	width:150px;
	height:50px;
}
#div_log_view{
	width:100%;
	float:left;
	background-color: #D1EAF7
	overflow:auto;
}
.div_center{
	text-align:center;
}
.div_italic{
	font-style:italic;
}
#div_button{
	margin:10px;
}
.hide{display:none;}
h3{

}
li{
	border-radius:5px;
	width:50%;
	background-color: #f6ffbe;
}
.input_name{
	background:transparent;
	border:0px;
	height:34px;
}
</style></head>



<body>
<div id="div_page">
<div>
	<div class="div_center"><h3 id="header_title">文本处理</h3><h5 id="header_version">v1.0 by KS</h5></div>
	<h5>对一些文本进行处理</h5>
	
</div>
<div>
	<textarea class="form-control" id="textarea_log_input"></textarea>	
</div>

<br>
<div id="div_button" class="div_center">
	<div>
	<button class="button_controller btn btn-success" id="button_log_analyze">移除多余换行</button>
	<button class="button_controller btn btn-success" id="button2">清除行首序号</button>	
	<button class="button_controller btn btn-warning" id="button_log_clear">清除输入</button>	
<br/>
	<button class="button_controller btn btn-success" id="button3">1-拆分SQL</button>
	<button class="button_controller btn btn-success" id="button4">2</button>
	<button class="button_controller btn btn-success" id="button5">3</button>

	</div>

</div>

<div class="div_center">
<!-- <a href="http://www.goddessfantasy.net/bbs/index.php?action=post;board=1588.0" target="_blank">贴到KS的果园版</a> -->
</div>

</div>

 
<script type="text/javascript">

(function($, w, d){
	
	$(d).ready(function(){
		$("#div_log").hide();
		$("#button_palette").hide();
		$("#defaultMode").hide();
		
	});
	
	$("#button_log_clear").click(function(){
		$("#textarea_log_input").val("");
		$("html,body").animate({scrollTop: 1}, 0);
	});


	$("#button_log_analyze").click(function (e) {
		if($("#textarea_log_input").val() != ""){
			post('api-dev.php?c=remove&a=space', {input :$("#textarea_log_input").val()}); 
		}		
	});

	$("#button2").click(function (e) {
		if($("#textarea_log_input").val() != ""){
			post('api-dev.php?c=remove&a=lineno', {input :$("#textarea_log_input").val()}); 
		}		
	});

	$("#button3").click(function (e) {
		if($("#textarea_log_input").val() != ""){
			post('api-dev.php?c=api&a=prosess1', {input :$("#textarea_log_input").val()}); 
		}		
	});

	$("#button4").click(function (e) {
		if($("#textarea_log_input").val() != ""){
			post('api-dev.php?c=api&a=prosess2', {input :$("#textarea_log_input").val()}); 
		}		
	});

	$("#button5").click(function (e) {
		if($("#textarea_log_input").val() != ""){
			post('api-dev.php?c=api&a=prosess3', {input :$("#textarea_log_input").val()}); 
		}		
	});


}(jQuery, window, document));

//调用方法 如        
//post('pages/statisticsJsp/excel.action', {html :prnhtml,cm1:'sdsddsd',cm2:'haha'});  

function post(URL, PARAMS) {        
    var temp = document.createElement("form");        
    temp.action = URL;        
    temp.method = "post";        
    temp.style.display = "none";        
    for (var x in PARAMS) {        
        var opt = document.createElement("textarea");        
        opt.name = x;        
        opt.value = PARAMS[x];        
        // alert(opt.name)        
        temp.appendChild(opt);        
    }        
    document.body.appendChild(temp);        
    temp.submit();        
    return temp;        
}

</script>

</body></html>
