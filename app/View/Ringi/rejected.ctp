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