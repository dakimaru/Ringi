

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
				<div class="row-fluid">
                                        <div class="span12 paddingTop">
                                                <div sytle="verticalAlign:50%;">
							<h4><?php echo $taskLeft;?></h4>
							<p>TaskLeft</p>
						</div>
                                        </div>
				</div>
				<div class="row-fluid  paddingTop">
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
				<ul class="clearfix">
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
				<h4>Applications</h4>
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
									<p>Applicant Name:'.$applicantId[$i].'</p>
								</div>
								<div class="span2">
									<form action="pattern3" method="post" accept-charset="utf-8">
                                                                        <input type="hidden" name="ringi_number" value="'.$ringiNo[$i].'">
                                                                        <input type="hidden" name="status" value="002">
                                                                        <input type="hidden" name="resourceflag" value="task"  id="resourceflag">
                                                                        <button class="btn btn-small">Process</button>
                                                                        </form>
								</div>
                                                                <div class="span2">
									<form action="application_details" method="post" accept-charset="utf-8">
                                                                                <input type="hidden" name="ringiNo" value="'.$ringiNo[$i].'">
										<input type="hidden" name="resourceflag" value="task" id="resourceflag">
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
		</div>
	</div>
</div>