

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
					<div class="span5 paddingTop rightBorder">
						<h4 href="#"><?php echo $name; ?></h4>
						<h5 href=#><?php echo $title; echo " ";echo $department; ?></h5>
					</div>
                                        <div class="span4 paddingTop">
						<a href="/Ringi/apply" class="btn">Create</a>
					</div>
				</div>
                                <div class="bottomBorder row-fluid">
                                    <div class="span4">
						<div sytle="verticalAlign:50%;">
							<h4><?php echo $appCount;?></h4>
							<p>Applications</p>
						</div>
				    </div>
                                    <div class="span4">
						<div sytle="verticalAlign:50%;">
							<h4><?php echo $accCount;?></h4>
							<p>Accepted</p>
						</div>
				    </div>
                                    <div class="span4">
						<div sytle="verticalAlign:50%;">
							<h4><?php echo $inProCount;?></h4>
							<p>InProgress</p>
						</div>
				    </div>
                                   
                                    
                                </div>
				
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
		<div class="span7">
			<div class="well">
				<div class="tabbable"> <!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1" data-toggle="tab">Summary</a></li>
						<li><a href="#tab2" data-toggle="tab">In Progress</a></li>
						<li><a href="#tab3" data-toggle="tab">Accepted</a></li>
						<li><a href="#tab4" data-toggle="tab">Rejeced</a></li>
						<li><a href="#tab5" data-toggle="tab">OnHold</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
						<?php
						
							for ($i = 0 ; $i < $applicationCount; $i++){
								echo '
								<div class="well">
									<div class="row-fluid">
										<div class="span2">
											<div>
											
												<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
											</div>
										</div>
										<div class="span10">
											<div class="row-fluid">
												<div class="span6">
													<p>Application Title:'.$ringiName[$i].'</p>
												</div>
												<div class="span6">
													<p>ApplicationID:'.$applicantId[$i].'</p>
												</div>
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
													if ($ringiStatus[$i] == '002'){
													 echo '<form action="pattern3" method="post" accept-charset="utf-8">
															<input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
															<input type="hidden" name="status" value="002">
															<input type="hidden" name="resourceflag" value="other">
															<button class="btn btn-small">Cancel</button>
														</form>';
													}
													elseif ($ringiStatus[$i] == '006'){
													echo '<form action="pattern3" method="post" accept-charset="utf-8">
															<input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
															<input type="hidden" name="status" value="006">
															<input type="hidden" name="resourceflag" value="other">
															<button class="btn btn-small">ReOpen</button>
														</form>';
													}
													else{
														echo '';
													}
													echo '
												</div>
												<div class="span2">
													<form action="application_details" method="post" accept-charset="utf-8">
														<input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
														<input type="hidden" name="resourceflag" value="other" id="resourceflag">
														<button class="btn btn-small">Detail</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>';
							}
						?>
						</div>
					<div class="tab-pane" id="tab2">
						<?php
					for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '002')
						{
						echo '
						<div class="well">
						<div class="row-fluid">
							<div class="span2">
								<div>
									<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
								</div>
							</div>
							<div class="span10">
								<div class="row-fluid">
									<div class="span6">
										<p>Application Title:'.$ringiName[$i].'</p>
									</div>
									<div class="span6">
										<p>ApplicationID:'.$applicantId[$i].'</p>
									</div>
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
                                                                if ($ringiStatus[$i] == '002'){
                                                                        echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                    <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                    <input type="hidden" name="status" value="002">
                                                                                    <input type="hidden" name="resourceflag" value="other">
                                                                                    <button class="btn btn-small">Cancel</button>
                                                                            </form>';
                                                                }
                                                                elseif ($ringiStatus[$i] == '006')
                                                                {
                                                                       echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                <input type="hidden" name="status" value="006">
                                                                                <input type="hidden" name="resourceflag" value="other">
                                                                                <button class="btn btn-small">ReOpen</button>
                                                                            </form>';
                                                                }
                                                                else{
                                                                    echo '';
                                                                }
                                                                echo '
								</div>
                                                                <div class="span2">
                                                                        <form action="application_details" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
										<input type="hidden" name="resourceflag" value="other" id="resourceflag">
                                                                                <button class="btn btn-small">Detail</button>
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
					<?php
					for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '003') {
						echo '
						<div class="well">
						<div class="row-fluid">
							<div class="span2">
								<div>
									<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
								</div>
							</div>
							<div class="span10">
								<div class="row-fluid">
									<div class="span6">
										<p>Application Title:'.$ringiName[$i].'</p>
									</div>
									<div class="span6">
										<p>ApplicationID:'.$applicantId[$i].'</p>
									</div>
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
                                                                if ($ringiStatus[$i] == '002'){
                                                                        echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                    <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                    <input type="hidden" name="status" value="002">
                                                                                    <input type="hidden" name="resourceflag" value="other">
                                                                                    <button class="btn btn-small">Cancel</button>
                                                                            </form>';
                                                                }
                                                                elseif ($ringiStatus[$i] == '006')
                                                                {
                                                                       echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                <input type="hidden" name="status" value="006">
                                                                                <input type="hidden" name="resourceflag" value="other">
                                                                                <button class="btn btn-small">ReOpen</button>
                                                                            </form>';
                                                                }
                                                                else{
                                                                    echo '';
                                                                }
                                                                echo '
								</div>
                                                                <div class="span2">
                                                                        <form action="application_details" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
										<input type="hidden" name="resourceflag" value="other" id="resourceflag">
                                                                                <button class="btn btn-small">Detail</button>
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
					<div class="tab-pane" id="tab4">
						<?php
					for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '004') {
						echo '
						<div class="well">
						<div class="row-fluid">
							<div class="span2">
								<div>
									<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
								</div>
							</div>
							<div class="span10">
								<div class="row-fluid">
									<div class="span6">
										<p>Application Title:'.$ringiName[$i].'</p>
									</div>
									<div class="span6">
										<p>ApplicationID:'.$applicantId[$i].'</p>
									</div>
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
                                                                if ($ringiStatus[$i] == '002'){
                                                                        echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                    <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                    <input type="hidden" name="status" value="002">
                                                                                    <input type="hidden" name="resourceflag" value="other">
                                                                                    <button class="btn btn-small">Cancel</button>
                                                                            </form>';
                                                                }
                                                                elseif ($ringiStatus[$i] == '006')
                                                                {
                                                                       echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                <input type="hidden" name="status" value="006">
                                                                                <input type="hidden" name="resourceflag" value="other">
                                                                                <button class="btn btn-small">ReOpen</button>
                                                                            </form>';
                                                                }
                                                                else{
                                                                    echo '';
                                                                }
                                                                echo '
								</div>
                                                                <div class="span2">
                                                                        <form action="application_details" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
										<input type="hidden" name="resourceflag" value="other" id="resourceflag">
                                                                                <button class="btn btn-small">Detail</button>
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
					<div class="tab-pane" id="tab5">
						<?php
					for ($i = 0 ; $i < $applicationCount; $i++){
						if ($ringiStatus[$i] == '006') {
						echo '
						<div class="well">
						<div class="row-fluid">
							<div class="span2">
								<div>
									<img src="/Ringi/app/webroot/img/enspirea.png" width="80">
								</div>
							</div>
							<div class="span10">
								<div class="row-fluid">
									<div class="span6">
										<p>Application Title:'.$ringiName[$i].'</p>
									</div>
									<div class="span6">
										<p>ApplicationID:'.$applicantId[$i].'</p>
									</div>
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
                                                                if ($ringiStatus[$i] == '002'){
                                                                        echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                    <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                    <input type="hidden" name="status" value="002">
                                                                                    <input type="hidden" name="resourceflag" value="other">
                                                                                    <button class="btn btn-small">Cancel</button>
                                                                            </form>';
                                                                }
                                                                elseif ($ringiStatus[$i] == '006')
                                                                {
                                                                       echo '<form action="pattern3" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                                <input type="hidden" name="status" value="006">
                                                                                <input type="hidden" name="resourceflag" value="other">
                                                                                <button class="btn btn-small">ReOpen</button>
                                                                            </form>';
                                                                }
                                                                else{
                                                                    echo '';
                                                                }
                                                                echo '
								</div>
                                                                <div class="span2">
                                                                        <form action="application_details" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
										<input type="hidden" name="resourceflag" value="other" id="resourceflag">
                                                                                <button class="btn btn-small">Detail</button>
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
				</div>
				
				</div>
			</div>
		</div>
	</div>
</div>
