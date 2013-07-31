


<div class="container">
	
	
<?php
if ($userCount>0){
	for ($i = 0 ; $i < $userCount ; $i++)
	{
		echo '<input type="hidden" name="allName'.$i.'"	id="allName'.$i.'" value="'.$allName[$i].'">';
		echo '<input type="hidden" name="allEmail'.$i.'" id="allEmail'.$i.'" value="'.$allEmail[$i].'">';
		echo '<input type="hidden" name="allDepartment'.$i.'" id="allDepartment'.$i.'" value="'.$allDepartment[$i].'">';
		echo '<input type="hidden" name="allTitle'.$i.'" id="allTitle'.$i.'" value="'.$allTitle[$i].'">';
		echo '<input type="hidden" name="allManager'.$i.'" id="allManager'.$i.'" value="'.$allManager[$i].'">';
		echo '<input type="hidden" name="allActiveFlag'.$i.'" id="allActiveFlag'.$i.'" value="'.$allActiveFlag[$i].'">';

	}
}


?>

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
						<h4 href="#"><?php echo $name; ?></h4>
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
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Mobile
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Email Notifications
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Profile
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Design
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Apps
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="span11">
                                                Widgets
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
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
                        <div class="well">
                                <div align="left" class=" paddingLeft paddingTop">
                                        <h3 ">Account</h3>
                                        <h5 style="font-weight:normal;">Change your Name and Email Address.</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/user_setting" method="post" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
							<input type="text" value="<?php echo $username;?>" disabled="diabled"></td>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Full Name</label>
						<div class="controls">
							<input type="text" value="<?php echo $name; ?>">
							<!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
							</label>-->
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" value="<?php echo $email; ?>">
						</div>
					</fieldset>
                                        
                                        
                                        
                                                
					<input type="hidden" name="resourceflag" value="User" id="resourceflag">
					<hr>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Save Changes</button>
					</div>
				</form>
				
		
                        </div>
			<div class="well">
				<div align="left" class=" paddingLeft paddingTop">
                                        <h3 ">Account</h3>
                                        <h5 style="font-weight:normal;">Change Users' Profile</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/user_setting" method="post" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
							<select name="users" id="users" onchange="UpdateInput();">
								<?php	if($userCount>0){
									for ($i = 0; $i < $userCount; $i++){
										echo '<option ';
										if ($username == $allUsername[$i]){
											echo 'selected ';
										}
										echo 'value="'.$i.'">'.$allUsername[$i].'</option>';
									}
								}
								?>
							</select>
							
							<label class="checkbox">
								<p style="margin:0;"><input type="checkbox">Check the box to set an Admin user.</p>
								<p style="margin:0;"><input type="checkbox" name="activeFlag" value="<?php echo $activeflag; ?>" id="activeFlag"> Check the box to active the user.</p>
							</label>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Full Name</label>
						<div class="controls">
							<input type="text" name="name" value="<?php echo $name; ?>" id="name">
							<!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
							</label>-->
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email"value="<?php echo $email; ?>" id="email">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Department</label>
						<div class="controls">
							<input type="text" name="department" value="<?php echo $department; ?>" id="department">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Title</label>
						<div class="controls">
							<input type="text" name="title" value="<?php echo $title; ?>" id="title">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Manager</label>
						<div class="controls">
							<input type="text" name="manager"value="<?php echo $manager; ?>" id="manager">
						</div>
					</fieldset>
					
					
                                        
                                        
                                        
                                                <!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
                                                </label>-->
					<input type="hidden" name="resourceflag" value="User" id="resourceflag">
					<hr>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</div>
</div>


<script type="text/javascript" charset="utf-8">
function UpdateInput(){
 var index= document.getElementById("users").value;
 var name = document.getElementById("allName"+index).value;
 var email = document.getElementById("allEmail"+index).value;
 var department = document.getElementById("allDepartment"+index).value;
 var title = document.getElementById("allTitle"+index).value;
 var manager = document.getElementById("allManager"+index).value;
 var activeFlag = document.getElementById("allActiveFlag"+index).value;
 document.getElementById("name").value = name;
 document.getElementById("email").value = email;
 document.getElementById("department").value = department;
 document.getElementById("title").value = title;
 document.getElementById("manager").value = manager;
 document.getElementById("activeFlag").checked = activeFlag == 0? false:true;
 
}
</script>

