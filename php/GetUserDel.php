<?php
  include "conn.php";
  include "function.php";

	$valid   = true;
	$message = '';

	if (isset($_GET['DelID']) && is_numeric($_GET['DelID'])) {
		$DelID = intval($_GET['DelID']);
       
       		   if (!isset($_COOKIE["useremail"])) {
					$valid   = false;
				    $message = '用户未登陆,删除失败';
			   }else{
					$result = mysqli_query($conn,"SELECT * From user WHERE  id=".$DelID);  //验证是否存在
				    $rows = mysqli_num_rows($result);	
					if($rows > 0 ){
						mysqli_query($conn,"DELETE FROM user WHERE id=".$DelID);
				        $valid   = true;
					    $message = '数据删除成功';
					}else{
						$valid   = false;
					    $message = '数据不存在，可能已经被删除';
					}
                }

	}else{
		$valid   = false;
		$message = 'ID不能为空且必须为数字';
	}



echo json_encode(
    $valid ? array('valid' => $valid, 'message' => $message) : array('valid' => $valid, 'message' => $message),JSON_UNESCAPED_UNICODE
);