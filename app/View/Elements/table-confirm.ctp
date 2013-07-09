<h2 align="center">Confirm Applications</h2><br>
<form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="info">
			<td></td>
			<td>Project Name</td>
			<td>Applicant Name</td>
			<td>Application Date</td>
			<td>Approver</td>
			<td>Approval Date</td>
			<td>Requested Amount</td>
			<td>Status</td>
		</tr>
		<?php $i =0; ?>
		<?php $list =array(); ?>
		<?php foreach ($auths as $auth): ?>
			<?php $i++; ?>
			<?php if($list_confirm[$i-1] == 0) continue; ?>

			<?php if ($auth['Attribute']['xxxxxpassbackflag'] == FALSE && $auth['Attribute']['xxxxxrejectflag'] == FALSE &&$auth['Attribute']['xxxxxapplicant'] != $username  ) {

				echo '<tr>';
				echo '<td rowspan="">' . $auth['Attribute']['id'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxtitle'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxapplicant'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxapplication_date'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
				echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
				echo '<td>' . $auth['Attribute']['total_asset'] . '</td>';
				echo '<td>' . '<a href="application_details">Details</a>' . '</td>';
				echo '</tr>';

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