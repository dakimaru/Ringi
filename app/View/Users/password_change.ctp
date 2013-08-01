

<div class="container">

<div class="row-fluid">
	<div class="span12 tabbable">
		<div align="center" class="span5">
			<div class="well well-large">
				<div class="row-fluid">
					<div class="span3 paddingTop">
						<p >
							<img class="" src="/Ringi/app/webroot/img/enspirea.png" width="70">
						</p>
					</div>
					<div class="span5 paddingTop">
						<h4 href="#"><?php echo $name; if($usertype==1) echo ' (Admin)'; ?></h4>
						<h5 href=#><?php echo $title; echo " ";echo $department; ?></h5>
					</div>
					
				</div>
			</div>
			<div class="well">
				<ul class="nav nav-tabs nav-stacked paddingTop">
                                    <li>
                                        <a href="/Ringi/Users/user_setting">
                                                <div align="left" class="span11">Account</div>
                                                    <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="/Ringi/Users/password_change">
                                            <div align="left" class="span11">
                                                Password
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
				    <?php
					if($usertype == 1){
					echo '
				    <li>
                                        <a href="/Ringi/Users/add">
                                            <div align="left" class="span11">
                                                Add User
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
				    ';
					}
				    ?>
                                </ul>
			</div>
			<div class="well">
				<ul class="clearfix paddingTop">
					<li class="inline">&copy 2013 Enspirea</li>
					<li class="inline">
						<a class="sitefoot" href="#">About</a>
					</li>
					<li class="inline">
						<a class="sitefoot" href="#">Help</a>
					</li>
					<li class="inline">
						<a class="sitefoot" href="#">Terms</a>
					</li>
					<li class="inline">
						<a class="sitefoot" href="/Ringi/app/webroot/img">Privacy</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="span7" >
			
			<?php
			if($usertype == 0){
			echo '
                        <div class="well">
                                <div align="left" class=" paddingLeft paddingTop">
                                        <h3>Password</h3>
                                        <h5 style="font-weight:normal;">Change Your Password</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/password_change" method="post" onsubmit="return inputCheck()" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Current Password</label>
						<div class="controls">
							<input type="password" name="currentPassword" id="currentPassword">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">New Password</label>
						<div class="controls">
							<input type="password"  name="newPassword" id="newPassword">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Verify Password</label>
						<div class="controls">
							<input type="password" name="verifyPassword" id="verifyPassword">
						</div>
					</fieldset>
					<input type="hidden" name="resourceflag" value="user" id="resourceflag">
					<hr>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Save Changes</button>
					</div>
				</form>
                        </div>
			';
			}?>
			
			<?php
			if ($usertype == 1){
			echo '
			<div class="well">
                                <div align="left" class=" paddingLeft paddingTop">
                                        <h3>Password</h3>
                                        <h5 style="font-weight:normal;">Reset Password for Users.</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/password_change" method="post" onsubmit="return inputCheck()" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
							<select name="users" id="users" onchange="UpdateInput();">';
								if($userCount>0){
									for ($i = 0; $i < $userCount; $i++){
										echo '<option ';
										if ($username == $allUsername[$i]){
											echo 'selected ';
										}
										echo 'value="'.$allUsername[$i].'">'.$allUsername[$i].'</option>';
									}
								}
							echo '
							</select>
							
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">New Password</label>
						<div class="controls">
							<input type="password"  name="newPassword" id="newPassword">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Verify Password</label>
						<div class="controls">
							<input type="password" name="verifyPassword" id="verifyPassword">
						</div>
					</fieldset>
                                        
                                        
                                        
                                                <!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
                                                </label>-->
					
					<input type="hidden" name="resourceflag" value="admin" id="resourceflag">
					<hr>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Save Changes</button>
					</div>
				</form>
                        </div>
			';
			}
			?>
			
			
		</div>
	</div>
	
</div>
</div>

<script type="text/javascript" charset="utf-8">
	
function inputCheck(){
	var flag = true;
	flag &= nullCheck("verifyPassword");
	flag &= nullCheck("newPassword");
	if (flag == false) {
		alert("Fill out all necessary fields");
		return false;
	}
	flag &= matchCheck("newPassword", "verifyPassword");
	if (flag == false) {
		alert("Password don't match");
		return false;
	}
	return true;
}

function nullCheck(var1){

	var x=document.getElementById(var1).value;
	if (x==null || x=="") {
		document.getElementById(var1).style.border = "2px solid #ff0000";
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
		return false;
	}
	return true;
}

function matchCheck(var1, var2){
	var x = document.getElementById(var1).value;
	var y = document.getElementById(var2).value;
	if (x === y) {
		return true;
	}
	else {
		document.getElementById(var1).style.border = "2px solid #ff0000";
		document.getElementById(var1).focus();
		document.getElementById(var1).select();
		document.getElementById(var2).style.border = "2px solid #ff0000";
		return false;
	}
}

</script>