<?php
DEFINE ("dbUser", "babble");
DEFINE ("dbPassword", "babble");
DEFINE ("dbServer", "localhost");
DEFINE ("dbName", "myFiles");

class extmysqli extends mysqli {



    public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
}
function str_split_utf8($str)
{
    // place each character of the string into and array
    $split=1;
    $array = array();
    for ( $i=0; $i < strlen( $str ); )
	{
        $value = ord($str[$i]);
		//print("$value \n");
        if($value > 127)
		{
            if($value >= 192 && $value <= 223)
                $split=2;
            elseif($value >= 224 && $value <= 239)
                $split=3;
            elseif($value >= 240 && $value <= 247)
                $split=4;
       	}
		else
		{
            $split=1;
        }
            $key = NULL;
        for ( $j = 0; $j < $split; $j++, $i++ )
	    {
            $key .= $str[$i];
        }
        array_push( $array, $key );
	}
    return $array;
}

function sql_safe($s,$myconn)
{
    if (get_magic_quotes_gpc())
        $s = stripslashes($s);

    return $myconn->real_escape_string($s);

}
function FindAcentPosition($BupoString)
	{
		$pattern = "(.[ˋ|ˇ|ˊ|˙])";
		mb_regex_encoding("UTF-8");
		mb_ereg_search_init($BupoString,$pattern);
		if (mb_ereg_search($pattern))
		 {
				//echo "Yes there is an acent in $BupoString\n";
				mb_internal_encoding("UTF-8");
				mb_detect_encoding($BupoString, "UTF-8");
				//$BupoLenght = mb_strlen($BupoString);
				//print("lenght str = $BupoLenght\n");

				mb_regex_encoding("UTF-8");
				mb_ereg_search_init($BupoString,$pattern);
				$matches=mb_ereg_search();
				$matches = mb_ereg_search_getregs();
				$FirstMatch= $matches[0];
				//print("$FirstMatch\n");
				$PositionMatch = mb_strpos($BupoString,$FirstMatch,0,"UTF-8");
				//print("Postion is at $PositionMatch\n");

				$IndivBupo = str_split_utf8 ($BupoString);
				$IndivBupo[$PositionMatch]= $FirstMatch;
				unset ($IndivBupo[$PositionMatch+1]);
				return $IndivBupo;

		 }

		 else

			//echo"No acent in $BupoString\n";
			$IndivBupo = str_split_utf8 ($BupoString);
			return $IndivBupo;

	}

 function upload_file($field , $dirPath , $maxSize){

foreach ($_FILES[$field] as $key => $val){
        $$key = $val;
    }

    if ((!is_uploaded_file($tmp_name)) || ($error != 0) || ($size == 0) || ($size > $maxSize)){

        return false;    // file failed basic validation checks
    }
    else {
        do $path ="..".DIRECTORY_SEPARATOR. $dirPath . DIRECTORY_SEPARATOR .rand(1, 999).strtolower(basename($name));
        while (file_exists($path));        
        if (move_uploaded_file($tmp_name, $path)) {
            return $path;
        }
        else
        return false;
    }
}

function scaleImageFileToBlob($file)
{
    $source_pic = $file;
    $max_width = 150;
    $max_height = 150;

    list($width, $height, $image_type) = getimagesize($file);

    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }

    $x_ratio = $max_width / $width;
    $y_ratio = $max_height / $height;

    if( ($width <= $max_width) && ($height <= $max_height) )
	{
        $tn_width = $width;
        $tn_height = $height;
    }
	elseif (($x_ratio * $height) < $max_height)
	{
        $tn_height = ceil($x_ratio * $height);
        $tn_width = $max_width;
    }
	else
	{
        $tn_width = ceil($y_ratio * $width);
        $tn_height = $max_height;
    }

    $tmp = imagecreatetruecolor($tn_width,$tn_height);


    $_SESSION["Width"]= $tn_width;
    $_SESSION["Height"]= $tn_height;

    /* Check if this image is PNG or GIF to preserve its transparency */
    if(($image_type == 1) OR ($image_type==3))
    {
        imagealphablending($tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
    }
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

    /*
     * imageXXX() has only two options, save as a file, or send to the browser.
     * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
     * So I start the output buffering, use imageXXX() to output the data stream to the browser,
     * get the contents of the stream, and use clean to silently discard the buffered contents.
     */
    ob_start();

    switch ($image_type)
    {
        case 1: imagegif($tmp); break;
        case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
        case 3: imagepng($tmp, NULL, 0); break; // no compression
        default: echo ''; break;
    }

    $final_image = ob_get_contents();

    ob_end_clean();

    return $final_image;
}
?>
