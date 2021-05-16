<?php
session_start();
if ( isset($_POST['cancel']) ) {
    header("Location: logout.php");
    return;
}
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


  
if(isset($_POST['submit'])){
$data = fopen("register.txt", "r");
$user= $_POST['user'];
$pass= $_POST['pass'];
$account = "$user $pass";

while(! feof($data)){
$key = fgets($data);
if (trim($key) == trim($account)){
    console_log($key);
    fclose($data);
            $_SESSION['name'] = $user;
           $_SESSION['success'] = 'Logged In';
           fseek($data,0);
            header( "Location: index.php" );
             return;
} 
elseif (feof($data) === true) {
    fseek($data,0);
    $_SESSION['error'] = 'Incorrect credentials.';
    header( "Location: login.php" );
     return;
} else {
    console_log($key);
    continue;
}

}

fclose($data);
}

if(isset($_POST['reset'])){
    $user= $_POST['user'];
$pass= $_POST['pass'];

    $replace = "$user $pass"."\n";

    $data = file("register.txt");
   
    $out = array();
   
    foreach($data as $line) {
        if(str_contains($line, $user)){
            $out[] = $replace;
            continue;
        }
        if(trim($line) != trim($replace)) {
            $out[] = $line;
        }
    }
   
    $fp = fopen("register.txt", "w+");
    flock($fp, LOCK_EX);
    foreach($out as $line) {
        fwrite($fp, $line);
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    $_SESSION['success'] = 'Password Reset';
     header( "Location: login.php" );
      return;
}
?>

<html>
<body>
<head><title>Log In</title></head>
<h1>Please log in</h1>
<p> If you would like to reset your password. Enter your new credentials and then press reset password.</p>
<form method="post">
<p>Username:
<input type="text" name="user" size="40"/></p>
<p>Password:
<input type="text" name="pass"/></p>
<p><input type="submit" value="Sign In" name="submit"/> <input type="submit" value="Cancel" name="cancel"/></p>
<p><input type="submit" name="reset" value="Reset Password"/></p>

</form>
<?php

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    
    unset($_SESSION['error']);
}
?>
</body>
</html>