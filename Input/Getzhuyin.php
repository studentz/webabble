<?php
	session_start();
	require "../CommonPHP/InputClass.php";
	require "../CommonPHP/Sharedfx.php";
    
    $ChineseTable = "ChineseDictionary";
	$PinyinToZhunyinTable = "PinyinToZhuyin";
	$ChineseWordId = $_GET["value"]; // $ChineseWordId = "400";
	$mysession = new inputsession();
	$mysession->set_ChineseWordId($ChineseWordId);
	$myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
	$myconn->set_charset("utf8");
	$zhuyin3 ="";
	$sql = "SELECT `MandarinPinyin` FROM  $ChineseTable WHERE  `ChiWordId` = $ChineseWordId";
	if($result = $myconn->query($sql)){
		
				$row = $result->fetch_array(MYSQL_ASSOC);
				$zhuyin = strtolower($row["MandarinPinyin"]);
				$eachWord = explode(" ",$zhuyin);
				foreach($eachWord as $dummykey => $word){

					$sql2 = "SELECT `Zhuyin` FROM  `PinyinToZhuyin` WHERE  `Pinyin` = '$word' ";
					if($result2 = $myconn->query($sql2)){
						
						 $row2 = $result2->fetch_array(MYSQL_ASSOC);
						 $zhuyin2 = strtolower($row2["Zhuyin"]);
						 $zhuyin3 = $zhuyin3.$zhuyin2."\t";
					}

					else
					print("no match");
				}
				
				$zhuyin3= (rtrim($zhuyin3));
				$result2->close();
				echo($zhuyin3);
	}
	
	$result->close();
	$myconn->close();

?>