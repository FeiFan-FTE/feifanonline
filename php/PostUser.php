<?php
  include "conn.php";
  include "function.php";

  $valid   = true;
  $message = '';

if (isset($_POST['PostUser'])) {
  

    if ($_POST['PostUser']=="Add") {
       //$message = "Add接口方式";
       //$valid   = true;

        if (isset($_POST['username']) && $_POST['username']!="") {
             $username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
      }else{
        $message = "用户名不能为空";
        $valid   = false;
      }

    if (isset($_POST['userface']) && $_POST['userface']!="") {
            $userface = htmlentities($_POST['userface'], ENT_QUOTES, 'UTF-8');
      }else{
        $message = "请选择您的头像";
        $valid   = false;
      }

        if (isset($_POST['useremail']) && $_POST['useremail']!="") {
           $useremail = htmlentities($_POST['useremail'], ENT_QUOTES, 'UTF-8');
           $regexp = "/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
         if (!preg_match($regexp,$useremail)){
        $message = "邮箱不合法";
          $valid   = false;
              }
      }else{
      $message = "邮箱不合法";
        $valid   = false;
      }

        
      if (isset($_POST['password']) && $_POST['password']!="") {
          $password = $_POST['password'];
          $password = sha1($password);
      }else{
        $message = "初始密码不能为空";
        $valid   = false;

      }


      if (isset($_POST['setpassword']) && $_POST['setpassword']!="") {
          $setpassword = $_POST['setpassword'];
          $setpassword = sha1($setpassword);

            if ($password != $setpassword) {
              $message = "确认密码和初始密码不符";
            $valid   = false;
            }

      }else{
        $message = "确认密码不能为空";
        $valid   = false;
      }


  

      if (isset($_POST['studentname']) && $_POST['studentname'] != "") {
            $studentname = htmlentities($_POST['studentname'], ENT_QUOTES, 'UTF-8');
      }else{
          $message = "请确认您的身份";
        $valid   = false;
      }


        $dateTime = DateTime();
        $uiserIp = UserIP();


    if ($valid) {

        $result = mysqli_query($conn,"SELECT * From user WHERE useremail =  '$useremail' OR  username = '$username' ");  //验证是否存在
          $rows = mysqli_num_rows($result); 
        if($rows == 0 ){ 

            $sql = "INSERT INTO user (username,password,userface,useremail,studentname,regdatetime,ip,method) VALUES ('$username','$password','$userface','$useremail','$studentname','$dateTime','$uiserIp','POST')";

              if(mysqli_query($conn,$sql)){
                $message =  '用户添加成功!';
                $valid   = true;
              }else{
                $message =  "用户添加失败!".mysqli_error($conn);
                $valid   = false;
              }
          }else{
                $message =  "用户名或邮箱可能已经存在！请重新输入";
              $valid   = false;
          }

      }else{
        $message =  $message;
        $valid   = false;
      }

    }else if ($_POST['PostUser']=="Edit") {
      
       if (isset($_POST['EditSaveID']) && !empty($_POST['EditSaveID'])) {
            $EditSaveID =intval($_POST['EditSaveID']); 
            //$EditSaveID =$_POST['EditSaveID']; 
            //$message = $EditSaveID;
       }else{
          $message = "EditSaveID不能为空";
          $valid   = false;
       }
          
      if (isset($_POST['userface']) && !empty($_POST['userface'])) {
         $userface =  htmlentities($_POST['userface'], ENT_QUOTES, 'UTF-8');
      }else{
          $message = "头像不能为空";
          $valid   = false;
      }


      if ($valid) {
        
        $sqlr = "SELECT * FROM user WHERE id=".$EditSaveID;
        $result = $conn->query($sqlr);
         
        if ($result->num_rows > 0)  {
          
         if (isset($_POST['password']) && $_POST['password']!="" && isset($_POST['setpassword']) && $_POST['setpassword']!="") {
            $password = sha1($_POST['password']);
            $setpassword = sha1($_POST['setpassword']);
            if ($password != $setpassword) {
               $valid   = false;
               $sql="初始密码和确认密码不等";
            }else{
              $sql="UPDATE user SET password='".$password."',userface='".$userface."' WHERE id=".$EditSaveID;
            }
         }else{
             $sql="UPDATE user SET userface='".$userface."' WHERE id=".$EditSaveID;
         }
        

       if (!isset($_COOKIE["useremail"])) {
            $valid   = false;
            $message = '请登陆后操作,删除失败';
         }else{

             if(mysqli_query($conn,$sql)){
                $message =  '用户修改成功!';
                $valid   = true;
              }else{
                $message =  "用户修改失败!".$sql;
                $valid   = false;
              }
   
         }


        }else{
                $message =  "用户不存在，可能已经被删除!";
                $valid   = false;
        }

      }

    }else if ($_POST['PostUser']=="Login") {
      

      if (isset($_POST['useremail']) && $_POST['useremail']!="") {
           $useremail =  htmlentities($_POST['useremail'], ENT_QUOTES, 'UTF-8');
           $regexp = "/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
           if (!preg_match($regexp,$useremail)){
             $message = "邮箱帐号不合法";
             $valid   = false;
            }
      }else{
        $message = "邮箱帐号不合法";
        $valid   = false;
      }

        
    if (isset($_POST['password']) && $_POST['password']!="") {
          $password = $_POST['password'];
          $password = sha1($password);
      }else{
        $message = "帐号密码不能为空";
        $valid   = false;

      }

     if ($valid) {
         $sql = "SELECT * From user WHERE useremail = '$useremail' &&  password='$password'";
         $result = mysqli_query($conn,$sql);  //验证是否存在
         $row = $result->fetch_assoc();
        if(mysqli_num_rows($result) == 1 ){

              $message =  $row['userface'];
              $valid   = true;
                 
                $expire=time()+60*60*24*7;
                $_SESSION['useremail']=$row['useremail'];
                setcookie("useremail",$row['useremail'],$expire,"/");
                setcookie("username", $row['username'],$expire,"/");
                setcookie("userface", $row['userface'],$expire,"/");
                setcookie("userid", $row['id'],$expire,"/");
                
          }else{
              $message =  "帐号或密码不正确";
              $valid   = false;
          }

     }else{
              $message =  "帐号或密码格式不合法";
              $valid   = false;
     }

    }else{
     $message = "未指定Api接口方式[Add/Edit/Login]";
       $valid   = false;
    }

}else{
  $valid   = false;
  $message = 'PostUser验证失败';
}

echo json_encode(
    $valid ? array('valid' => $valid, 'message' => $message) : array('valid' => $valid, 'message' => $message),JSON_UNESCAPED_UNICODE
);