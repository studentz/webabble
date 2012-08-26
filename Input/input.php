<?php

require "../CommonPHP/InputClass.php";
require "../CommonPHP/Sharedfx.php";
session_start();
$mysession = new inputsession();
$removewaitingdiv = 'var waitingdiv = window.parent.document.getElementById("waitingdiv"); waitingdiv.parentNode.removeChild(waitingdiv);';
if (array_key_exists('SubmitImageFile', $_POST)){

  if($_FILES["imageFileClient"]["name"] != "" && $_FILES["imageFileClient"]["error"] == 0 ){
    $regexp="/gif|png|jpg|jpeg|swf|tiff|svg/";
    $ImageMime= $_FILES['imageFileClient']['type'];
    
    if (preg_match ($regexp, strtolower($ImageMime) ) ){
      $mysession->set_ImageMime($ImageMime);
      
      if ( $path = upload_file('imageFileClient','upimages',7000000)) {
	
	$scaledimage = scaleImageFileToBlob($path);
	$fp = fopen($path, 'w');
	fwrite($fp, $scaledimage);
	fclose($fp);
	$mysession->set_PathToImagesDir($path);
	
	echo '<script language="JavaScript" type="text/javascript">'."\n";
	echo 'var imgdiv = window.parent.document.getElementById("img-div");';
	echo $removewaitingdiv;
	echo 'image = window.parent.document.createElement("img");';
	echo 'image.src = "'.$path.'";';
	echo 'image.height = '.$_SESSION["Height"].';';
	echo 'image.width = '.$_SESSION["Width"].' ;';
	echo 'image.style.cssText="margin-bottom:10px;margin-top:10px;";';
	echo 'image.id = "image";';
	echo 'imgdiv.style.cssText= "border-style:solid";';
	echo 'imgdiv.appendChild(image);';
	echo 'var x =  window.parent.document.getElementById("appdiv").clientHeight;';
	echo 'window.parent.document.getElementById("sidebar").style.height = x+"px";';
	echo '</script>';
	exit;
	
      }
      
      else{
	echo '<script> alert ("It is kind of big your picture do not you think?");';
	echo $removewaitingdiv;
	echo '</script>';
      }
    }

    else{
      echo '<script> alert ("Try to use a decent format in your picture like png.");';
      echo $removewaitingdiv;
      echo '</script>';
    }
  }
  
  else
    echo "<script> alert ('Please upload an image');$removewaitingdiv </script>";
  
  exit;
}

elseif(array_key_exists('voicerec', $_POST)){
	// Check validity of file upload 
	if (!is_uploaded_file($_FILES['voicefile']['tmp_name'])) exit; 
	// Move the file to the voice directory 
	mkdir('voice', 0700); 
	// Generate a filename using the time value
	$i = 0; 
	do { if ($i > 0) sleep(1); 
	$filename = 'voice/' . time() . '.wav'; $i++; } 
	while ($i < 3 && file_exists($filename)); 
	// try 3 times for unique // filename 
	if (file_exists($filename) || !move_uploaded_file($_FILES['voicefile']['tmp_name'], 
	$filename)) exit; 
	// Return the text 'success' to the JavaScript 
	print "success"; 
}

