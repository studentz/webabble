<?php

/**
 * Description of PHPClass
 *
 * @author pablo
 */

class inputsession {
    //put your code here
    public $PathToImagesDir;
    public $ImageMime;
    public $PathToAudioDir;
    public $AudioMime;
    public $EnglishWord;
    public $ChineseWord;
    public $ChineseWordId;
    public $ChineseCharacterLength;
    public $Zhuyin;


    function set_PathToImagesDir($PathToImagesDir){
       $_SESSION["PathToImagesDir"]= $PathToImagesDir;
       }

    function get_PathToImagesDir(){
       return $this->PathToImagesDir= $_SESSION["PathToImagesDir"];
    }

    function set_ImageMime($ImageMime){
        $_SESSION["ImageMime"]=$ImageMime;
    }

    function get_ImageMime(){
       return  $this->ImageMime = $_SESSION["ImageMime"];
    }

    function set_PathToAudioDir($PathToAudioDir){
        $_SESSION["PathToAudioDir"]=$PathToAudioDir;
    }

    function get_PathToAudioDir(){
        return $this->PathToAudioDir = $_SESSION["PathToAudioDir"];
    }

    function set_AudioMime($AudioMime){
        $_SESSION["AudioMime"]=$AudioMime;
    }
	
    function get_AudioMime(){
         return $this->AudioMime= $_SESSION["AudioMime"];
     }

    function set_EnglishWord($EnglishWord) {
        $_SESSION["EnglishWord"]=$EnglishWord;
    }

    function get_EnglishWord(){
       return $this->EnglishWord= $_SESSION["EnglishWord"];
    }

    function set_ChineseWord($ChineseWord){
        $_SESSION["ChineseWord"]= $ChineseWord;
    }

    function get_ChineseWord(){
        return $this->ChineseWord=$_SESSION["ChineseWord"];
    }

    function set_ChineseWordId($ChineseWordId){
        $_SESSION["ChineseWordId"]= $ChineseWordId;
    }

    function get_ChineseWordId(){
        return $this->ChineseWordId= $_SESSION["ChineseWordId"];
    }

    function set_ChineseCharacterLength($ChineseCharacterLength){
        $_SESSION["ChineseCharacterLength"]=$ChineseCharacterLength;
    }

    function get_ChineseCharacterLength(){
        return $this->ChineseCharacterLength = $_SESSION["ChineseCharacterLength"];
    }

    function set_Zhuyin($Zhuyin){
        $_SESSION["Zhuyin"]=$Zhuyin;
    }

    function get_Zhuyin(){
        return $this->Zhuyin = $_SESSION["Zhuyin"];
    }
    
    function set_IdUser($IdUser){
        $_SESSION["IdUser"]=$IdUser;
    }

    function get_IdUser(){
        return $this->IdUser = $_SESSION["IdUser"];
    }
    
}



?>