<?php
session_start();

if(isset($_POST['submit'])){
$data = file_get_contents('register.txt');
$user=htmlentities($_POST['user']);
$pass=htmlentities($_POST['pass']);
if(strpos($data, $user) !== FALSE && strpos($data, $pass) !== FALSE )
{
    $_SESSION['name'] = $user;
     //Doesn't really have anywhere to go 
    //so just redirects to same page with success message
    $_SESSION['success'] = 'Logged In';
     header( 'Location: login.php' ) ;
      return;
        
}
else
{    
    $_SESSION['error'] = 'Wrong.';
    header( 'Location: login.php' ) ;
     return;
}
}
?>

<h1>Please log in</h1>
<form method="post">
<p>Username:
<input type="text" name="user" size="40"></p>
<p>Password:
<input type="text" name="pass"></p>
<p><input type="submit" value="Sign In"/></p>
</form>
<?php


if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['success']);
}
?>