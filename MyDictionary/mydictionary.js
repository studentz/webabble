function init() {
    if (arguments.callee.done) return;
    arguments.callee.done = true;
    getMyDictionary();
    $e("sidebar").style.height = "275px";
}

function expandsearchdiv(div,hide) {
	cleandiv("SelectedWord");
	Effect.toggle(div,'slide');
	if ($e(hide).style.display != "none"){
		Effect.SlideUp(hide);
	}
	if (div == "SearchTog"){
		$e("EnWord").value= "";
	} else {
		$e("dictionary-select").selectedIndex = 0;
	}  
//	checkTogDiv();	
	  
	resizesidebar();
}

if (document.addEventListener){
	document.addEventListener("DOMContentLoaded", init, false);
}

function getMyDictionary(){
	var ajaxsearch = new NativeAjax();
	var url =  "./mydictionary.php?value="+escape(".*");
	ajaxsearch.sendRequest(url,"dictionary-select","innerHTML");
	addEvento('dictionary-select', "click", findingSelected)
 
}
function findingSelected(){
	var MydictionarySelect = $e("dictionary-select");
	var InputValue = MydictionarySelect.options[ MydictionarySelect.selectedIndex].value;
	var InputWord =MydictionarySelect.options[ MydictionarySelect.selectedIndex].innerHTML;
	if (InputValue != "NoValid"){
		wordsearch(InputWord);
	}
}
	 
function findcc(InputWord){
	 if (InputWord != ""){
		wordsearch(InputWord);
	}
}

function wordsearch(InputWord){
	cleandiv("SelectedWord")
	var ajaxsearch = new NativeAjax();
	CreateTag("select","suggestion","SelectedWord");
	$e("SelectedWord").size=2;
	var url =  "mydictionary.php?value="+escape(InputWord);
	ajaxsearch.sendRequest(url,"SelectedWord","innerHTML");
	addEvento('SelectedWord', "click", displaySelected)
	resizesidebar();
}


	function displaySelected(){
		var SelectWord= $e("SelectedWord");
	 	var ChineseWordId = SelectWord.options[SelectWord.selectedIndex].value;
	 	
		if (ChineseWordId != "NoValid"){
			
			var ChineseTradWord = SelectWord.options[SelectWord.selectedIndex].innerHTML;
			var pattern= new RegExp("^[^a-z|A-z|0-9|(]+");
			var resultpattern = ChineseTradWord.replace(pattern, "");
			SelectWord.options[SelectWord.selectedIndex].innerHTML = resultpattern;
			
			if ($e("ImageWord") == null){
				
				if ($e("image-div").childElementCount == 0) {
					CreateTogDiv("image-div","TogDivB","TogImgB")
				}
			CreateTag("div","image-div","imageHouse");
			CreateTag("img","imageHouse","ImageWord");
		
			}
			
				
			var url = "image.php?ChineseWordId="+ChineseWordId;	
			$e("ImageWord").src = url;
			$e("image-div").style.cssText= "padding:5px;border-style: solid";
			
			
			var audiostring = "audio.php?ChineseWordId="+ChineseWordId;
			createaudiohouse("audio-div")
			var id = "audioplayer-div";
			$e("audio-div").style.cssText= "padding:10px;border-style: solid";
			var par = {menu:"false",flashvars:"src="+audiostring};
			var att = {data:"http://babble/Images/emffplayer.swf", width:"140", height:"30",bgcolor:"#000000",id:"audioplayer", name:"audioplayer"};
			swfobject.createSWF(att,par,id);
			
			
			url= "answer.php";
			new Ajax.Request(url, {
			method: 'get',
			parameters: { ChineseWordIdQ: ChineseWordId},
			onSuccess: process,
			onFailure: function() { 
			alert("There was an error with the connection"); 
				}
			});
			
			
		} 
}

function process(transport) {
			var response =  eval('('+ transport.responseText +')');
			
			if ($e("chioutput")){
				cleandiv("chioutput");
			}
			if ($e("characters-div").childElementCount == 0) {
					CreateTogDiv("characters-div","TogDivA","TogImgA")
				}
				
			CreateTag ("div","characters-div","chioutput")
			
			var czo = new Createczo();
			czo.createchichararray(response.ChineseTraditional);
			czo.createzhuyinarray(response.Zhuyin);
			czo.displaycharacters("chioutput");
			$e("characters-div").style.cssText= "padding:5px;border-style: solid";
			$e("chioutput").style.cssText= "border-style:none";
			resizesidebar();
}

 function showKeyPress(evt){
	 if (evt.keyCode == 13){
		findcc($e('EnWord').value);
	 }
}

function CreateTogDiv(parent,dividentity, imgidentity){
			CreateTag("div",parent,dividentity);
			CreateTag("img",dividentity,imgidentity);
			$e(imgidentity).src = "../Images/opena.png";
			$(imgidentity).observe("mouseover", ChangeIcon);
			$(imgidentity).observe("mouseout", ChangeIcon);
			$(imgidentity).observe("click", toggleHouse);
}
	

	
function ChangeIcon(event) {	
	var element = event.element();
	if		(element.src == "http://babble/Images/opena.png"){
			element.src = "../Images/closea.png";
			element.title = "Hide";
			 		
		}
	else {
		element.src = "../Images/opena.png";
		element.title = "Show";
	}	
}

function toggleHouse(event){
	var element = event.element();
	
	if (element.src == "http://babble/Images/closea.png"){
			 element.src = "../Images/opena.png";
		}
	else {
		element.src = "../Images/closea.png";
		}	
	var parent= element.parentNode;
	var sibling = parent.nextElementSibling;
	
	Effect.toggle(sibling,"slide");	

}
/*
function checkTogDiv(){
	
	if ($e(TogImgA)!= null  || $e(TogImgB)!= null) {
		 if ($e(TogImgA).src ==  "../Images/opena.png" || $e(TogImgB).src == "../Images/opena.png" ){
			 
			cleandiv("chioutput");
			cleandiv("imageHouse");	
			cleandiv("TogDivA");
			cleandiv("TogDivB");	 
		}
	 
	}	
} 
 */
