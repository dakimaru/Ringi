<!DOCTYPE html>
<html lang="en">
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
</head>
<body>
	<div class="wrapper">
		<div class="navbar navbar-static-top navbar-inverse">	<!-- replace with static/fixed -->
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/Ringi/main_menu"><strong><i>Home</i></strong></a>
					<ul class="nav">
						<li><a href="#"><strong>@Task</strong></a></li>
						<li><a href="#"><strong>#Report</strong></a></li>
					</ul>
					<ul class="nav pull-right">
						<form class="navbar-search pull-left">
							<input type="text" class="search-query" placeholder="Search">
						</form>
						<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#">
							<span class="caret"></span>
						</a>

						<li>
							<a>
								<?php
							$user = $this->Session->read('Auth.User');
							if(!empty($user)) {
								echo 'Logged in as: ', $user['username'], ' (', $user['title'], ')';
							}
							?></a>
						</li>

						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a tabindex="-1" href="#">Help</a></li>
							<li class="divider"></li>
							<li><a tabindex="-1" href="#">Settings</a></li>
							<li>
								<?php
							if(!empty($user)) {
								echo('<a tabindex="-1" href="/Ringi/users/logout">
								<form name="my_form" method="post" action="/Ringi/users/logout">
																     Logout
																     </form></a>');
							}
							else {
								echo('<a tabindex="-1" href="/Ringi/users/login">Login</a>');						
							}
							?>
						</li>						
					</ul>					
				</ul>
			</div>
		</div>
	</div>
	<div style="height:3em;"></div>
	<div class="containers">

		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div>
	<div class="push"></div>	
</div>
<footer>
	<div class="text-center"> &copy 2013 ENSPIREA, LLC</div>
</footer>
</body>
</html>