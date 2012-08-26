<?php

include "../CommonPHP/hd.php";

 ?>
        <link rel="stylesheet" type="text/css" href="../Style/login.css"/>
      
 <?php
 include"../CommonPHP/topnav.php";
 include"../CommonPHP/sidebar.php";
 ?>
 
				
	                 <div class="login">
						<div class="rounded2">
							<div class="rstitle">
								<div>Sign In</div>
							</div>
							
							<div id="sigcontainer">
							<form method="post" id="signin" action="login.php">
								<div id="username" class ="labnInput">
									
										<div class="labels">Username:</div>
									
									<div class="inputs">
										<input id="username" name="username" class="inputtext" value="" title="username" tabindex="4" type="text">
									</div>
								</div>
								<div id="password" class ="labnInput">
									
										<div class="labels">Password:</div>
									
									<div class="inputs">
										<input id="password" name="password" class="inputtext" value="" title="password" tabindex="5" type="password">
									</div>
								</div>
								<div id="submitbutton" class="rsbutton">
										<input id="signinsubmit" value="Sign in" tabindex="6" type="submit" class="buttonI" name="login">
								</div>
								<div id= "remember" >
									<div id="sigcb">
										<input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox"/>
									</div>
									<div id="labelcb">
										<div>Remember me</div> 
									</div>
								</div>
								<div class="resendpass" > 
									<a href="#" >Forgot your password?</a> 
								</div>
								<div class="resendpass" > 
									<a href="#" >Forgot your username?</a> 
								</div>
								
							</form>
						  </div>
						</div>
						
	                 </div>
	                 
	                 <div class="register">
						<div class="rounded2">
							<div class="rstitle">
								<div>Join Us</div>
							</div>
							<div id="regcontainer">
							<form method="post" action="login.php"name="reg" id="reg" >
								<div id="fname" class ="labnInput">
									<div class="labels">
										First Name:						
									</div>
									<div class="inputs">
										<input type="text" class="inputtext" id="firstname" name="firstname"tabindex="8" value=""/>
									</div>
								</div>
								<div id="lname" class ="labnInput">
									<div class="labels">
										Last Name:			
									</div>
									<div class="inputs">
										<input type="text" class="inputtext"id="lastname" name="lastname" tabindex="9"value=""/>
									</div>
								</div>
								<div id="username"class ="labnInput">
									<div class="labels">	
										Username:					
									</div>
									<div class="inputs">
										<input type="text" class="inputtext"id="username" name="username" tabindex="11"value=""/>
									</div>
								</div>
								<div id="email"class ="labnInput">
									<div class="labels">	
										Your Email:					
									</div>
									<div class="inputs">
										<input type="text" class="inputtext"id="regemail" name="regemail" tabindex="12"value=""/>
									</div>
								</div>
						  
								<div id="genwpass" class ="labnInput">
									<div class="labels">
										New Password:						
									</div>
									<div class="inputs">
										<input type="password" class="inputtext" tabindex="11" id="regpasswd" name="regpasswd" value=""/>
									</div>
								</div>
								<div class="rsbutton">
									<input id="joinus" value="Create my account" tabindex="13" type="submit" class="buttonI" name="register">
								</div>
							
							</form>
							</div>

						</div>
	                 </div>
	                  
			    
               
 <?php
 include "../CommonPHP/ft.php";
?>
