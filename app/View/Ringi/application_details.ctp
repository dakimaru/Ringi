
<div class="container">
    <h2 align="left">Root Info</h2><br>
    <form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="success">
			<td>No</td>
			<td>RingiName</td>
			<td>Project</td>
			<td>Applicant</td>
			<?php
                            for ($i = 1; $i < $count; $i ++){
                                echo "<td>Approver".$i."</td>";
                            }
                        ?>
		</tr>
                <tr>
                    <?php
							    if($count > 0){
							    echo '
					                    <td rowspan="3">'.$ringiNo.'</td>
					                    <td rowspan="3">'.$ringiName.'</td>
					                    <td rowspan="3">'.$project.'</td>';
					                    }
					                    for ($i = 0; $i < $count; $i ++){
					                        echo "<td>".$approverId[$i]."</td>";
					                    }
					                    ?>
                    
                </tr>
                <tr>
                    <?php
                        for ($i = 0; $i < $count; $i++){
                             echo "<td>".$ringiStatusName[$i]."</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <?php
                        for ($i = 0; $i < $count; $i++){
                            echo "<td>".$approveDate[$i]."</td>";
                        }
                    ?>
                </tr>
	</table>
    </form>
    
    <h2 align="left">History</h2><br>
    <form method="post" action="confirm" name="confirm2"> 
	<table class="table table-bordered table-hover">
		<tr class="success">
			<td>No</td>
			<td>Date</td>
                        <td>Department</td>
			<td>Title</td>
			<td>User</td>
			<td>Action</td>
			<td>Comment</td>
		</tr>
                <?php
                    for ($i = 0; $i < $count2; $i++){
                        echo "<tr>";
                        echo "<td>".$ringiSeq[$i]."</td>";
                        echo "<td>".$processDate[$i]."</td>";
                        echo "<td>".$department[$i]."</td>";
                        echo "<td>".$title[$i]."</td>";
                        echo "<td>".$processerId[$i]."</td>";
                        echo "<td>".$ringiActionName[$i]."</td>";
                        echo '<td class="comment">'.$comment[$i]."</td>";
                        echo "</tr>";
                    }
                ?>
                
	</table>
    </form>
    <p><a href="/Ringi/main_menu"class="btn btn-success">Back to Main Menu</a></p>
    
    
    
    
</div>