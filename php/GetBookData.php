<?php
  include "conn.php";
  include "function.php";

  $valid   = true;
  $message = '';
   

	   	        $sql = "SELECT * FROM book  ORDER BY booktime DESC";

	  			$result = $conn->query($sql);
					 
					if ($result->num_rows > 0) {
					    // 输出数据
					    while($row = $result->fetch_assoc()) {
					        $books[]=$row;
					    }
					} else {
						$valid=flase;
					    $books[]='没有信息';
					}
			
   
        echo json_encode(
		    $valid ? array('valid' => $valid, 'books' => $books) : array('valid' => $valid, 'books' => $books),JSON_UNESCAPED_UNICODE
		);

		$conn->close();
?>