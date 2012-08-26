 <?php
include "../CommonPHP/hd.php";


 ?>
		<link rel="stylesheet" type="text/css" href="../Style/inputstyle.css"/>
		<script type="text/javascript" src="../CommonJS/Sharedfx.js"></script>
		<script type="text/javascript" src="./input.js"></script>
		<script type="text/javascript" src="../CommonJS/swfobject.js"></script>
 <?php
 include"../CommonPHP/topnav.php";
 include"../CommonPHP/sidebar.php";
 ?>
				<iframe name="input-frame" style="display:none"></iframe> 
				<form id="input-form" name="input-form" class="" action="input.php" method="post" enctype="multipart/form-data" target="input-frame"> 
					<div class="row-div"> 
						<div class="column-div first-column"> 
							<div id="output" class="rounded"> 
							</div> 
						</div> 
						<div class="column-div"> 
							<div id="img-div" class="rounded"> 
							</div> 
						</div> 
						<div class="column-div"> 
							<div id="audio-div" class="rounded"> 
								<div id="audioplayer-div" > 
								</div> 
							</div> 
						</div> 
					</div> 
					<div class="row-div"> 
						<div class="column-div first-column"> 
							<div id="search-div" > 
								<div id= "search-subdiv" class="search-subdiv"> 
									<input type="text" id="search-text" class="search-text" onkeypress ="showKeyPress(event)" /> 
									<input type = "button"  id = "search-button" value="Search" class="buttonI" onclick="mysearch()"/> 
								</div> 
							</div>
							<div id="bupomorfo-div" class="bupomorfo-div"> 
								<div class="bupo-utf8" > 
									<select  id="zhuyin-characters" name="zhuyin-characters" size="1" class="selection" > 
										<option selected= "selected" id="bupoempty"value=""> </option> 
										<option value="&#12549"> &#12549 </option> <option value="&#12553"> &#12553 </option> 
										<option value="&#12563"> &#12563 </option> <option value="&#12570"> &#12570 </option> 
										<option value="&#12574"> &#12574 </option> <option value="&#12578"> &#12578 </option> 
										<option value="&#12563"> &#12563 </option> <option value="&#12582"> &#12582 </option> 
										<option value="&#12550"> &#12550 </option> <option value="&#12554"> &#12554 </option> 
										<option value="&#12557"> &#12557 </option> <option value="&#12560"> &#12560 </option> 
										<option value="&#12564"> &#12564 </option> <option value="&#12567"> &#12567 </option> 
										<option value="&#12583"> &#12583 </option> <option value="&#12571"> &#12571 </option> 
										<option value="&#12575"> &#12575 </option> <option value="&#12579"> &#12579 </option> 
										<option value="&#12551"> &#12551 </option> <option value="&#12555"> &#12555 </option> 
										<option value="&#12558"> &#12558 </option> <option value="&#12561"> &#12561 </option> 
										<option value="&#12565"> &#12565 </option> <option value="&#12568"> &#12568 </option> 
										<option value="&#12584"> &#12584 </option> <option value="&#12572"> &#12572 </option> 
										<option value="&#12576"> &#12576 </option> <option value="&#12580"> &#12580 </option> 
										<option value="&#12552"> &#12552 </option> <option value="&#12556"> &#12556 </option> 
										<option value="&#12559"> &#12559 </option> <option value="&#12562"> &#12562 </option> 
										<option value="&#12566"> &#12566 </option> <option value="&#12569"> &#12569 </option> 
										<option value="&#12585"> &#12585 </option> <option value="&#12573"> &#12573 </option> 
										<option value="&#12577"> &#12577 </option> <option value="&#12581"> &#12581 </option> 
									</select> 
								</div> 
								<div class="acent-utf8"> 
									<select id="zhuyin-acent" name="zhuyin-acent" size="1" class="selection" > 
										<option selected= "selected" id="acentempty"value=""> </option> 
										<option value="&#711"> &#711 </option> <option value="&#715"> &#715 </option> 
										<option value="&#714"> &#714 </option> <option value="&#729"> &#729 </option> 
									</select> 
								</div> 
								<input  type="button" name="add-bupomorfo" value="Add BPM" class="buttonI   add-bupomorfo "   onclick = "addbupomorfocharacter()" />
							</div> 
						</div>
						<div class="column-div"> 
							<div class="inputfile-div"> 
								<input name="imageFileClient" id= "imageFileClient" type="file" class="file" onchange="fillfakeimagefile(this.value)"/>                                            
								<div class="fake-elements"> 
									<input  id="image-path-client" class="fake-text"/> 
									<div  class="fake-button"> 
										<input type="button"  class="buttonI" value="Choose File" onclick="clickimageFileClient()"/> 
									</div> 
								</div> 
							</div>
						</div> 
						<div class="column-div"> 
							<div class="inputfile-div"> 
								<input  name="audioFileClient" id= "audioFileClient"   type="file" class="file" onchange="fillfakeaudiofile(this.value)"/> 
								<div class="fake-elements"> 
									<input  id="audio-path-client" class="fake-text"/> 
									<div class="fake-button"> 
										<input type="button"  class="buttonI" value="Choose File" onclick="clickaudioFileClient()"/> 
									</div> 
								</div> 
							</div>
						</div> 
					</div> 
					<div class="row-div"> 
						<div class="column-div first-column">
							<div ><!-- id="zhuyinopt" class="zhuyinopt-->
								<div id="zhuyin-house" class="zhuyin-house"> 
								</div> 
								<div id="zhuyin-question" class="zhuyin-question"> 
									<p class="iirq">Is it the right zhuyin?</p> 
								</div> 
							</div> 
						</div> 
						<div class="column-div" > 
							<input type="submit" name="SubmitImageFile" value="Preview Image" id="SubmitImageFile" class="buttonI" onclick="uploadimage('img-div','image')"  /> 
						</div> 
						<div class="column-div" > 
							<input type="submit" name="SubmitAudioFile" value="Preview Audio" id="SubmitAudioFile" class="buttonI" onclick="uploadaudio('audio-div')"  /> 
						</div> 
					</div> 
					<div class="row-div"> 
						<div class="send"id="send"> 
							<input type="submit" id= "SubmitForm" name="SubmitForm" value="Submit" class="buttonI" onclick="collect()" /> 
						</div> 
					</div>
				</form>
<?php

 include "../CommonPHP/ft.php";
?>
