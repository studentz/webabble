/**
 * @author pablo
 */
function mysearch(){
    var word = rtrim($e("search-text").value);
    if (word != "" && word != null){
        var ajaxsearch = new NativeAjax();
        var element = "selectanswer";
        var subelement = "innerHTML";
        remove("search-subdiv");
        createSelectAnswer("search-div");
        var url =  languageOfSearch(word)
        createwaitingdiv("search-div");
        ajaxsearch.sendRequest(url,element,subelement);
        addEvento(element, "change", selectingword);
            
    }
    else{
         alert("Please Enter a word");
    }
}

function languageOfSearch(word){
        var url;
        var pattern= new RegExp("^[^a-z|A-z|0-9|(]+");
        var resultpattern = pattern.exec(word);
        if (resultpattern == null){
             return url = "ChineseDefinition.php?value="+escape(word)+"&query=queryen&";
        }
        else{
             return  url = "ChineseDefinition.php?value="+escape(word)+"&query=querychi&";
        }

 }
 		
function createSelectAnswer(element){
		
		CreateTag("div",element,"divanswer");
    	CreateTag("select","divanswer","selectanswer");
    	$e("selectanswer").size=1;
   		$e("selectanswer").innerHTML= "<option>Wait..</option>";
    
}
 
function selectingword(){
	
	var selectanswer= document.getElementById("selectanswer");
	var WordId = selectanswer.options[selectanswer.selectedIndex].value;
	var ChineseTradWord = selectanswer.options[selectanswer.selectedIndex].innerHTML;
	var pattern= new RegExp("^[^a-z|A-z|0-9|(]+");
	var resultpattern = pattern.exec(ChineseTradWord);
    remove("divanswer");
    createInputSelected(resultpattern,"search-div");
    setzhuyin(WordId);
}

function createInputSelected(pattern,parent){
	
	CreateTag("input",parent,"chinesechars")
  	$e("chinesechars").type="text";
	$e("chinesechars").value= pattern;
}

function setzhuyin(WordId){

	createInputZhuyin();
	var ajaxzhuyin;
	var element = "inputzhuyin";
	var subelement = "value";
	var url = "Getzhuyin.php?value="+escape(WordId)+"&";
	ajaxzhuyin = new NativeAjax();
	ajaxzhuyin.sendRequest(url,element,subelement);
	addEvento("yesbuttonzy", "click", postcharacters);
	addEvento("nobuttonzy", "click", collagecharacters);
	resizesidebar();
	
}

function createInputZhuyin (){

	$e("zhuyin-question").style.visibility = "visible";
	CreateTag("input","zhuyin-house","inputzhuyin");
	$e("inputzhuyin").type="text";
	
	CreateTag("input","zhuyin-house","yesbuttonzy");
	$e("yesbuttonzy").type="button";
	$e("yesbuttonzy").value="Yes";
	
	CreateTag("input","zhuyin-house","nobuttonzy");
	$e("nobuttonzy").type="button";
	$e("nobuttonzy").value="No";
 
}

function postcharacters(){
   var chichars =$e("chinesechars").value;
   var zhuyin = $e("inputzhuyin").value;
   var czo = new Createczo();
   czo.createchichararray(chichars);
   czo.createzhuyinarray(zhuyin);
   czo.displaycharacters("output");
   remove("chinesechars");
   $e("zhuyin-question").style.visibility = "hidden";
   remove("zhuyin-house");
   resizesidebar();
}

function collagecharacters(){
    $e("bupomorfo-div").style.visibility= "visible";
    remove("yesbuttonzy");
    remove("nobuttonzy");
    remove("zhuyin-question");
    createaddcc("search-div");
    resizesidebar();
}

function createaddcc(div){
	
	CreateTag("input",div,"buttoncc")
    $e("buttoncc").type="button";
	$e("buttoncc").value = "Add CC";
    addEvento("buttoncc", "click", addchinesecharacter);
 }

function addchinesecharacter(){

    var chinesechars = rtrim($e("chinesechars").value);
    var lengthchinesecharacters =  chinesechars.length;
    var character = chinesechars.substring(0,1);
    var attachdiv ="output";
    if (character != ""){
    var restofcharacters = chinesechars.substring(1,lengthchinesecharacters);
    var i =  $e("output").getElementsByClassName('chinesechar').length;
    $e("chinesechars").value = restofcharacters;
    createcharsdiv(i,character,attachdiv);
    resizesidebar();
    }
}
 function addbupomorfocharacter(){
    var bupomorfoIndex = $e("zhuyin-characters").selectedIndex;
    var bupomorfoChar = $e("zhuyin-characters").options[bupomorfoIndex].value;
    var AcentIndex = $e("zhuyin-acent").selectedIndex;
    var Acent = $e("zhuyin-acent").options[AcentIndex].value;
    var bupomorfo = bupomorfoChar + Acent;

    if (bupomorfo != ""){
           var i = $e("output").getElementsByClassName('bupomorfocontainer').length -1;
           if (i != -1){

                var j =  $e("bupomorfocontainer"+i).getElementsByClassName('bupomorfo').length;
                createbupdiv(i,j,bupomorfo);
                $e("bupoempty").selected=true;
		$e("acentempty").selected=true;
           }
            else{
                alert ("Please post the Chinese Character first")
           }
       }
    else{
       alert('Empty field, Please select a Bupomorfo');
        }

 }


function fillfakeimagefile(value){
    $e("image-path-client").value = value;
}

function uploadimage (hostdiv,delelement){
    
      if($e(delelement)){
            remove(delelement);
          }
       createwaitingdiv(hostdiv);
}
function uploadaudio(hostdiv){
    createaudiohouse(hostdiv)
    createwaitingdiv(hostdiv);
}


function fillfakeaudiofile(value){

    $e("audio-path-client").value = value;
}
function collect(){
	CreateTag("input","send","chicharup");
    $e("chicharup").type="hidden";
    
    CreateTag("input","send","bupomorfoup");
    $e("bupomorfoup").type="hidden";
 

    var i =  $e("output").getElementsByClassName('chinesechar').length;
    var chineseword="";
    var bupomorfo="";
    for(var j=0;j<i;j++){

        chineseword =chineseword+$e("chinesechar"+j).value;
        var k = $e("bupomorfocontainer"+j).getElementsByClassName('bupomorfo').length;

            for(var l=0; l<k; l++){
                bupomorfo = bupomorfo+$e("bupomorfo"+j+l).value;
            }
            bupomorfo=bupomorfo+"\t";
    }
   $e("chicharup").value= chineseword;
   $e("bupomorfoup").value = rtrim(bupomorfo);
  
}


function showKeyPress(evt){
         if (evt.keyCode == 13){
             mysearch();
         }
}

function clickimageFileClient(){
    $e("imageFileClient").click();

}
function clickaudioFileClient(){
     $e("audioFileClient").click();
}


function submitVoice() { 
	//Find the applet object 
	var applet = document.getElementById("nanogong"); 
	// Tell the applet to post the voice recording to the  backend PHPcode 
	var ret = applet.sendGongRequest( "PostToForm", "receiver.php", "voicefile", "", "temp"); 
	if (ret == null || ret == "") 
	alert("Failed to submit the voice recording!"); 
	else alert("Voice recording has been submitted!"); 
	} 
