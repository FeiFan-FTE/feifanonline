<?php

/**
 * [函数名称：FUN_IP]
 * @return [type] [返回一个IP值]
 */
function UserIP(){
	global $funip;  
    if (getenv("HTTP_CLIENT_IP"))  
        $funip = getenv("HTTP_CLIENT_IP");  
    else if(getenv("HTTP_X_FORWARDED_FOR"))  
        $funip = getenv("HTTP_X_FORWARDED_FOR");  
    else if(getenv("REMOTE_ADDR"))  
        $funip = getenv("REMOTE_ADDR");  
    else $funip = "Unknow";  
    //本地调试
    if($funip=="::1"){
      return "127.0.0.1";  
    }
    return $funip;  
}

function DateTime(){
	 return date('Y-m-d H:i:s');
}

function FUN_IS_LOGIN(){
   if (!isset($_COOKIE["useremail"])) {
        echo "<script language=JavaScript>";
        echo "self.location='/'";
        echo "</script>";
   }
}
