<?php
if (isset($_GET['logout']))
{
    $_SESSION['isadmin']=0;
    echo "<div class=alert>";
    echo "You are now logged out!";
    echo "</div>";

}
if (isset($_POST['adminu']))
{
    $z = new mysqli($db_host, $user, $pass, $db_name);

    if ($z->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    mysqli_set_charset($z,"utf8");

    $auser=$z->escape_string($_POST['adminu']);
    $apass=$z->escape_string($_POST['adminp']);

    $zquery="Select * from Admin where Username='$auser' and Password='$apass' limit 1";
    $res = $z->query($zquery);

    if ($res->num_rows) {
        //echo "<div class=alert>";
        //echo "You are now an admin!";
        //echo "</div>";
        
        $_SESSION['isadmin']=1;
    }

    $z->close();

}


// glob admin session vars
$isadmin=0;
if (isset($_SESSION['isadmin']) && ($_SESSION['isadmin']==1))
    $isadmin=1;

if ($isadmin)
    require_once 'editArticle.php';
?>
