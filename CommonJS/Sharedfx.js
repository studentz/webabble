/**
 * @author pablo
 */

function $e(e){
    return document.getElementById(e);
}

function remove(el){
    var  e= $e(el);
    e.parentNode.removeChild(e);
}
  
function addEvento(element, eventType, fx){
    var obj = $e(element);
    if(obj.addEventListener)
	obj.addEventListener(eventType, fx, false);
    if(obj.attachEvent)
	obj.attachEvent('on'+eventType, fx);
}

function removeEvent(element, eventType, fx){
    var obj = $e(element);
    if(obj.detachEvent){
	obj.detachEvent('on'+eventType, fx);
    }else{
	obj.removeEventListener(eventType, fx, false);		
    }
}

function CreateTag (tag,parent,identification){
    var new_tag = document.createElement(tag);
    new_tag.id = identification;
    new_tag.className = identification;
    new_tag.name= identification;
    $e(parent).appendChild(new_tag);
}
		 
function NativeAjax (){

    var req;
    function setRequest (){
	if (window.XMLHttpRequest) {
	    if (navigator.userAgent.indexOf('MSIE') != -1) {
		isIE = true;
	    }
	    return new XMLHttpRequest();
	} 
	else if (window.ActiveXObject) {
	    isIE = true;
	    return new ActiveXObject("Microsoft.XMLHTTP");
	}
    }
    function transferComplete() {
	if ($e("waitingdiv")){
	    remove("waitingdiv");
	}
    }
    this.sendRequest = function (url,e,se) {
      	req = setRequest();
        req.addEventListener("load", transferComplete, false);
        req.open("GET", url, true);
        req.onreadystatechange =  function callback(){
            if (req.readyState == 4){
                if (req.status == 200){
                    if (se == "innerHTML"){
                        $e(e).innerHTML = req.responseText;
                    }
		    else if (se == "value"){
                        $e(e).value = req.responseText;
		    }
		}
            }
	}
        req.send(null);
    }
}

function  createwaitingdiv(element){
    var waitingdiv = document.createElement("div");
    waitingdiv.id ="waitingdiv";
    waitingdiv.className= "waitingdiv";
    var waitingimage = document.createElement("img");
    waitingimage.className ="waitingimage";
    waitingimage.src = "../Images/animationpink.png";
    waitingdiv.appendChild(waitingimage);
    $e(element).appendChild(waitingdiv);
}

function Createczo (){
    
    this.chinesecharacters = new Array();
    this.bupomorfocharacters = new Array();
    this.createchichararray = function(chichars){
        chichars = rtrim(chichars);
        chichars = ltrim (chichars);
        this.chinesecharacters = chichars.split("");
    }
    
    this.createzhuyinarray = function(zhuyin){
        zhuyin = rtrim(zhuyin);
        zhuyin = ltrim(zhuyin);
        var arrayzhuyin = zhuyin.split("\t");
        
        for(var j = 0 ; j <arrayzhuyin.length; j++){
	    var arrayBupomorfo = arrayzhuyin[j].split(""); 
            var pattern = new RegExp("[|ˊ|ˋ｜ˇ|˙｜]","g");
	    //look for acent in bupomorfo if found the first match
            if (pattern.test(arrayzhuyin[j])) { 
            // "g flag"   return true
		var position = pattern.lastIndex;   
                //lastIndex property of the regular expression object to the character position
		var arrayBupomorfolength = arrayBupomorfo.length;
		//immediately following the matched substring
		var acent = arrayBupomorfo[position-1];
		//ordered array, No object b/c the words keeps
                var previousToAcent = arrayBupomorfo[position-2];
		//order  to build or read and words  have similar characters
                arrayBupomorfo[position-2] = previousToAcent+acent;
                arrayBupomorfo.pop();
                arrayBupomorfolength = arrayBupomorfolength -1;										
	    }
            this.bupomorfocharacters[j] = arrayBupomorfo;
        }
    }
    
    this.displaycharacters= function(attchdiv){

	var i=0;
	for (i ; i< this.chinesecharacters.length ; i++) {
	    var c= this.chinesecharacters[i];
	    createcharsdiv (i,c,attchdiv)
	    var j=0;
	    for (j ; j < this.bupomorfocharacters[i].length; j++) {
		var d =  this.bupomorfocharacters[i][j];
		createbupdiv(i,j,d)
	    }
	}
    }
}

function createcharsdiv(i,character,attachdiv){
    
    var divMainContainer = window.document.createElement('div');
    divMainContainer.name = 'maincontainer';
    divMainContainer.className = 'maincontainer';
    divMainContainer.id = 'maincontainer'+i;

    var divOne = window.document.createElement('div');
    divOne.name = 'chicharcontainer';
    divOne.className= 'chicharcontainer';
    divOne.id = 'chicharcontainer'+i;
    
    var divTwo =  window.document.createElement('div');
    divTwo.name = 'bupomorfocontainer';
    divTwo.className= 'bupomorfocontainer';
    divTwo.id= 'bupomorfocontainer'+i;

    var inputOne = window.document.createElement('input');
    inputOne.id = 'chinesechar'+i;
    inputOne.name = 'chinesechar'+i;
    inputOne.className = 'chinesechar';
    inputOne.value= character ;
    
    divOne.appendChild(inputOne);
    divMainContainer.appendChild(divOne);
    divMainContainer.appendChild(divTwo);
    $e(attachdiv).style.cssText= "border-style:solid";
    $e(attachdiv).appendChild(divMainContainer);

}

function createbupdiv(i,j,d){
    var new_input_small = window.document.createElement('input');
    new_input_small.name = 'bupomorfo'+i+j;
    new_input_small.className = 'bupomorfo';
    new_input_small.id = 'bupomorfo'+i+j;
    new_input_small.size = '2';
    new_input_small.value =d;
    var new_div_small = window.document.createElement('div');
    new_div_small.appendChild(new_input_small);
    $e('bupomorfocontainer'+i).appendChild(new_div_small);

}
 
function rtrim ( str, charlist ) {
    charlist = !charlist ? ' \\s\u00A0' : (charlist+'').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return (str+'').replace(re, '');
}

function ltrim ( str, charlist ) {
    charlist = !charlist ? ' \\s\u00A0' : (charlist+'').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    var re = new RegExp('^[' + charlist + ']+', 'g');
    return (str+'').replace(re, '');
}

function   createaudiohouse(hostdiv){
    if (!$e("audioplayer-div")){
	swfobject.removeSWF("audioplayer");
	var audioHouse = document.createElement("div");
	audioHouse.id="audioplayer-div";
	document.getElementById(hostdiv).appendChild(audioHouse);
    }
}

function cleandiv(div){
    if ($e(div)){
	remove(div);
    }
}
	
function resizesidebar(){
    var x =   $e("appdiv").clientHeight;
  $e("sidebar").style.height = x+"px";
}
