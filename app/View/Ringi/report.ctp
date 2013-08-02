<div class="container">
	<h2 align="left">Plan Fixed Asset Budget</h2><br>
	<form method="post" action="" name="report" id="report">
		<div align="center" class="well row-fluid">
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Year</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="year" value="<?php if(isset($yearCondition)) echo $yearCondition; ?>" id="year">
					</div>
				</fieldset>
			</div>
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Dept Code</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="deptCode" value="<?php if(isset($deptCondition)) echo $deptCondition; ?>" id="deptCode">
					</div>
				</fieldset>
			</div>
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Line Code</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="lineCode" value="<?php if(isset($lineCondition)) echo $lineCondition; ?>" id="lineCode">
					</div>
				</fieldset>
			</div>
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Project</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="project" value="<?php if(isset($projCondition)) echo $projCondition; ?>" id="project">
					</div>
				</fieldset>
			</div>
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Account Code</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="acctCode" value="<?php if(isset($acctCondition)) echo $acctCondition; ?>" id="acctCode">
					</div>
				</fieldset>
			</div>
			<div style="padding-right:2%;" class="span2">
				<fieldset class="control-group">
					<label class="control-label">Purpose</label>
					<div class="controls">
						<input style="width:100%;" type="text" name="purpose" value="<?php if(isset($purpCondition)) echo $purpCondition; ?>" id="purpose">
					</div>
				</fieldset>
			</div>
		</div>
		<div align="center" class="well-small " >
			<button class="btn btn-success" onclick="Submit()" type="submit">Submit</button>
		</div>

		<div class="pre-scrollable">
		<table class="table table-bordered table-hover" style="margin:0; ">
			<tr class="success">
				<td rowspan="2">Year</td>
				<td rowspan="2">Dept Code</td>
				<td rowspan="2">Line Code</td>
				<td rowspan="2">Project</td>
				<td rowspan="2">Account Code</td>
				<td rowspan="2">Purpose</td>
				<td rowspan="2">something</td>
				<td colspan="12">Year 2012</td>			
			</tr>
			<tr class="success">
				<td>Jan</td>
				<td>Feb</td>
				<td>Mar</td>
				<td>Apr</td>
				<td>May</td>
				<td>Jun</td>
				<td>Jul</td>
				<td>Aug</td>
				<td>Sep</td>
				<td>Oct</td>
				<td>Nov</td>
				<td>Dec</td>
			</tr>
			
				<?php
			if ($count > 0){
				for ($entry = 0; $entry < $count; $entry++){
					echo
						'
						<tr>
						<td rowspan="2">'.$year[$entry].'</td>
					<td rowspan="2">'.$department[$entry].'</td>
					<td rowspan="2">'.$linecd[$entry].'</td>
					<td rowspan="2">'.$project[$entry].'</td>
					<td rowspan="2">'.$accountno[$entry].'</td>
					<td rowspan="2">'.$purpose[$entry].'</td>
					<td>Budget</td>';
					for ($month = 0; $month < 12; $month++){
						echo'
							<td>'.$budget[$entry][$month].'</td>
						';
					}
					echo '</tr>';
					echo
						'
						<tr>
						<td>Actual</td>';
					for ($month = 0; $month < 12; $month++){
						echo'
							<td>'.$application[$entry][$month].'</td>
						';
					}
					echo '</tr>';
					;
				}
			}
			?>	
		</tbody>
	</table>
</div>
    <p><input type="submit" onclick="Export()" value="Export"></p>
</form>


</div>


<script type="text/javascript" charset="utf-8">

function Export()
{
 document.report.action ="export";

}

function Submit()
{
document.report.action = "report";

}

</script>
