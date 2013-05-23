<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('ringi');
	echo $this->Html->css('cake.generic');
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('bootstrap-responsive.min');
	echo $this->fetch('css');
	echo $this->Html->script('libs/jquery');
	echo $this->Html->script('libs/bootstrap.min');
	echo $this->fetch('meta');
	echo $this->fetch('script');
	?>
</head>
<body>
	<div class="wrapper">
		<div class="navbar navbar-static-top navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#"><strong><i>Enspirea</i></strong></a>
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
							echo 'Logged in as: ', $user['username'], ' (', $user['role'], ')';
						}
						?></a>
					</li>
					<li>
						<form method="post" action="logout" name="logout2">
							<button class="btn btn-danger">Logout</button>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">

		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
		<?php //echo $this->fetch('content'); ?>
	</div>
	<div class="push"></div>	
</div>
<footer>
	<div class="text-center"> &copy 2013 ENSPIREA, LLC</div>
</footer>
</body>
</html>