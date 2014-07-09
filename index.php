<html>
<?php
//  DEVELOPER MODE; KILL ALL OTHER CONNECTIONS
//if (!($_SERVER['REMOTE_ADDR'] == "81.161.188.225")) die();

/*
*  Unityblog - (c) 2014 Michael Ole Olsen <gnu@gmx.net>
*  minimal no fuzz blog
*  GPL v3.0
* 
* FIXME:
* CATEGORY COMMENTS.. insert categoryid in comments table
*
*SEEMS WE DONT GET THE RIGHT ID IN LINKS FOR PREV A NAME ARTICLE!!!!
* since it doesnt support javascript, the prev a id we send is wrong!!
*
* when pressing FILES in index.php main site, show a toggle ^  thing, then press again to untoggle menu
* 
* IMPORTANT FIXME(RELEASE CRITICAL):
* center bug on uncollapsed divs bottom of index.php
* // FIXME: catID instead of catName ,save traffic , dbspace etc, more professional - no logging
* in IE5.0+
* contents includes linux,programming,gaming,electronics,system administration,other random stuff
*
* EASY FIX:
* remove table stuff in files.php.... should be css!!
*
* 
*  TODO:
*  ajax/json expand each title from sites/ 
*     to not use much bandwidth!!!
* 
*     AJAX load sitemap title on click!!!! FIXME would be really nice
*     just display last 3-5 blog entries, then load those titles you click on
* 
*     and sort by tags too!
* 
*/

//print_r($_GET);

session_start();

include 'settings.php';
include 'func.php';
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


include 'saveComment.php';


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
<a href="?createArticle">New article</a>
 - <a href="?listCustPages">Custom Pages</a>
 - <a href="?listadmCategories">Categories</a>
<!--
 - Edit Article
 - Delete Article
 - Edit Categories
-->
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
<h3><a href="/"><span class=title><?php echo $blogurl; ?></span></a> <span class=title><?php echo $bloghead . " " .$extra2; ?></span></h3>
<div id=shadow-text><?php echo $subtitle;?></div>
</div>
<br>

<?php
if (!$textmode)
{

    iefix("<table><tr><td>");
    makeTopbutton("?","Main page","emptyStr");
    if (!strlen($_SERVER['QUERY_STRING'])) 
        $fendstr="";
    else
        $fendstr="&";

    iefix("</td><td>");
    makeTopbutton("?listFiles" . $fendstr . clean_querystring() . $fendstr,"Files","listFiles"); 

    iefix("</td><td>");

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

    iefix("</td><td>");
    makeTopbutton("?sitemap&listCategories","Categories","listCategories");
    iefix("</tr></table>");
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
if (isset($_GET['listAllCategories']))
    ButtonGetGroupedCategories($nolimit=1);
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
