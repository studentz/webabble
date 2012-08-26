 <?php 
	//$_GET = array("value"=>'.*');
	require "../CommonPHP/Sharedfx.php";
   	$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
	$myconn->set_charset("utf8");
	$searchWord = $_GET["value"];
	
	
	$sql= "SELECT `ChineseWordId`,`EnglishDefinitions`,`ChineseTraditional`FROM  `CondenseTable` WHERE `EnglishDefinitions` REGEXP '$searchWord'";
	
	if($result = $myconn->query($sql)){
		if 	( $result->num_rows > 0 ){ 
			echo "<option value = \"NoValid\">SELECT A WORD</option>\n";
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$ChineseWordId = $row["ChineseWordId"];
				$WordDefinitions = $row["EnglishDefinitions"];
				$WordChineseTrad = $row["ChineseTraditional"];
				if ($searchWord == ".*"){
					echo "<option value = \"".$ChineseWordId."\">".$WordDefinitions."</option>\n";	
				}
				else{
					$WordChineseTrad = $row["ChineseTraditional"];
					echo "<option value = \"".$ChineseWordId."\">".$WordChineseTrad. "   ".$WordDefinitions."</option>";
				}	
			}
			$result->close();			
		}
		else 
		echo ' <script> alert("Sorry your dictionay is empty "); </script>';
		
	}
$myconn->close();

 ?>   
 
