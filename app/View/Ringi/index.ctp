<html>
    <body>
    <h1>Current State Overview</h1>

    <p>Create Application
    <form method="post" action="apply" name="apply1"> 
    <input type="submit" value="Apply" class="btn btn-primary" ></input>
<button class="btn btn-primary">Submit</button>
    </form>
    </p>
   
    <p>Application Progress </p>
       <table class="table-striped">
        <tr>
        <td>Applicant</td>
        <td>Date</td>
        <td>1st Authorizer</td>
        <td>Date</td>
        <td>2nd Authorizer</td>
        <td>Date</td>
        <td>3rd Authorizer</td>
        <td>Date</td>
        <td>4th Authorizer</td>
        <td>Date</td>
        <td>5th Authorizer</td>
        <td>Date</td>
        <td>Final Authorizer</td>
        <td>Date</td>
        </tr>
        <?php $i =0; ?>
        <?php foreach ($auths as $auth): ?>
        <?php $i++; ?>
        <?php if($list_apply[$i-1] == 0) continue; ?>
        <tr>
        <td><?php echo $auth['AuthenticationData']['auth1']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date1']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth2']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date2']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth3']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date3']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth4']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date4']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth5']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date5']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth6']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date6']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth7']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date7']; ?></td>
        </tr>
        <?php endforeach; ?>
        </table>

        <p>Confirm Waiting List </p>
        <form method="post" action="confirm" name="confirm2"> 
        <table class="table-striped">
        <tr>
        <td>List Id</td>
        <td>Applicant</td>
        <td>Date</td>
        <td>1st Authorizer</td>
        <td>Date</td>
        <td>2nd Authorizer</td>
        <td>Date</td>
        <td>3rd Authorizer</td>
        <td>Date</td>
        <td>4th Authorizer</td>
        <td>Date</td>
        <td>5th Authorizer</td>
        <td>Date</td>
        <td>Final Authorizer</td>
        <td>Date</td>
        </tr>
        <?php $i =0; ?>
        <?php $list =array(); ?>
        <?php foreach ($auths as $auth): ?>
        <?php $i++; ?>
        <?php if($list_confirm[$i-1] == 0) continue; ?>
        <tr>
        <td><?php echo $auth['AuthenticationData']['id']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth1']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date1']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth2']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date2']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth3']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date3']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth4']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date4']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth5']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date5']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth6']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date6']; ?></td>
        <td><?php echo $auth['AuthenticationData']['auth7']; ?></td>
        <td><?php echo $auth['AuthenticationData']['date7']; ?></td>
        </tr>
        <?php array_push($list, $auth['AuthenticationData']['id']); ?>
        <?php endforeach; ?>
        </table>
        <select name="idlist2">
        <?php foreach($list as $id): ?>
        <option value=<?php echo $id ?> >ID: <?php echo $id; ?></option>
        <?php endforeach; ?>
        </select>
    <p>
    <input type="submit" value="confirm">
    </form>
    </p>
 
    <form method="post" action="logout" name="logout2">
    <input type="submit" value="Logout">
    </form>
    </p>
    </body>
</html>
