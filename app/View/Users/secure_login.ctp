<?php
include("authenticate.ctp");
 
// check to see if user is logging out
if(isset($_GET['out'])) {
    // destroy session
    session_unset();
    $_SESSION = array();
    unset($_SESSION['user'],$_SESSION['access']);
    session_destroy();
}
 
// check to see if login form has been submitted
if(isset($_POST['userLogin'])){
    // run information through authenticator
    if(authenticate($_POST['userLogin'],$_POST['userPassword']))
    {
        // authentication passed
        $this->redirect(array('controller' => 'Ringi', 'action' => 'overview'));
        die();
    } else {
        // authentication failed
        $error = 1;
    }
}
 
// output error to user
if (isset($error)) echo "Login failed: Incorrect user name, password, or rights<br />";
 
// output logout success
if (isset($_GET['out'])) echo "Logout successful<br />";
?>

<form method="post" action="secure_login">
    User: <input type="text" name="userLogin" /><br />
    Password: <input type="password" name="userPassword" /><br />
    <input type="submit" name="submit" value="Submit" />
</form>

<form method="get" action="login">
    <input type="submit" name="out" value="Logout" />
</form>
