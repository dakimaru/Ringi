<?php
if ($usertype ==1){
	if ($userCount>0){
		for ($i = 0 ; $i < $userCount ; $i++)
		{
			echo '<input type="hidden" name="allUsertype'.$allUsername[$i].'" id="allUsertype'.$allUsername[$i].'" value="'.$allUsertype[$i].'">';
			echo '<input type="hidden" name="allName'.$allUsername[$i].'"	id="allName'.$allUsername[$i].'" value="'.$allName[$i].'">';
			echo '<input type="hidden" name="allEmail'.$allUsername[$i].'" id="allEmail'.$allUsername[$i].'" value="'.$allEmail[$i].'">';
			echo '<input type="hidden" name="allDepartment'.$allUsername[$i].'" id="allDepartment'.$allUsername[$i].'" value="'.$allDepartment[$i].'">';
			echo '<input type="hidden" name="allTitle'.$allUsername[$i].'" id="allTitle'.$allUsername[$i].'" value="'.$allTitle[$i].'">';
			echo '<input type="hidden" name="allManager'.$allUsername[$i].'" id="allManager'.$allUsername[$i].'" value="'.$allManager[$i].'">';
			echo '<input type="hidden" name="allActiveFlag'.$allUsername[$i].'" id="allActiveFlag'.$allUsername[$i].'" value="'.$allActiveFlag[$i].'">';
	
		}
	}
}

?>
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
                                    <li class="active">
                                        <a href="/Ringi/Users/user_setting">
                                                <div align="left" class="span11">Account</div>
                                                    <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
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
			if($usertype == 0) {
			echo '
			<div class="well">
                                <div align="left" class=" paddingLeft paddingTop">
                                        <h3 ">Account</h3>
                                        <h5 style="font-weight:normal;">Change Your Name and Email Address.</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/user_setting" method="post" onsubmit="return inputCheckUser()" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
							<input type="text" value="'.$username.'" disabled="diabled">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Full Name</label>
						<div class="controls">
							<input type="text" name="userFullName" value="'.$name.'" id="userFullName">
							<!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
							</label>-->
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="userEmail" value="'.$email.'" id="userEmail">
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
                                        <h3 ">Account</h3>
                                        <h5 style="font-weight:normal;">Change Profile for Users</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/user_setting" method="post" onsubmit="return inputCheckAdmin()" accept-charset="utf-8">
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
							<p style="margin:0;"><input type="checkbox" name="usertype" value="'.$usertype.'" id="usertype"'; if($usertype==1) echo 'checked'; echo '>Check the box to set an Admin user.</p>
							<p style="margin:0;"><input type="checkbox" name="activeFlag" value="'.$activeflag.'" id="activeFlag"'; if($activeflag==1) echo 'checked'; echo '> Check the box to active the user.</p>
							
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Full Name</label>
						<div class="controls">
							<input type="text" name="name" value="'.$name.'" id="name">
							<!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
							</label>-->
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email"value="'.$email.'" id="email">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Department</label>
						<div class="controls">
							<input type="text" name="department" value="'.$department.'" id="department">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Title</label>
						<div class="controls">
							<input type="text" name="title" value="'.$title.'" id="title">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Manager</label>
						<div class="controls">
							<input type="text" name="manager"value="'.$manager.'" id="manager">
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
function UpdateInput(){
	var index= document.getElementById("users").value;
	var usertype = document.getElementById("allUsertype"+index).value;
	var name = document.getElementById("allName"+index).value;
	var email = document.getElementById("allEmail"+index).value;
	var department = document.getElementById("allDepartment"+index).value;
	var title = document.getElementById("allTitle"+index).value;
	var manager = document.getElementById("allManager"+index).value;
	var activeFlag = document.getElementById("allActiveFlag"+index).value;
	
	document.getElementById("usertype").checked = (usertype == 1)? true:false;
	document.getElementById("name").value = name;
	document.getElementById("email").value = email;
	document.getElementById("department").value = department;
	document.getElementById("title").value = title;
	document.getElementById("manager").value = manager;
	document.getElementById("activeFlag").checked = (activeFlag == 1)? true:false;
 
}

function inputCheckAdmin(){
	var flag = true;
	
	flag &= nullCheck("manager");
	flag &= nullCheck("title");
	flag &= nullCheck("department");
	flag &= nullCheck("email");
	flag &= nullCheck("name");
	if (flag == false) {
		alert("Fill out all necessary fields");
		return false;
	}
	else {
		return true;
	}
}
function inputCheckUser(){
	var flag = true;
	flag &= nullCheck("userEmail");
	flag &= nullCheck("userFullName");
	if (flag == false) {
		alert("Fill out all necessary fields");
		return false;
	}
	else {
		return true;
	}
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

</script>

