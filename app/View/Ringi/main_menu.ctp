<h2 align="center">Admin Pannel</h2>
<div class="row-fluid">
	<div class="span1 offset1">
		<p><a href="/Ringi/setup" class="btn btn-primary" style="width:100%">Set Up</a></p><br>
	</div>
	<div class="span1 offset1">
		<p><a href="/Ringi/users/add" class="btn btn-primary" style="width:100%">Add User</a></p><br>
	</div>
	<div class="span1 offset1">
		<p><a href="./upload_layout" class="btn btn-primary" style="width:100%">Layouts</a></p><br>
	</div>
	<div class="span1 offset1">
		<p><a href="./change_privileges" class="btn btn-primary" style="width:100%">Privileges</a></p><br>
	</div>
	<div class="span1 offset1">
		<p><a href="./workflow" class="btn btn-primary" style="width:100%">Workflow</a></p><br>
	</div>
</div>
<hr>



<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Summary</a></li>
		<li><a href="#tab2" data-toggle="tab">In Progress</a></li>
		<li><a href="#tab3" data-toggle="tab">Passed Back</a></li>
		<li><a href="#tab4" data-toggle="tab">On Hold</a></li>
		<li><a href="#tab5" data-toggle="tab">Accepted</a></li>
		<li><a href="#tab6" data-toggle="tab">Rejected</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

<!-- ========================================= -->
<h2 align="center">Summary</h2>

<form method="post" action="apply" name="apply1"> 
	<button class="btn btn-primary">Create Application</button>
</form>

