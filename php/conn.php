<?php 
/**
 * @Author: yingziyu
 * @Date:   2017-09-15 10:29:43
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-05-02 18:50:35
 */
//header('X-Frame-Options: deny');
// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:GET');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');  
//session_start();
//header('X-Frame-Options: deny');
header("Content-type: text/html; charset=utf-8"); 
date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai' 亚洲/上海

//强制报错
ini_set("display_errors","On");   
error_reporting(E_ALL);  

/**
 * 限制5.5.7以下版本运行
 */
if (version_compare("5.5.7", PHP_VERSION, ">")) {
     die("<h1>当前运行环境：PHP - ".PHP_VERSION." 不符合系统要求</h1>");
}

//全局当前根目录常量域名
// if ($_SERVER["HTTP_HOST"]  == "localhost:8080") {
// 	 define("__HTTP_HOST__", "http://localhost:8080/hzbiz.net");
// }else{
//      define("__HTTP_HOST__", "http://".$_SERVER["HTTP_HOST"]."");
// }



// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //


    define('DB_HOST', 'qdm172049670.my3w.com');    //服务器地址(数据库地址)

    define('DB_NAME', 'qdm172049670_db');     //数据库名
    
    define('DB_USER', 'qdm172049670');     /**数据库账号*/
   
    define('DB_PASSWORD', 'feifan123128');   /** MySQL数据库密码*/


// 创建连接

@$conn = new mysqli(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME);
@mysqli_query($conn,"set character set 'utf8'");//读库 
@mysqli_query($conn,"set names 'utf8'");//写库 
// 检测连接
if ($conn->connect_error) {
    //die("数据库连接失败: " . $conn->connect_error);
    die("数据库连接失败");
}else{
    // echo "数据库连接成功";
}



?>