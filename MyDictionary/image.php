<?php  
	require "../CommonPHP/Sharedfx.php";
	//$_GET = array("ChineseWordId"=>'79211');
	$ChineseWordId = intval($_GET['ChineseWordId']);
   	$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
	$myconn->set_charset("utf8");
	$sql= "SELECT `Image`,`ImageMime`,`ImageTime` FROM  `CondenseTable` WHERE`ChineseWordId` = '$ChineseWordId' "; 
	
	if($result = $myconn->query($sql)){
	
		$row = $result->fetch_array(MYSQLI_ASSOC);
				$Image = $row["Image"];
				$ImageMime = $row["ImageMime"];
				$ImageTime = $row["ImageTime"];
				$result->close();	
				$send_304 = false;

				if (preg_match("/apache/i", PHP_SAPI)) {
					// if our web server is apache get check HTTP If-Modified-Since headerand do not send image if there is a cached version
					$ar = apache_request_headers();
					if (isset($ar['If-Modified-Since']) && // If-Modified-Since should exists
					($ar['If-Modified-Since'] != '') && // not empty
					(strtotime($ar['If-Modified-Since']) >= $ImageTime)) // and grater than image_time
					$send_304 = true;                                     
				 }

				 if ($send_304) {
					// Sending 304 response to browser "Browser, your cached version of image is OK  we're not sending anything new to you"
					header('Last-Modified: '.gmdate('D, d M Y H:i:s', $ImageTime).' GMT', true, 304);
					exit(); 
				  }
				// outputing Last-Modified header
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', $ImageTime).' GMT',true, 200);
				// Set expiration time +1 year We do not have any photo re-uploading so, browser may cache this photo for quite a long time
				header('Expires: '.gmdate('D, d M Y H:i:s',  $ImageTime + 86400*365).' GMT',true, 200);
				// outputing HTTP headers
				header('Content-Length: '.strlen($Image));
				header("Content-type: {$ImageMime}");
				echo $Image ;
		
	}
					
	$myconn->close();
?>
