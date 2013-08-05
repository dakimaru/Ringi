
<!--
<h2 align="center">Admin Panel</h2><br>
<div class="row-fluid">
<div class="span1 offset1">
<p><a href="/Ringi/setup" class="btn btn-primary btn-large" style="width:100%;">Set Up</a></p><br>
</div>
<div class="span1 offset1">
<p><a href="/Ringi/users/add" class="btn btn-primary btn-large" style="width:100%">Add User</a></p><br>
</div>
<div class="span1 offset1">
<p><a href="./upload_layout" class="btn btn-primary btn-large" style="width:100%">Layouts</a></p><br>
</div>
<div class="span1 offset1">
<p><a href="./overview" class="btn btn-primary btn-large" style="width:100%">Ringi</a></p><br>
</div>
<div class="span1 offset1">
<p><a href="./password_reset" class="btn btn-primary btn-large" style="width:100%">Password Reset</a></p><br>
</div>
</div>-->



<div class="container">
	<div class="row-fluid">
		<div align="center" class="span5">
			<div class="well well-large">
				<div class="bottomBorder row-fluid">
					<div class="span3 paddingTop">
						<p >
							<img class="" src="/Ringi/app/webroot/img/enspirea.png" width="70">
						</p>
					</div>
					<div class="span6 paddingTop">
						<h4 align="left" href="#"><?php echo $name; ?></h4>
						<h5 align="left" style="color:#888;" href="#"><?php echo $title; echo " ";echo $department; ?></h5>
					</div>
					<div class="span3 paddingTop">
						<a href="/Ringi/apply">
							<img class="" src="/Ringi/app/webroot/img/create.png" width="60">
						</a>
					</div>
				</div>
				<div class="bottomBorder row-fluid">
						<div class="span3 rightBorder">
							<h4><?php echo $editcount ?></h4>
							<p>Edit</p>
						</div>
						<div class="span3 rightBorder">
							<h4><?php echo $applicationcount ?></h4>
							<p>Application</p>
						</div>
						<div class="span3 rightBorder">
							<h4><?php echo $acceptednumber ?></h4>
							<p>Approved</p>
						</div>
						<div class="span3">
							<h4><?php echo $progressnumber ?></h4>
							<p>In Progress</p>
						</div>
				</div>
				<!--<div class="row-fluid  paddingTop">
					<div class="span4" >
						<ul class="nav nav-pills">
							<li>
								<a class="smaller" href="#">Summary</a>
							</li>
						</ul>
					</div>
					<div class="span4">
						<ul align="center"  class="nav nav-pills">
							<li>
								<a class="smaller" href="#">InProgress</a>
							</li>
						</ul>
					</div>
					<div class="span4">
						<ul align="center" class="nav nav-pills">
							<li>
								<a class="smaller" href="#">Passback</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3 paddingTop">
						<ul class="nav nav-pills">
							<li>
								<a class="smaller" href="#">OnHold</a>
							</li>
						</ul>
					</div>
					<div class="span3 paddingTop">
						<ul class="nav nav-pills">
							<li>
								<a class="smaller" href="#">Accepted</a>
							</li>
						</ul>
					</div>
					<div class="span3 paddingTop">
						<ul class="nav nav-pills">
							<li>
								<a class="smaller" href="#">Rejected</a>
							</li>
						</ul>
					</div>
					<div class="span3 paddingTop">
						<ul class="nav nav-pills">
							<li>
								<a class="smaller" href="#">Confirm</a>
							</li>
						</ul>
					</div>
				</div>-->
			</div>
			<div class="well well-large">
				<div class="row-fluid">
					<div class="span5">
						<h4>Who to Approve</h4>
					</div>
					
				</div>
					
				<?php for ($i = 0; $i < $approverCount; $i++)
				                                    echo '<div class="row-fluid">
									<div class="span3">
										<img class="fixed_width" src="/Ringi/app/webroot/img/XuHan.png" width="80">
									</div>
									<div align="left" class="span9">
										<p>Name:'.$approverId[$i].'</p>
										<p>Title:'.$approverTitle[$i].'</p>
										<p>Dept:'.$approverDept[$i].'</p>
									</div>
									
								</div>';
				  ?>
			</div>
			<div class="well">
				<div class="bottomBorder row-fluid">
					<div class="span3 paddingTop">
						<p >
							<img class="" src="/Ringi/app/webroot/img/enspirea.png" width="70">
						</p>
					</div>
					<div class="span7" style="color:#888; padding-top:25px; ">
						<h4 align="left" style="font-weight:500;">ENSPIREA LLC's APPROVE</h4>
					</div>
				</div>
			</div>
			<?php 
			$user = $this->Session->read('Auth.User');
			if ($user['usertype']==1){
				echo ('
			<div class="well">
				<div class="row-fluid paddingTop paddingBottom">
					<div class="span4 offset1">
						<a href="/Ringi/Users/password_change" class="btn btn-trans" style="font-weight:normal;color:#888;">Password Reset</a>
					</div> 
					<div class="span3">
						<a href="/Ringi/upload_layout" class="btn btn-trans" style="font-weight:normal;color:#888;">Upload Excel</a>
					</div>
					<div class="span3">
						<a href="/Ringi/Users/add"class="btn btn-trans" style="font-weight:normal;color:#888;">Add User</a>
					</div>
					
				</div>
				<div class="row-fluid paddingBottom">
					<div class="span4 offset1">
						<a href="#" class="btn btn-trans" style="font-weight:normal;color:#888;">Japanese1</a>
					</div>
					<div class="span3">
						<a href="#" class="btn btn-trans" style="font-weight:normal;color:#888;">Japanese2</a>
					</div>
					<div class="span3">
						<a href="#" class="btn btn-trans" style="font-weight:normal;color:#888;">Budget</a>
					</div>
				</div>
			</div>
			');}
			?>
			
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

		<!-- tablable section starts-->
		<div class="span7">
			<div class="well">
			    <div class="tabbable"> <!-- Only required for left/right tabs -->
				  <ul class="nav nav-tabs">
				    <li class="active"><a href="#tab1" data-toggle="tab">Summary</a></li>
					<li><a href="#tab2" data-toggle="tab">Editing</a></li>
					<li><a href="#tab3" data-toggle="tab">In Progress</a></li>
					<li><a href="#tab4" data-toggle="tab">Accepted</a></li>
					<li><a href="#tab5" data-toggle="tab">Rejected</a></li>
					<li><a href="#tab6" data-toggle="tab">OnHold</a></li>
					<li><a href="#tab7" data-toggle="tab">Deleted</a></li>
				  </ul>
				
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
				      	<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] != '005'){
							echo '
								
								<div class="well-small topBorder">
									<div class="row-fluid">
										<div class="span11 offset1">
											
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
											<div class="row-fluid">
												<div class="span6">
													<p>Project Name:'.$project[$i].'</p>
												</div>
												<div class="span6">
													<p>Date:'.$applyDate[$i].'</p>
												</div>
											</div>
											<div>
												<p>Purpose:'.$purpose[$i].'</p>
											</div>
											<div class="row-fluid">
												<div class="span6">
													<p>Total: $'.$application[$i].'</p>
												</div>
												<div class="span6">
													<p>Remaining Budget: $'.$remain[$i].'</p>
												</div>
											</div>
											<div>
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="row-fluid">
												<div class="span6">
													<form action="application_details" method="post" accept-charset="utf-8">
														<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
														<input type="hidden" name="resourceflag" value="home" id="resourceflag">
														<button class="btn btn-trans"><img src="/Ringi/app/webroot/img/detail_icon.png" width="30"> Details</button>
													</form>
												</div>';
												
													if ($ringiStatus[$i]=="001") {
														echo '
												<div class="span5">
														<form action="edit" method="post" accept-charset="utf-8">
															<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
															<button class="btn btn-trans"><img src="/Ringi/app/webroot/img/process_icon.png" width="30" > Continue</button>
														</form>
												</div>
												';
													}
													elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" || $ringiaction[$i]=="012")){
													
													echo '
												<div class="span6">
													<form action="pattern3" method="post" accept-charset="utf-8">
														<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
														<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
														<input type="hidden" name="resourceflag" value="home" id="resourceflag">
														<button class="btn btn-trans" ><img src="/Ringi/app/webroot/img/process_icon.png" width="30" > Cancel</button>
													</form>
												</div>
												';
													}
													else {
														;
													}
													echo '
											</div>
										</div>
									</div>
								</div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab2">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '001'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								</div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab3">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '002'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div></div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab4">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '003'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div></div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab5">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '004'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div></div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab6">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '006'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div></div>';
							
						}
					}
					?>
					</div>
					<div class="tab-pane" id="tab7">
					<?php for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '005'){
							echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div>
												<p>Application Title:'.$ringiName[$i].'</p>
											</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Project Name:'.$project[$i].'</p>
											</div>
											<div class="span6">
												<p>Date:'.$applyDate[$i].'</p>
											</div>
										</div>
										<div>
											<p>Purpose:'.$purpose[$i].'</p>
										</div>
										<div class="row-fluid">
											<div class="span6">
												<p>Total: $'.$application[$i].'</p>
											</div>
											<div class="span6">
												<p>Remaining Budget: $'.$remain[$i].'</p>
											</div>
										</div>
										<div class="row-fluid">
											<div class="span8">
												<p>Status:'.$ringiStatusName[$i].'</p>
											</div>
											<div class="span2">';
											if ($ringiStatus[$i]=="001") {
												echo '
												<form action="edit" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<button class="btn btn-small">Continue</button>
												</form>
											';
											}
											elseif ($ringiStatus[$i]=="002" && ($ringiaction[$i]=="001" or $ringiaction[$i]=="012")){
												echo '
												<form action="pattern3" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringi_number" value="'.$ringino[$i].'" id="ringi_number">
													<input type="hidden" name="status" value="'.$ringiStatus[$i].'" id="status">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Cancel</button>
												</form>
											';
											}
											else {
												echo '';
											}
											echo '
											</div>
											<div class="span2">
												<form action="application_details" method="post" accept-charset="utf-8">
													<input type="hidden" name="ringiNo" value="'.$ringino[$i].'" id="ringiNo">
													<input type="hidden" name="resourceflag" value="home" id="resourceflag">
													<button class="btn btn-small">Details</button>
												</form>
											</div>
										</div>
									</div>
								</div></div>';
							
						}
					}
					?>
					</div>
				</div>
			    </div>

<!--
				<a class="btn btn-small " href="/Ringi/apply">Create</a>				
				<a class="btn btn-small " href="/Ringi/edit">Edit</a>
				<br>
				<form action="pattern3" method="post" accept-charset="utf-8">
					<input type="text" name="ringi_number" value="1">
					<input type="text" name="status" value="002">
					<input type="text" name="resourceflag" value="home">
					<input type="submit" value="My Application &rarr;">
				</form>-->
			</div>
		</div>
	</div>
</div>
