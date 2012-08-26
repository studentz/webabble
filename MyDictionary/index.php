<?php
include "../CommonPHP/hd.php";
?>
		<link rel="stylesheet" type="text/css" href="../Style/mydictionary.css" />
		<script type="text/javascript" src="../CommonJS/Sharedfx.js"></script>
		<script type="text/javascript" src="../CommonJS/swfobject.js"></script>
		<script type="text/javascript" src="../CommonJS/lib/prototype.js" ></script>
		<script type="text/javascript" src="../CommonJS/lib/scriptaculous.js?load=effects" ></script>
		<script type="text/javascript" src="./mydictionary.js" ></script>
<?php
include"../CommonPHP/topnav.php";
include"../CommonPHP/sidebar.php";
?>

				<div class="column-div"> 
					<div id= "search-div" >
						<a onclick= "expandsearchdiv('search-subdiv','dictionary-subdiv') " href = "#">Search</a> 
						<div id="search-subdiv" class="search-subdiv" style="display : none;">
							<input id= "EnWord" name="EnWord" class="search-text" type= "text" value = "" onkeypress ="showKeyPress(event)"/>
							<input id= "FindCC" name= "FindCC" class= "inactive-button"  type= "button" value="Submit" onclick= "findcc($e('EnWord').value)" />							
						</div>						
					</div>
					<div id= "suggestion"> 
					</div>
					<div  class= "dictionary-div"> 
						<a href = "#" onclick="expandsearchdiv('dictionary-subdiv','search-subdiv')" >My dictionary</a> 
						<div id= "dictionary-subdiv" style="display: none;"> 
							<select id="dictionary-select" class="dictionary-select" size="10"> 
							</select> 
						</div> 
					</div> 
				</div> 
				<div class="column-div"> 
					<div id="characters-div" class="rounded"> 
					</div> 
				</div> 
				<div class="column-div"> 
					<div id="image-div" class= "rounded"> 
					</div> 
				</div> 
				<div class="column-div"> 
					<div id= "audio-div" class="rounded"> 
						<div id="audioplayer-div" > 
						</div> 
					</div> 
				</div> 

<?php
include "../CommonPHP/ft.php";
?>
