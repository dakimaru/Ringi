<!--<div class="container">

	<div class="surface">
		<div class="account-content">
			<form method="post" action="../users/password_change">

				<h2 class="form-signin-heading">Change password</h2>
				<p>New Password</p>

				<input type="text" placeholder="New pass" name="newpass"><br>

				<p>Retype Password</p>

				<input type="text" placeholder="Retype" name="confirmpass"><br>

				<button class="btn btn-primary" type="submit">Submit</button>

			</form>
		</div>
	</div>

</div>

-->

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
						<h4 href="#"><?php echo $name; ?></h4>
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
                                        <h3 ">Password</h3>
                                        <h5 style="font-weight:normal;">Change your password or recover your current one.</h5>
                                </div>
                                <hr>
				<form class="form-horizontal" action="/Ringi/Users/password_change" method="post" accept-charset="utf-8">
					<fieldset class="control-group">
						<label class="control-label">Current Password</label>
						<div class="controls">
							<input type="password" name="currentPassword" id="currentPassword"></td>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label">New Password</label>
						<div class="controls">
							<input type="password"  name="newPassword" id="newPassword"></td>
						</div>
					</fieldset><fieldset class="control-group">
						<label class="control-label">Verify Password</label>
						<div class="controls">
							<input type="password" name="verifyPassword" id="verifyPassword"></td>
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


