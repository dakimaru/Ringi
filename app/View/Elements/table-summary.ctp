<h2 align="center">Summary</h2><br>
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
	<?php foreach ($auths as $auth): ?>
		<?php $i++; ?>

		<?php if($list_apply[$i-1] == 0) continue; ?>

		<?php if ($auth['Attribute']['xxxxxpassbackflag'] == FALSE && $auth['Attribute']['xxxxxrejectflag'] == FALSE ) {
			echo '<tr>';
			echo '<td>' . $auth['Attribute']['xxxxxtitle'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxapplicant'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxapplication_date'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxauth2'] . '</td>';
			echo '<td>' . $auth['Attribute']['xxxxxdate2'] . '</td>';
			echo '<td>' . $auth['Attribute']['total_asset'] . '</td>';
			echo '<td>' . '<a href="main_menu">Pending</a>' . '</td>';
			echo '</tr>';
		}?>
	<?php endforeach; ?>
</table>