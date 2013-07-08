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
	echo $this->Html->css('ringi');
	echo $this->Html->css('cake.generic');
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('bootstrap-responsive.min');
	echo $this->fetch('css');
	echo $this->Html->script('libs/bootstrap.min');
	echo $this->fetch('meta');
	echo $this->fetch('script');
	?>

</head>
<body>
	<div class="wrapper">
		<div class="navbar navbar-static-top navbar-inverse">	<!-- replace with static/fixed -->
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/Ringi/main_menu"><strong><i>Enspirea</i></strong></a>
					<ul class="nav">
						<li class="active"><a href="#">Ringi</a></li>
						<li><a href="#">Jinji</a></li>
						<li><a href="#">Kyuryou</a></li>
					</ul>
					<ul class="nav pull-right">
						<?php $user = $this->Session->read('Auth.User'); ?>
						<li>
							<a><?php
							if(!empty($user)) {
							echo 'Logged in as: ', $user['username'], ' (', $user['title'], ')';
						}
						?></a>
					</li>
					<li>
						<?php
						if(!empty($user)) {
						echo('<form method="post" action="/Ringi/users/logout">
									<button class="btn btn-danger">Logout</button>');
							}
					else {
						echo('<form method="get" action="login">
									<button class="btn btn-danger">Login</button>');						
					}
							?>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div style="height:3em;"></div>
	<div class="containers" style="min-width:940px; padding:20px; ">

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