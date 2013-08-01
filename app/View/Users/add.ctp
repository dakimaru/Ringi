<?php
if ($usertype == 0){
echo
'
<h1> You are not an Admin. You don\'t have access to this page. </h1>
';
}
if($usertype == 1){
echo '

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
						<h4 href="#">'.$name; if($usertype==1) echo ' (Admin)'; echo '</h4>
						<h5 href=#>'.$title; echo " ";echo $department; echo '</h5>
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
                                    <li>
                                        <a href="/Ringi/Users/password_change">
                                            <div align="left" class="span11">
                                                Password
                                            </div>
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
				    
				    <li class="active">
                                        <a href="/Ringi/Users/add">
                                            <div align="left" class="span11">
                                                Add User
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
                                        <h3>Add User</h3>
                                        <h5 style="font-weight:normal;">Add user to the system.</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/add" method="post" onsubmit="return inputCheck()" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
                                                        <input type="text" name="username" value="" id="username">
							<p style="margin:0;"><input type="checkbox" name="usertype" value="" id="usertype">Check the box to set an Admin user.</p>
							<p style="margin:0;"><input type="checkbox" name="activeFlag" value="" id="activeFlag" checked> Check the box to active the user.</p>
							
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Full Name</label>
						<div class="controls">
							<input type="text" name="name" value="" id="name">
							<!--<label class="checkbox">
                                                        <input type="checkbox">Let others find me by my email address
							</label>-->
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" name="email"value="" id="email">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Department</label>
						<div class="controls">
							<input type="text" name="department" value="" id="department">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Title</label>
						<div class="controls">
							<input type="text" name="title" value="" id="title">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">Manager</label>
						<div class="controls">
							<input type="text" name="manager" value="" id="manager">
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Create Password</label>
						<div class="controls">
							<input type="password" name="newPassword" value="" id="newPassword">
						</div>
					</fieldset>
                                        <fieldset class="control-group">
						<label class="control-label">Verify Password</label>
						<div class="controls">
							<input type="password" name="verifyPassword" value="" id="verifyPassword">
						</div>
					</fieldset>
                                        
                                        
                                        
                                        
					<input type="hidden" name="resourceflag" value="admin" id="resourceflag">
					<hr>
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Create User</button>
					</div>
				</form>
                        </div>
			
			
			
		</div>
	</div>
	
</div>
</div>
';
}
?>

<script type="text/javascript" charset="utf-8">
	
function inputCheck(){
	var flag = true;
        
        flag &= nullCheck("verifyPassword");
	flag &= nullCheck("newPassword");
        flag &= nullCheck("manager");
	flag &= nullCheck("title");
	flag &= nullCheck("department");
	flag &= nullCheck("email");
	flag &= nullCheck("name");
        flag &= nullCheck("username");
	if (flag == false) {
		alert("Fill out all necessary fields");
		return false;
	}
	flag &= matchCheck("newPassword", "verifyPassword");
	if (flag == false) {
		alert("Password don't match");
		return false;
	}
        
	return existingCheck("username");
}

function existingCheck(var1){
        var x=document.getElementById(var1).value;
        var count = <?php echo $userCount;?>;
        switch(var1){
            case "username":
                var jUsername= <?php echo json_encode($allUsername); ?>;
                for (var i = 0; i < count; i ++){
                    if (x == jUsername[i]) {
                        document.getElementById(var1).style.border = "2px solid #ff0000";
                        document.getElementById(var1).focus();
                        document.getElementById(var1).select();
                        alert("The username has been used. Please pick up an another username!");
                        return false;
                    }
                }
                break;
            default:
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