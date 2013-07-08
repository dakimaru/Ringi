<h2 align="center">Accepted Applications</h2><br>

<form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="success">
			<td>Project Name</td>
			<td>Applicant Name</td>
			<td>Application Date</td>
			<td>Approver</td>
			<td>Approval Date</td>
			<td>Requested Amount</td>
			<td>Status</td>
		</tr>
		<?php $i =0; ?>
		<?php $pass =array(); ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>

			<?php if ($auth['Attribute']['xxxxxpassbackflag'] == TRUE && $auth['Attribute']['xxxxxrejectflag'] == FALSE && $auth['Attribute']['xxxxxauth1'] == $username ) {

				echo '<tr>';
				echo '<td>' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxapplicant'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxapplication_date'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['total_asset'] . '</td>';
				echo '<td>' . '<a href="main_menu">Pending</a>' . '</td>';
				echo '</tr>';

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