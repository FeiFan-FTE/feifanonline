<?php
  include "conn.php";
  include "function.php";

  $valid   = true;
  $message = '';

    if (isset($_POST['action']) && $_POST['action']=='add') {
      
                  

       if (isset($_POST['author']) && $_POST['author']!="") {
           $author = htmlentities($_POST['author'], ENT_QUOTES, 'UTF-8');
           if (strlen($author)>16) {
               $message = "用户名不能超过16个字符";
               $valid   = false;
           }
       }else{
       		$message = "发布人不能为空";
	        $valid   = false;
       }



       if (isset($_POST['title']) && $_POST['title']!="") {
            $title =  htmlentities($_POST['title'], ENT_QUOTES, 'UTF-8');
       }else{
            $title =  htmlentities($_POST['author'], ENT_QUOTES, 'UTF-8');
       }
      

       if (isset($_POST['email']) && $_POST['email']!="") {
           $email =  htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
           $regexp = "/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	         if (!preg_match($regexp,$email)){
		          $message = "邮箱不合法";
		          $valid   = false;
	          }
        }else{
		        $message = "邮箱不合法";
		        $valid   = false;
        }
 

       
       if (isset($_POST['content']) && strlen($_POST['content'])!=0) {
              $content = $_POST['content'];
       }else{
              $message = "留言内容不能为空";
              $valid   = false;
       }
      

      
      $bookTime = DateTime();
      $ip = UserIP();

       if (isset($_POST['userface']) && $_POST['userface']!="") {
            $userface = htmlentities($_POST['userface'], ENT_QUOTES, 'UTF-8');
       }else{
            $userface = 'http://www.hzbiz.net/tianyan/ajax/images/img1.jpg';
       }
      

      if ($valid) {
      	   $sql="INSERT INTO book (title,content,author,email,bookTime,ip,adminContent,userface) VALUES ('".$title."','".$content." ','".$author."','".$email."','".$bookTime."','".$ip."','0','".$userface."')";

             if(mysqli_query($conn,$sql)){
                $message =  '留言添加成功!';
                $valid   = true;
              }else{
                $message =  "留言添加失败!".mysqli_error($conn);
                $valid   = false;
              }

      }else{
            $message = $message;
	        $valid   = false;	
      }


    }else{
    	  $valid   = false;
        $message = '接口不存在';
    }

	




	echo json_encode(
	    $valid ? array('valid' => $valid, 'message' => $message) : array('valid' => $valid, 'message' => $message),JSON_UNESCAPED_UNICODE
	);
?>