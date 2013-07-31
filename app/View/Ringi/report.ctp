<div class="container">
    <h2 align="left">Plan Fixed Asset Budget</h2><br>
    <form method="post" action="confirm">
        <div class="pre-scrollable">
	<table class="table table-bordered table-hover">
		<tr class="success">
			<td rowspan="2">Year</td>
			<td rowspan="2">Dept Code</td>
			<td rowspan="2">Line Code</td>
			<td rowspan="2">Project</td>
                        <td rowspan="2">Account Code</td>
                        <td rowspan="2">Purpose</td>
                        <td rowspan="2"></td>
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
	</table>
        </div>
    </form>
</div>