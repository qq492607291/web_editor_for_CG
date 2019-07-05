<?php
$url = "php/";  
// $url = "static_html/";  

if (!empty($url))    
{    
    Header("HTTP/1.1 303 See Other"); //这条语句可以不写  
    Header("Location: $url");  
}    