elseif (array_key_exists('SubmitAudioFile', $_POST)){

  if($_FILES["audioFileClient"]["name"] != "" && $_FILES["audioFileClient"]["error"] == 0 ){
    
    $regexp= "/mpeg|x-aiff|x-pn-realaudio|x-wav|x-aiff|mid|x-ms-wma|x-vorbis+ogg|ogg|vnd.rn-realaudio|mp3/";
    $audiomime = $_FILES['audioFileClient']['type'];
    if (preg_match ($regexp, strtolower($_FILES['audioFileClient']['type']))){
      
      $mysession->set_AudioMime($audiomime);
      
      if ($path = upload_file('audioFileClient', 'upaudio', 7000000)){
	$mysession->set_PathToAudioDir($path);
	
	echo '<script type="text/javascript" src="../CommonJS/swfobject.js"></script>';
	echo '<script language="javascript" type="text/javascript">'."\n";
	echo 'var audiodiv = window.parent.document.getElementById("audio-div");';
	echo $removewaitingdiv;
	echo 'audiodiv.style.cssText= "border-style: solid;padding-top: 10px;padding-bottom: 5px;height: 40px;";';
	echo 'var id = "audioplayer-div";';
	echo 'var par = {menu:"false",flashvars:"src='.$path.'"};';
	echo 'var att = {data:"http://babble/Images/emffplayer.swf", width:"140", height:"30",bgcolor:"#000000",id:"audioplayer", name:"audioplayer"};';
	echo 'swfobject.createSWF(att,par,id);';
	echo 'var x =  window.parent.document.getElementById("appdiv").clientHeight;';
	echo 'window.parent.document.getElementById("sidebar").style.height = x+"px";';
	echo '</script>';
	
	exit;
      }
      else{
	echo '<script> alert ("It is kind of big your audio file do not you think?");';
	echo $removewaitingdiv;
	echo '</script>';
      }
      
    }
    
    else{
      echo '<script> alert ("Try to use a decent format in your audio like ogg.");';
      echo $removewaitingdiv;
      echo '</script>';
    }
  }

  else
    
    echo "<script> alert ('Please upload an audio file');$removewaitingdiv </script>";
  
}



elseif (array_key_exists('SubmitForm', $_POST))
{
  $PathToImage = $mysession->get_PathToImagesDir();
  $PathToAudio = $mysession->get_PathToAudioDir();
  $ChiWordId = $mysession->get_ChineseWordId();
  $EnWord= $mysession->get_EnglishWord();
  $Zhuyin= trim($_POST["bupomorfoup"]);
  $ChineseWord = trim($_POST["chicharup"]);
  
  if ($PathToImage !="" && $PathToAudio != "" && $ChiWordId != "" && $ChineseWord != "" && $Zhuyin !="" && $EnWord != ""){
    
    $ImageTable = "ImageBlobs";
    $ImageMime= $mysession->get_ImageMime();
    $pattern = "/^\.{2}\/\w{8}\/\d{1,3}/";
    $ImageTitle=  preg_replace($pattern,"",$PathToImage);
    $ImageData =file_get_contents($PathToImage);
    
    $AudioTable = "AudioBlobs";
    $AudioMime = $mysession->get_AudioMime();
    $pattern = "/^\.{2}\/\w{7}\/\d{1,3}/";
    $AudioTitle=  preg_replace($pattern,"",$PathToAudio);
    $AudioData=file_get_contents($PathToAudio);

    $EnglishTable = "EnglishChineseDictionary";
    $BupomorfoTable = "Bupomorfo";
    	
    $myconn = new extmysqli(dbServer, dbUser, dbPassword, dbName);
    $myconn->set_charset("utf8");

    $ImageData = $myconn->real_escape_string($ImageData);
    $sql= "INSERT INTO {$ImageTable} SET ChiWordId='$ChiWordId',ImageBlobMime='$ImageMime', ImageBlobTitle='$ImageTitle',
        ImageBlobData='$ImageData'";
    $myconn->query($sql);
    unlink($PathToImage);

    $AudioData = $myconn->real_escape_string($AudioData);
    $sql= "INSERT INTO {$AudioTable} SET ChiWordId='$ChiWordId', AudioBlobTitle='$AudioTitle',
        AudioBlobData='$AudioData',AudioBlobMime='$AudioMime'";
    $myconn->query($sql);
    unlink($PathToAudio);

    $Zhuyin = sql_safe($Zhuyin, $myconn);
    $sql = "INSERT INTO {$BupomorfoTable} SET ChiWordId='$ChiWordId', Zhuyin='$Zhuyin'";
    $myconn->query($sql);
    
    $sql="INSERT INTO {$EnglishTable} SET EngWord= '$EnWord',ChiWordId='$ChiWordId'";
    $myconn->query($sql);
    
    $myconn->close();

    echo "<script> parent.location.href = 'http://babble/Input/'</script>";
	

    //ob_end_clean(); // Delete the buffer.
    
    exit(); // Quit the script.
  }
  
  echo '<script> alert ("Please fill up all the fields");</script>';
       
  }

?>
