<!DOCTYPE html>
	<?php $user = $this->Session->read('Auth.User');?>
<html lang="en" <?php if(empty($user)) echo 'style="min-height:720px;"';?>>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>

	<!-- include jquery before bootstrap to avoid error messages -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js">
	</script>

	<?php
	echo $this->Html->script('libs/jquery');
	echo $this->Html->meta('icon');

	echo $this->Html->css('cake.generic');
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('bootstrap-responsive.min');
	echo $this->Html->css('ringi');
	echo $this->fetch('css');
	echo $this->Html->script('libs/bootstrap.min');
	echo $this->fetch('meta');
	echo $this->fetch('script');
	
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="assets/css/bootstrap.css" rel="stylesheet">
</head>
<?php
		
if(!empty($user)) {
echo '		
<body>
	<div class="wrapper" style="background-image:url(/Ringi/app/webroot/img/backgrounds.png);">
		<div class="navbar navbar-static-top navbar-inverse">	<!-- replace with static/fixed -->
			<div class="navbar-inner">
				<div class="container">
					
					
					<div class="nav-collapse collapse" style="margin-top:8px;" >
						<ul class="nav" >
							<li ><a class="brand" href="/Ringi/main_menu"><strong><img class="" src="/Ringi/app/webroot/img/home_btn.png">Home</strong></a></li>
							<li ><a href="/Ringi/task"><strong><img class="" src="/Ringi/app/webroot/img/task.png">Task</strong></a></li>
							<li ><a href="/Ringi/other"><strong><img class="" src="/Ringi/app/webroot/img/other.png" >Other</strong></a></li>
							<li ><a href="/Ringi/report"><strong><img class="" src="/Ringi/app/webroot/img/report.png" >Report</strong></a></li>
						</ul>
					</div>
					<ul class="nav pull-right">
						<form class="navbar-search pull-left">
							<input type="text" class="search-query" placeholder="Search">
						</form>
						<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#">
							<img src="/Ringi/app/webroot/img/gear.jpg">
							<span class="caret"></span>
						</a>

						<li style="padding-top:10px;">
							<a >
							';
								echo $user['username'], ' (', $user['title'], ')';
							echo '</a>
						</li>

						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a tabindex="-1" href="#">Help</a></li>
							<li class="divider"></li>
							<li><a tabindex="-1" href="/Ringi/Users/user_setting">Settings</a></li>
							<li>';
							
								echo('<a tabindex="-1" href="/Ringi/users/logout">
								<form name="my_form" method="post" action="/Ringi/users/logout">
																     Logout
																     </form></a>');
							echo '
							</li>						
						</ul>
						<a class="create" style="display:inline;" href="/Ringi/apply">
							<strong><img style="padding-top: 0px;" src="/Ringi/app/webroot/img/create_small.png"></strong>
						</a>

					</ul>
					<button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse" style="float:left;">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
			</div>
		</div>
		
		<div class="container" style="padding:15px;background-color:rgba(255,255,255,0.3);">
			<div style="height:3em;"></div>';
			echo $this->Session->flash(); 
			echo $content_for_layout; echo'
		</div>'
;}
else{
	echo '		
<body style="background-color:#6AA9B0;background-size:142px 720px; background-repeat:repeat-x; background-image:url(/Ringi/app/webroot/img/login_back.jpg);">
	<div class="wrapper">';
	
			echo '<div class="container" style="background-image:url(/Ringi/app/webroot/img/login_test.jpg);width:0px;min-height:720px;min-width:1120px;">';
			echo $this->Session->flash();
			echo $content_for_layout;
			echo '</div>';
		}
		echo '
		<div class="push"></div>
	</div>
	';?>
<footer>
	<?php
	if(!empty($user)) {
	echo '
	<div class="text-center"> &copy 2013 ENSPIREA, LLC</div>';
	}
	
	?>
</footer>
</body>
</html>