<h5>My Applications</h5>
<table class="table table-bordered table-hover">
	<tr class="success">
		<td></td>
		<td>Name</td>
		<td>Applicant</td>
		<td>Authorizer1</td>
		<td>Authorizer2</td>
		<td>Authorizer3</td>
		<td>Authorizer4</td>
		<td>Authorizer5</td>
		<td>FinAuthorizer</td>
	</tr>
	<?php $i =0; ?>
	<?php $j =1; ?>
	<?php foreach ($auths as $auth): ?>
		<?php $i++; ?>

		<?php if($list_apply[$i-1] == 0) continue; ?>

		<?php if ($auth['Attribute']['xxxxxpassbackflag'] == FALSE && $auth['Attribute']['xxxxxrejectflag'] == FALSE ) {

			echo '<tr>';
			echo '<td rowspan="2">'. $j . '</td>';
			echo '<td rowspan="2">' . $auth['Attribute']['xxxxxtitle'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth1'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth3'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth4'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth5'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth6'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth7'] . '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<td>' . $auth['Attribute']['xxxxxdate1'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate3'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate4'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate5'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate6'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate7'] . '</td>';
			echo '</tr>';

			$j++;

		}?>
	<?php endforeach; ?>
</table>

<h5>To be Confirmed</h5>
<form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="info">
			<td></td>
			<td>Name</td>
			<td>Applicant</td>
			<td>Authorizer1</td>
			<td>Authorizer2</td>
			<td>Authorizer3</td>
			<td>Authorizer4</td>
			<td>Authorizer5</td>
			<td>FinAuthorizer</td>
		</tr>
		<?php $i =0; ?>
		<?php $list =array(); ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>
			<?php if($list_confirm[$i-1] == 0) continue; ?>

			<?php if ($auth['Attribute']['xxxxxpassbackflag'] == FALSE && $auth['Attribute']['xxxxxrejectflag'] == FALSE &&$auth['Attribute']['xxxxxauth1'] != $username  ) {

				echo '<tr>';
				echo '<td rowspan="2">' . $auth['Attribute']['id'] . '</td>';
				echo '<td rowspan="2">' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth7'] . '</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td>' . $auth['Attribute']['xxxxxdate1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate7'] . '</td>';
				echo '</tr>';

				$j++;
				array_push($list, $auth['Attribute']['id']);

			}?>


		<?php endforeach; ?>
	</table>
	<?php if ($list!=NULL): ?>
		<select style="margin: 0px;" name="idlist2">
			<?php foreach($list as $id): ?>
				<option value=<?php echo $id ?> >ID: <?php echo $id; ?></option>
			<?php endforeach; ?>
		</select>
		<button class="btn" style="margin-left: 5px;">Process</button>
	<?php endif ?>

</form>


<h5>Passed Back Applications</h5>
<form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="warning">
			<td></td>
			<td>Name</td>
			<td>Applicant</td>
			<td>Authorizer1</td>
			<td>Authorizer2</td>
			<td>Authorizer3</td>
			<td>Authorizer4</td>
			<td>Authorizer5</td>
			<td>FinAuthorizer</td>
		</tr>
		<?php $i =0; ?>
		<?php $pass =array(); ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>

			<?php if ($auth['Attribute']['xxxxxpassbackflag'] == TRUE && $auth['Attribute']['xxxxxrejectflag'] == FALSE && $auth['Attribute']['xxxxxauth1'] == $username ) {

				echo '<tr>';
				echo '<td rowspan="2">' . $auth['Attribute']['id'] . '</td>';
				echo '<td rowspan="2">' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth7'] . '</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td>' . $auth['Attribute']['xxxxxdate1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate7'] . '</td>';
				echo '</tr>';

				$j++;

				array_push($pass, $auth['Attribute']['id']); 

			}?>


		<?php endforeach; ?>
	</table>

	<?php if ($pass!=NULL): ?>
		<select style="margin: 0px;" name="idlist2">
			<?php foreach($pass as $id): ?>
				<option value=<?php echo $id ?> >ID: <?php echo $id; ?></option>
			<?php endforeach; ?>
		</select>
		<button class="btn" style="margin-left: 5px;">Process</button>	
	<?php endif ?>
</form>


<h5>Rejected Applications</h5>
<form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="error">
			<td></td>
			<td>Name</td>
			<td>Applicant</td>
			<td>Authorizer1</td>
			<td>Authorizer2</td>
			<td>Authorizer3</td>
			<td>Authorizer4</td>
			<td>Authorizer5</td>
			<td>FinAuthorizer</td>
		</tr>
		<?php $i =0; ?>
		<?php $list =array(); ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>

			<?php if ($auth['Attribute']['xxxxxrejectflag'] == TRUE &&  $auth['Attribute']['xxxxxauth1'] == $username) {

				echo '<tr>';
				echo '<td rowspan="2">' . $auth['Attribute']['id'] . '</td>';
				echo '<td rowspan="2">' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth7'] . '</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td>' . $auth['Attribute']['xxxxxdate1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate7'] . '</td>';
				echo '</tr>';

				$j++;

				//array_push($list, $auth['Attribute']['id']);

			}?>


		<?php endforeach; ?>
	</table>

</form>
</div>

<!-- ========================================= -->

<div class="tab-pane" id="tab2">
	<h2 align="center">Applications in Process</h2>

	<form method="post" action="apply" name="apply1"> 
		<button class="btn btn-primary">Create Application</button>
	</form>

	<table class="table table-bordered table-hover">
		<tr class="success">
			<td>Name</td>
			<td>Application Date</td>
			<td>Authorizer1</td>
			<td>Authorizer2</td>
			<td>Authorizer3</td>
			<td>Authorizer4</td>
			<td>Authorizer5</td>
			<td>FinAuthorizer</td>
		</tr>
		<?php $i =0; ?>
		<?php $j =1; ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>

			<?php if($list_apply[$i-1] == 0) continue; ?>

			<?php if ($auth['Attribute']['xxxxxpassbackflag'] == FALSE && $auth['Attribute']['xxxxxrejectflag'] == FALSE ) {

				echo '<tr>';
				echo '<td rowspan="2">' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth7'] . '</td>';
				echo '</tr>';

				echo '<tr>';
				echo '<td>' . $auth['Attribute']['xxxxxdate1'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate3'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate4'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate5'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate6'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate7'] . '</td>';
				echo '</tr>';

				$j++;

			}?>
		<?php endforeach; ?>
	</table>

</div>



<!-- ========================================= -->

<div class="tab-pane" id="tab3">


	<div>
		<h2 align="center">Main Menu</h2>
		<br>
		<div class="row-fluid">
			<div class="offset2 span2">
				<p><a href="./apply" class="btn btn-primary" style="width:100%">Apply</p></a><br>

				<p><a href="./processed" class="btn btn-inverse" style="width:100%">Processed</a></p><br>

				<p><a href="./confirm_applications" class="btn btn-inverse" style="width:100%">Confirm Applications</a></p><br>

				<p><a href="./pending" class="btn btn-inverse" style="width:100%">Pending</a></p><br>

				<p><a href="./passed_back" class="btn btn-inverse" style="width:100%">Passed Back</a></p><br>

			</div>
			<div class="offset3 span2">
				<p><a href="./accepted" class="btn btn-success" style="width:100%">Accepted</a></p><br>

				<p><a href="./rejected" class="btn btn-danger" style="width:100%">Rejected</a></p><br>

				<p><a href="./database_log" class="btn btn-warning" style="width:100%">Application History</a></p><br>

				<p><a href="./support" class="btn btn-inverse" style="width:100%">Support</a></p><br>

				<p><a href="./credit" class="btn btn-inverse" style="width:100%">Credit</a></p><br>


			</div>
		</div>
	</div>




</div>

<!-- ========================================= -->

<div class="tab-pane" id="tab4">
	<h1 align="center">Pending Applications</h1>
</div>

<!-- ========================================= -->

<div class="tab-pane" id="tab5">
	<h1 align="center">Accepted Applications</h1>
</div>

<!-- ========================================= -->

<div class="tab-pane" id="tab6">
	<h1 align="center">Rejected Applications</h1>
</div>

<!-- ========================================= -->
</div>
</div>




