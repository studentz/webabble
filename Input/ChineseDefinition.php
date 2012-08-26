<?php
	session_start();
	require "../CommonPHP/InputClass.php";
	require "../CommonPHP/Sharedfx.php";
	$ChineseTable = "ChineseDictionary";
	$searchWord = $_GET["value"];  // "orally's";  //
	$languagequery = $_GET["query"];  // "queryen";  //
	$mysession = new inputsession();
	$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
	$myconn->set_charset("utf8");
	$searchWord = $myconn->real_escape_string ($searchWord);
	$pattern = "([/ ]$searchWord( |/|-))";
	
	
	if ($languagequery == "queryen"){
		$sql = "SELECT `ChiWordId`,`ChineseTrad`, `ChineseSimp`,`EnDefinitions` FROM  $ChineseTable WHERE `EnDefinitions`  REGEXP'($pattern)' ";
        $mysession->set_EnglishWord($searchWord);        
    }
	else{
		$sql= "SELECT `ChiWordId`,`ChineseTrad`, `ChineseSimp`,`EnDefinitions` FROM  $ChineseTable WHERE `ChineseTrad`= '$pattern'";

    }

		if($result = $myconn->query($sql)){
			
				if 	( $result->num_rows > 0 ){ 
						echo "<option value = \"\">READY</option>";
						while ($row = $result->fetch_array(MYSQLI_ASSOC)){	 
							
								$WordIdDic = $row["ChiWordId"];
								$WordDefinitions = $row["EnDefinitions"];
								$WordChineseTrad = $row["ChineseTrad"];
								$WordChineseSimp = $row["ChineseSimp"];
								$SplitDefinitions = preg_split("[/]", $WordDefinitions,-1, PREG_SPLIT_NO_EMPTY );
								$matches = preg_grep( "($searchWord)", $SplitDefinitions );
								
								foreach($matches as $key => $value) {
									 $SentenceDefinition = "".$WordChineseTrad." ".$value."";
									 echo "<option value = \"".$WordIdDic."\">".$SentenceDefinition."</option>";
								}	
						}
					$result->close();
				}
				
		else 
		echo ' <script> alert("Sorry no matches for '.$question.'"); </script>';
		}
			
		$myconn->close();

?>





