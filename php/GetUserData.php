<?php

  include "conn.php";
  include "function.php";

	$valid   = true;
	$users = '';


    if (isset($_GET['studentname']) && $_GET['studentname'] !="") {
          $studentname =  $_GET['studentname'];


                if ($studentname == "all") {
                	$sql = "SELECT * FROM user ORDER BY regdatetime DESC";
                }else{
                	$sql = "SELECT * FROM user WHERE studentname='".$studentname."' ORDER BY regdatetime DESC";
                }
				
              
				$result = $conn->query($sql);
				 
				if ($result->num_rows > 0) {
				    // 输出数据
				    while($row = $result->fetch_assoc()) {
				        $users[]=$row;
				    }
				} else {
				    $users[]='没有信息';
				}
				$conn->close();



    }else{
		//$valid   = false;
		//$users = 'studentname接口参数必须存在';
         if (isset($_GET['EditID']) && $_GET['EditID']!="") {
          	$EditID =  intval($_GET['EditID']);
	   	     $sql = "SELECT * FROM user WHERE id=".$EditID."  ORDER BY regdatetime DESC";
	  			$result = $conn->query($sql);
					 
					if ($result->num_rows > 0) {
					    // 输出数据
					    while($row = $result->fetch_assoc()) {
					        $users[]=$row;
					    }
					} else {
					    $users[]='没有信息';
					}
					$conn->close();
         }else{
             	$valid   = false;
	            $users = 'ID修改ID不能为空';
         }
	 	 

    }


		echo json_encode(
		    $valid ? array('valid' => $valid, 'users' => $users) : array('valid' => $valid, 'users' => $users),JSON_UNESCAPED_UNICODE
		);
?>