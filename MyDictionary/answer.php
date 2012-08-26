 <?php 
	//$_GET = array("ChineseWordIdQ"=>'79211');
	require "../CommonPHP/Sharedfx.php";
   	$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
	$myconn->set_charset("utf8");
	$ChineseWordId = intval($_GET['ChineseWordIdQ']);
  
	$sql= "SELECT `ChineseTraditional`,`Zhuyin` FROM  `CondenseTable` WHERE`ChineseWordId` = '$ChineseWordId' "; 
	
	
	if($result = $myconn->query($sql)){

			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$ChineseTraditional = $row["ChineseTraditional"];
				$Zhuyin = $row["Zhuyin"];
				$val = array("ChineseTraditional" => $ChineseTraditional,"Zhuyin" => $Zhuyin);
				$output = json_encode($val);
				echo $output."\n";
			
				}	
				$result->close();
	}
	else {
		echo ' <script> alert("Sorry your dictionay is empty "); </script>';
	}
	$myconn->close();
 ?>   
 
