<?php
  include "conn.php";
  include "function.php";

	$valid   = true;
	$message = '';

if (isset($_POST['GetUser'])) {
	

    if ($_POST['GetUser']=="Add") {
  		 //$message = "Add接口方式";
	  	 //$valid   = true;
  	}else if ($_POST['GetUser']=="Edit") {
  		 $message = "Edit接口方式";
	  	 $valid   = true;
  	}else if ($_POST['GetUser']=="Del") {
  		 $message = "Del接口方式";
	  	 $valid   = true;
  	}else{
		 $message = "未指定Api接口方式[Add/Edit/Del]";
	  	 $valid   = false;
    }

}else{
	$valid   = false;
	$message = 'GetUser验证失败';
}

echo json_encode(
    $valid ? array('valid' => $valid, 'message' => $message) : array('valid' => $valid, 'message' => $message),JSON_UNESCAPED_UNICODE
);