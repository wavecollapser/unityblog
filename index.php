<html>
<?php
/*
*  Unityblog - (c) 2014 Michael Ole Olsen <gnu@gmx.net>
*  minimal no fuzz blog
*  GPL v3.0
* 
*  SEE 'LICENSE' FOR THE FULL GPLv3 LICENSE or www.gnu.org
*  IF YOU MODIFY THIS PROGRAM YOU MUST INCLUDE THE SOURCE
*  WITH YOUR RELEASES
* 
*/

session_start();

include 'func.php';
include 'settings.php';
include 'editArticle.php';
include 'session.php';
include 'head.php';
include 'javascript.php';
include 'admin.php';

saveLog();

if (isset($_GET['logout']))
    unset($_SESSION['isadmin']);
if (isset($_GET['doBackup']))
{
    doBackup();
    echo "<div class=alert>";
    echo "Backup done!";
    echo "</div>";
}

if ($ADDCOMMENT && strstr($_POST['comment'],"http")) {
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
} else if ($ADDCOMMENT) {
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
        $nick=escapeshellcmd(strip_tags($nick));
        $comment=escapeshellcmd(strip_tags($comment));
        $web=escapeshellcmd(strip_tags($web));
        $date=date('Y-m-d h:m');
        $ip=$_SERVER['REMOTE_ADDR'];

        $query="INSERT INTO Comments VALUES (NULL,'$nick','$date','$web','$ip','$comment')";
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

<div align=center>
<div id=topadmin align=center onMouseOver="showDiv('navbar');return false;">
</div>

<?php $navbarstyle = (isset($_POST['adminu'])) ? "display:block;" : "display:none;"; ?>
<div id="navbar" class="transDiv" style="<?php echo $navbarstyle;?>">
<?php if (!$isadmin) { 
?>
    Admin login<br> 
<div align=right>
<form class=admin method=POST action="?">
<table>
<tr><td>User:</td><td><input name=adminu type=text size=9></td></tr>
<tr><td>Pass:</td><td><input type=password name=adminp type=text size=9></td></tr>
<tr><td></td><td align=right><input type=submit value=Login>
</td></tr>
</table>
</form>
<?php } else { ?>
<span class=red>[<font color=black> Admin options </font>]</span><br>
<a href="?createArticle=1">New article</a>
 - Edit Article
 - Delete Article
 - Edit Categories
 - <a href="?admshow">Referers</a>
 - Banlist
 - <a href="?doBackup">Do Backup</a>
 - <a href="?logout">Logout</a>
<br>
<br>
</span>

<?php }
if (strlen($extra) < 2)
    $extra=" " . $bloghead;
?>
</div>

</div>

<!--- end center ---></div>
<div id=contcont>

<div id=title>
<h3><a href="/"><span class=title><?php echo $blogurl; ?></span></a> <span class=title><?php echo $extra; ?></span></h3>
<div id=shadow-text><?php echo $subtitle;?></div>
</div>
<br>

<?php
if (!$textmode)
{
    makeTopbutton("?","Main page","emptyStr");
    if (!strlen($_SERVER['QUERY_STRING'])) 
        $fendstr="";
    else
        $fendstr="&";
    makeTopbutton("?listFiles" . $fendstr . clean_querystring() . $fendstr,"Files","listFiles"); 

    /* no need to show this button for Categories button page */
    if (!isset($_GET['listCategories']))
    {
        if (isset($_GET['sitemap'])) 
            makeTopbutton("?" . 
                clean_querystring(NULL,$keep_sitemap=0),
                "Normal view" . "<span class=arrdown></span> ");
        else 
            makeTopbutton("?sitemap" . $fendstr .
                clean_querystring(NULL,$keep_sitemap=1),
                "Overview" . "<span class=arrup></span> ");
    }
    else
            makeTopbutton("","&nbsp;");

    makeTopbutton("?sitemap&listCategories","Categories","listCategories");
}
else
{
    /* Support for textmode clients, links, lynx, wget, dilo etc.
     *  They don't like CSS buttons... Show text grouped 
     *  categories for them */
    echo "<br>";
    GetGroupedCategories();
}


if (isset($_GET['listCategories']))
    ButtonGetGroupedCategories();
if (isset($_GET['listFiles']))
    include 'files.php';
?>
<br>
<?php
if (!isset($_GET['admshow']))
    include 'showArticle.php';
else
    include 'admshow.php';

include 'comment.php';
?>
</body>
<br>
</div><!-- end contcont -->
<div id=footer align=center>
    Unityblog GPL v3.0 (c) 2014 Michael Olsen
    <br>
    less is more
</div>

<img src="http://hitwebcounter.com/counter/counter.php?page=5325625&style=0025&nbdigits=6&type=ip&initCount=0" border="0">
<br>
</html>
