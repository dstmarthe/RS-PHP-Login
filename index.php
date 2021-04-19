<?php
session_start();

if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

if ( isset($_POST['user']) && isset($_POST['pass']))//This writes user registration into a json file
{ 
        $file = fopen("register.php",'a');
        $account = htmlentities($_POST['user'])." /n".
            htmlentities($_POST['pass']);
        fwrite($file, $account);
        fclose($file);
}

?>
<html>
<head><title>Dale Stmarthe</title></head><body>
<a href="login.php">Please log in</a>
echo<h1><strong>Register</strong></h1>
<form method="post">
<p>Username:
<input type="text" name="user" size="40"></p>
<p>Password:
<input type="text" name="pass"></p>
<p><input type="submit" value="Sign Up"/></p>

<p><button name="logout">logout</button></p>
</form>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
</html>