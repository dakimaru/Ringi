<h2>Ringi Overview</h2>

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