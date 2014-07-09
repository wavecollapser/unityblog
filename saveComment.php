<?php
/*
 * Save the comment received as POST request into MySQL DB.
 */
$addcomment= (isset($_POST['nick']) && isset($_POST['comment'])) ? 1:0;

if ($addcomment && strstr($_POST['comment'],"http")) {
    echo "<div class=alert-error>";
    echo "Error:<br>";
    echo "Submit comment failed.<br>";
    echo "HTML and urls are not allowed in your posts.";
    echo "</div>";
/* Only show warn if we are not fetching category names, as they can have ' ' in them */
} else if (strstr($_SERVER['QUERY_STRING'],"%") && !isset($_GET['catName'])) {
    echo "<div class=alert-error>";
    echo "Error:<br>";
    echo "Your browser is outdated/incompatible<br>";
    echo "Please upgrade your browser, it uses ";
    echo "url encoding where it shouldn't, use Firefox or Internet explorer!";
    echo "<br><br>";
    echo "The site may still work in some places, use at your own risk..";
    echo "</div>";
} else if ($addcomment) {
    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    mysqli_set_charset($m,"utf8");

    $nick="";
    $web="";
    $comment="";

    if (isset($_POST['nick']))
        $nick=$_POST['nick'];
    if (isset($_POST['comment']))
        $comment=$_POST['comment'];
    if (isset($_POST['web']))
        $web=$_POST['web'];
    if (strlen($nick) > 50) die(); //we dont like spammers...
    if (strlen($comment) > 1000) die();

    if (strlen($nick) >1 && strlen($comment)>1) {
        $nick    =  $m->escape_string(strip_tags($nick));
        $comment =  $m->escape_string(strip_tags($comment));
        $web     =  $m->escape_string(strip_tags($web));
        //$date    =  date('Y-m-d H:m:s');
        //$date    =  NOW();
        $ip      =  $_SERVER['REMOTE_ADDR'];
        
        /* Save the page the user was on, into DB 
         * so we can find comments for each article later */
        if (isset($_GET['custPageID']))
            $a1 = "'" . $m->escape_string(
                strip_tags($_GET['custPageID'])) . "'";
        else
            $a1 = "NULL";

        if (isset($_GET['ID']))
            $a2 = "'" . $m->escape_string(
                strip_tags($_GET['ID'])) . "'";
        else
            $a2 = "NULL";

        if (isset($_GET['catName']))
            $a3 = "'" . $m->escape_string(
                strip_tags($_GET['catName'])) . "'";
        else
            $a3 = "NULL";

        if (isset($_GET['catID']))
            $a3 = "'" . $m->escape_string(
                strip_tags($_GET['catID'])) . "'";
        else
            $a3 = "NULL";

        if (!strlen($q1) && !strlen($q2))
        $query="INSERT INTO Comments " .
            "(`ID`,`Nick`,`Date`,`Website`,`IP`,`Comment`,".
            "`Qrystr_custsiteID`,`Qrystr_articleID`,`Qrystr_catID`)" .
            " VALUES " .
            "(NULL,'$nick',NOW(),'$web','$ip','$comment',$a1,$a2,$a3)";

        $res = $m->query($query);

        if ($res) {
            echo "<div class=alert>";
            echo "Your comment has been submitted, thanks.";
            echo "</div>";
        }

        $m->close();
    } else {
        echo "<div class=alert-error>";
        echo "Error:<br>";
        echo "Submit comment failed.<br>";
        echo "Please enter nick and comment, too short, try again..";
        echo "</div>";
    }

}

?>
