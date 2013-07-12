<form class="form-search">
	<div class="btn-group">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    Filter
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <!-- dropdown menu links -->
		  <li><a tabindex="-1" href="#">Action</a></li>
		  <li><a tabindex="-1" href="#">Another action</a></li>
		  <li><a tabindex="-1" href="#">Something else here</a></li>
		  <li class="divider"></li>
		  <li><a tabindex="-1" href="#">Separated link</a></li>
	  </ul>
	</div>
	
  <input type="text" class="input-medium search-query">
  <button type="submit" class="btn">Search</button>
</form>


<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Summary</a></li>
		<li><a href="#tab2" data-toggle="tab">In Progress</a></li>
		<li><a href="#tab3" data-toggle="tab">Passed Back</a></li>
		<li><a href="#tab4" data-toggle="tab">On Hold</a></li>
		<li><a href="#tab5" data-toggle="tab">Accepted</a></li>
		<li><a href="#tab6" data-toggle="tab">Rejected</a></li>
		<li><a href="#tab7" data-toggle="tab">Confirm</a></li>
		<li><a href="#tab8" data-toggle="tab">Menu</a></li>
	</ul>
	
	<div class="tab-content">
		
		<form method="post" action="apply" name="apply1"> 
			<button class="btn btn-primary">Create Application</button>
		</form>
		
		<div class="tab-pane active" id="tab1">
			<?php echo $this->element('table-summary'); ?>
		</div>

		<div class="tab-pane" id="tab2">
			<?php echo $this->element('table-progress'); ?>
		</div>

		<div class="tab-pane" id="tab3">
			<?php echo $this->element('table-passed'); ?>
		</div>

		<div class="tab-pane" id="tab4">
			<?php echo $this->element('table-hold'); ?>	
		</div>

		<div class="tab-pane" id="tab5">
			<?php echo $this->element('table-accepted'); ?>
		</div>

		<div class="tab-pane" id="tab6">
			<?php echo $this->element('table-rejected'); ?>
		</div>
		
		<div class="tab-pane" id="tab7">
			<?php echo $this->element('table-confirm'); ?>
		</div>
		
		<div class="tab-pane" id="tab8">
			<?php echo $this->element('menu-tableau'); ?>
		</div>
		
	</div>
</div>