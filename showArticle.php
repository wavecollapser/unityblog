<?php
/* include this file and @arr should contain files to show articles for */


$num=0;
$toggleprior=0;
$edit=0;
$editpreview_enable=0;
$showdate=1;
$prevyearStr="";
$IDInput="";
$ENABLE_SPACER=0;

if (isset($_GET['num']))
{
    $viewArticle=1;
    $IDInput = strip_tags($_GET['num']);
}
else if (isset($_GET['ID']))
{
    $IDInput = strip_tags($_GET['ID']);
    $viewArticle=1;
}
else
    $viewArticle=0;

$editArticle=0;
$createNew  = (isset($_GET['createArticle'])) ? 1:0;
if (isset($_POST['delArticle']) || isset($_GET['delete']))
   $delArticle=1;
else
   $delArticle=0;

$framenum=0;

if (isset($_POST['newtitle']) 
    && isset($_POST['newdate']) 
    && isset($_POST['newtext']))
{
    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    mysqli_set_charset($m,"utf8");
    $newtitle = $m->escape_string($_POST['newtitle']);
    $newdate  = $m->escape_string($_POST['newdate']);
    $newtext  = $m->escape_string($_POST['newtext']);
    $m->close();
}
/* Save Article changes to MySQL */
if (isset($_POST['createArticle']) 
    || isset($_POST['editArticle'])
    || isset($_POST['delArticle'])
    || isset($_POST['ArticleID'])
    || isset($_GET['delete']))
{
    if (isset($_POST['ArticleID']))
        $ID=$_POST['ArticleID'];

    if (isset($_POST['ArticleID']))
    {
        //print_r($_POST);
        
        flushCategories($ID);
        if (isset($_POST['Categories']))
        {
            $Categories=$_POST['Categories'];
            foreach ($Categories as $a) {
                newCategoryID($a);
                addCategory($ID,$a); 
            }
        }
    }
    if (isset($_GET['delete']))
        $ID=$_GET['delete'];

    /* Create Article */
    if (isset($_POST['createArticle']))
    {
        if (createArticle($newtitle,$newdate,$newtext))
            echo "Update Failed!";
    }
    /* Edit Article */
    else if (isset($_GET['edit']) || isset($_POST['editArticle']))
    {
        //DEBUG("edit article save, ID=" . $ID . "!!<br>");
        if (editArticle($ID,$newtitle,$newdate,$newtext))
            echo "Update Failed!";
    }

    /* Delete article */
    if (isset($_GET['delete']))
        $t=$_GET['delete'];
    if (isset($_POST['delArticle']))
        $t=$_POST['ArticleID'];
    if (isset($t) && ($t == $ID))
    {
        //DEBUG("DELETE article, ID=" . $ID . "!!<br>");
        if (deleteArticle($ID))
            echo "Update Failed!";

    }
}

if (isset($_GET['pictureTag']))
{
    $tagid=$_GET['pictureTag'];
    pictureTag($tagid);
    echo "<div class=alert>";
    echo "Tagged ID=" . $tagid . " as a picture!";
    echo "</div>";
}

$m = new mysqli($db_host, $user, $pass, $db_name);

if ($m->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
mysqli_set_charset($m,"utf8");

// Default Sort mode
$sortStr=" ORDER BY Date DESC";

if (isset($_GET['sortBy']))
{
    $p=$m->escape_string(strip_tags($_GET['sortBy']));
    if ($p == "byDate")
        $sortStr=" ORDER BY Date DESC";
    else if ($p == "byDateReverse")
        $sortStr=" ORDER BY Date ASC";
    else if ($p == "byCategory")
        $sortStr=" ORDER BY Category DESC";
    else if ($p == "byCategoryReverse")
        $sortStr=" ORDER BY Category ASC";
    else if ($p == "byLastEdit")
        $sortStr=" ORDER BY LastEdited";
    else if ($p == "byLastEditReverse")
        $sortStr=" ORDER BY LastEdited ASC";
    else if ($p == "byRating")
        $sortStr=" ORDER BY Rating";
    else if ($p == "byRatingReverse")
        $sortStr=" ORDER BY Rating ASC";
    else if ($p == "byRankDescending")
    {
        ;
    }
}

if (isset($_GET['catName']))
{
    /* show only tagged categories! */
    $catInput=$m->escape_string(strip_tags($_GET['catName']));
    $query="SELECT * FROM Articles f1 JOIN Categories f2 ON f1.id = f2.id WHERE f2.Category='" .
       $catInput . "' " . $sortStr;
}
else if (isset($_GET['catID']))
{
    /* show only tagged categories! */
    $catInput=$m->escape_string(strip_tags($_GET['catID']));
    $q1="SELECT Category FROM CategoryID WHERE ID='" . $catInput . "'";
    $res = $m->query($q1);
    if (!$res)
        $query="SELECT * from Articles " . $sortStr;
    else
    {
        $p = mysqli_fetch_array($res);
        $catInput=$p['Category'];
        $query="SELECT * FROM Articles f1 JOIN Categories f2 ON f1.id = f2.id WHERE f2.Category='" .
           $catInput . "' " . $sortStr;
    }
}
else
    $query="SELECT * from Articles " . $sortStr;

$res = $m->query($query);
if (!$res) die(mysql_error());

//print_r($query);
//print_r($res);

// category sort menu, only for real web browsers
// android doesnt have space for a right menu...
if ($showcategorymenu && !$textmode && !$android &&
!isset($_GET['listCategories']) &&
!isset($_GET['listFiles']) &&
!isset($_GET['sitemap']) 
)
{
?>
    <div id=rightmenu style="<?php echo $rightmenucss; ?>">
        <div id=rednav>
            Category menu
        </div>
    <br>
<?php
$a=array(
    "byDate",
    "byDateReverse",
    "byCategory",
    "byCategoryReverse",
    "byLastEdit",
    "byLastEditReverse"
    //"byRating",
    //"byRatingReverse"
);

echo "Categories on blog<br>";
getGroupedCategories("blue");
echo "<br>";
echo "<br>";
?>
<?php
echo "<b>Sort by</b>:<br>";
foreach ($a as $w)
{
    echo "- <a href=\"?" . clean_querystring(NULL) . "&sortBy=" . $w . "\">" . $w . "</a>";
    echo "<br>";
}
?>
<br>
<form method=post action=>
Any comments to the blog?<br>
Input your comment here, it will be shown below:
<br><br>
Name
<br> <input type=text name=nick width=30 maxlength=30> <a href="" onclick="$('#web').show(); $('#web2').show(); return false;" ><img src=img/blog/email-small.png></a>
<span style="display:none" id=web>
<br>
Website or Email
<br> <input type=text name=web width=30 maxlength=30>
</span>
<br>
Comment
<br>
<textarea name=comment maxlength=300 cols=25 rows=5></textarea>
<input type=submit class=formbutton>
</form>
<span style="display:none" id=web2>
<br>
Note: If you enter your email it will NOT be shown in the comments page, but the blog owner will get an email about it
</span>
</div>
<?php

} //end right menu

//Features links menu
if ($showfeaturedmenu && !$textmode && !$android &&
 !isset($_GET['listCategories']) &&
 !isset($_GET['listFiles']) &&
 !isset($_GET['sitemap']) 
)
{
?>
    <div id=rightmenufav style="<?php echo $rightmenufavcss; ?>">
        <div id=rednav>
           Featured Links 
        </div>
    <br>
        <?php include 'featuredLinks.php'; ?>
    </div>

<?php
} // end featured links menu

$otherPage=0;

/* Show custom page for a certain ID */
if (isset($_GET['custPage']))
{
    $otherPage=1;
    $ID=strip_tags($_GET['custPageID']);
    $arr = @array();
    $arr = getCustPage($ID);
    if ($arr != NULL)
    {
        $admStr = "";
        $text   = $arr['Text'];
        $text_arr   = explode("\n",$text);
        $tmptext="";
        foreach ($text_arr as $w)
            $tmptext.=   ucfirst($w) . "<br>";
        $text=$tmptext;
        $title  = $arr['Title'];
        $tdate       = ($arr['HideDate']) ? "" : $arr['Date'];
        $tlastupdate = ($arr['HideDate']) ? "" : $arr['LastUpdated'];

        $thedate="";
        if (strlen($tdate))
        {
            $thedate.="<span class=artdate>";
            $thedate.="Created: ".$tdate;
            $thedate.="<br>";
            $thedate.="Last Update: ".$tlastupdate;
            $thedate.="</span>";
        }

        /* Show edit link for admin user */
        if (isset($_SESSION['isadmin']))
        {
            $admStrEdit="<span class=smalladm>" .
                "[ <a href=?editCustPage&custPageID=" . $ID . ">" .
                "Edit</a> ]</span>";
            $admStr="<br><br>" . $admStrEdit;
            $title.=" " . $admStrEdit;
        }
        $date   = $arr['Date'];
        contentFrameCenter($text=$text . $thedate . $admStr,$title=$title);
    }
    else
        contentFrameCenter(
            "<b>Error: </b> No such custom page ID " . 
            " in mysql database", $title="Page error / 404"
        );
}

if (isset($_GET['newCustPage']))
{
    if (!isset($_SESSION['isadmin'])) admin_fail();
    $otherPage=1;
    $title     = "New cust page title here...";
    $text      = "Cust page text here..";
    $date      = NULL;
    $hide      = 1;
    $hideDate  = 1;

    editSiteForm(
        $qstr,$ID=NULL,$title,$text,$date,
        $hide,$hideDate,$newSite=1
    );

}
else if (isset($_GET['editCustPage']))
{
    if (!isset($_SESSION['isadmin'])) admin_fail();
    $otherPage=1;
    $ID=strip_tags($_GET['custPageID']);
    $arr=@array();
    $arr       = getCustPage($ID);
    if ($arr != NULL)
    {
        $title     = $arr['Title'];
        $text      = $arr['Text'];
        $date      = $arr['Date'];
        $hide      = $arr['Hide'];
        $hideDate  = $arr['HideDate'];

        editSiteForm(
            $qstr,$ID,$title,$text,$date,
            $hide,$hideDate,$newSite=0
        );
    }
    else
        contentFrameCenter(
            "<b>Error: </b> No such custom page ID " . 
            " in mysql database", $title="Page error / 404"
        );


}

if (isset($_POST['delSite']))
{
    $ID=strip_tags($_POST['SiteID']);
    echo "<div class=alert style=\"width: 520px;\">";
    if (delCustPage($ID)) 
        echo "Deleted custom site!";
    else
        echo "Error: failed to delete custom site!";
    echo "</div>";
}

/* Save changes on Custom page to DB */
else if (isset($_POST['editSite']))
{
    if (isset($_POST['SiteID']) && 
        isset($_POST['editsite_newtitle']) &&
        isset($_POST['editsite_newdate']) &&
        isset($_POST['editsite_newtext'])
    ) {
        /* Just escape, but allow html as it is for admin pages! */
        $ID         = escapestr($_POST['SiteID']);
        $date       = escapestr($_POST['editsite_newdate']);
        $title      = escapestr($_POST['editsite_newtitle']);
        $text       = escapestr($_POST['editsite_newtext']);
        $hide       = escapestr($_POST['editsite_hide']);
        $hideDate   = escapestr($_POST['editsite_hideDate']);

        $tmpvar     = escapestr($_POST['newSite']);
        if ($tmpvar == 1) $ID=NULL;

        saveCustPage($ID,$date,$title,$text,$hide,$hideDate);

        echo "<div class=alert style=\"width: 520px;\">";
        if ($ID != NULL)
            echo "Saved changes to custom page ID=" . $ID . " in DB!";
        else
            echo "Successfully created new custom page in database!";
        echo "</div>";
    } else {
        echo "<div class=alert>";
        echo "Error: Saving to custom page ID=" . $ID . " failed!!";
        echo "</div>";
    }

}


if (isset($_GET['listadmCategories']))
{
    if (!isset($_SESSION['isadmin'])) admin_fail();
    $otherPage=1;

    $arr = getadmCategories();
    if ($arr != NULL)
    {
        $lines=array();
        $i=0;
        $lines[$i++]="<center>".
            "[<a href=?newCustPage>New category</a>]</center>" . 
            "<br><br>";

        $lines[$i++]="<div id=custPagebar><table class=cPageadmtop><tr>" .
            "<td class=ID>ID</td><td class=ctitle>Title</td>" .
            "<td class=description>Description</td>" .
            "<td class=ID>Show</td>" .
            "<td class=ID>Count</td><td class=cAdm>&nbsp;</td></tr></table></div>";

    while($q = mysqli_fetch_array($arr))
    {
            $ID        = $q['ID'];
            $title     = $q['Category'];
            $text      = $q['Description'];
            $show      = $q['Show'];
            $count     = $q['Count'];
            
            $shorttitle = substr($title,0,25);

            $show = ($show) ? "<input type=checkbox checked>" :
                 "<input type=checkbox>" ;
            $hide=($show)? "NO" : "YES";
            $actls="" .
                //"<a href=?editCustPage&custPageID=" . 
                //$ID . ">[Edit]</a> " .
                //"<a href=?custPage&custPageID=" . $ID . ">[View]</a> [Del]";
                "";

            $lines[$i++]=
                "<div id=custPagebar><table class=cPageadm><tr>".
                "<td class=ID>"   . $ID .
                "</td><td class=ctitle><input type=text size=16 value=\""  . $shorttitle . "\">" .
                "</td><td class=description><input type=text size=16 value=\""  . $text . "\">" .
                "</td><td class=ID>"  . $show .
                "</td><td class=ID>"  . $count .
                "</td><td class=cAdm> " . $actls . 
                "</td></tr></table></div>";

        }
        $lines[$i++]="<br>Description will show in page title, and help better google indexing!";
        $lines[$i++]="<br><br>";
        contentFrameCenterArr($lines,"Categories admin");
    }
    else
    {
        contentFrameCenter(
            "<b>Error: </b> No such category ID " . 
            " in mysql database", $title="Page error / 404"
        );
    }

}
else if (isset($_GET['listCustPages']))
{
    if (!isset($_SESSION['isadmin'])) admin_fail();
    $otherPage=1;

    $arr = getCustPages();
    if ($arr != NULL)
    {
        $lines=array();
        $i=0;
        $lines[$i++]="<center>".
            "[<a href=?newCustPage>New custom page</a>]</center>" . 
            "<br><br>";

        $lines[$i++]="<div id=custPagebar><table class=cPageadmtop><tr>" .
            "<td>ID</td><td>Title</td><td>Hide</td>" .
            "<td>HideDate</td><td>&nbsp;</td></tr></table></div>";

        foreach ($arr as $k=>$v)
        {
            $ID        = $arr[$k]['ID'];
            $title     = $arr[$k]['Title'];
            $hide      = $arr[$k]['Hide'];
            $hide=($hide)? "YES" : "NO";
            $hidedate  = $arr[$k]['HideDate'];
            $hidedate=($hidedate)? "YES" : "NO";
            $text  = substr($arr[$k]['Text'],0,15) . "...";
            $actls="<a href=?editCustPage&custPageID=" . 
                $ID . ">[Edit]</a> " .
            "<a href=?custPage&custPageID=" . $ID . ">[View]</a>";

            $lines[$i++]=
                "<div id=custPagebar><table class=cPageadm><tr>".
                "<td>"   . $ID .
                "</td><td>"  . substr($title,0,9) . ".." .
                "</td><td>"  . $hide .
                "</td><td>"  . $hidedate .
                "</td><td> " . $actls . 
                "</td></tr></table></div>";

        }
        $lines[$i++]="<br><br>";
        contentFrameCenterArr($lines,"Custom Pages Administrator");
    }
    else
    {
        contentFrameCenter(
            "<b>Error: </b> No such custom page ID " . 
            " in mysql database", $title="Page error / 404"
        );
    }

}



$prevID=0;
while($createNew || ($q = mysqli_fetch_array($res))) {

    if ($otherPage) break;

    if ($createNew)
    {
        $ID       = NULL;
        $realdate = date("Y-m-d H:i:s");
        $date     = date("Y-m-d H:i:s");
        $title    = "New Article Title Here";
        $text     = "New article text here...";

        $num=$ID;

    }
    else
    {
        //FIXME: disabled sitemap posts... only show title in those
        //disabled yes/no in mysql table
        //FIXME: show yes/no in mysql table - to disable post temporarily
        
        $ID         = $q['ID'];
        $date       = $q['Date'];
        $realdate   = $q['Date'];
        $title      = $q['Title'];
        $text       = $q['Text'];

        if (!strlen($text)) continue;
        
        $num=$ID;
    }

    $toggle  = ($framenum >= $MAXNUM) ? 1 : 0;
    if ($sitemap) $toggle=1;
    $artnum = ($num>1)? $prevID: $num;

    /* We don't want to show previous long article
     * if untoggled, when uncollapsing divs  */
    if (!$toggleprior)
        $artnum=$num;

    /* Edit article */
    $edit=0; $editArticle=0;
    if (isset($_GET['edit']) && ($num == $_GET['edit']))
    {
        $edit=1;
        $editArticle=1;
    }

    $yearStr=date('Y',strtotime($date));

    /* full date for normal browsers, only show year for textmode clients */
    if (!$textmode)
        $dateStr=date('Y-m-d',strtotime($date));
    else
        $dateStr=date('Y',strtotime($date));

    /* don't show year each time for textmode clients, only on year change */
    if ($textmode && ($yearStr == $prevyearStr))
        $showdate=0;
    else
        $showdate=1;

    if ($textmode && ($prevyearStr=="" || $showdate))
    {
        echo "<br><b>".$yearStr.":</b>";
        $showdate=0;
    }

    if ($textmode) $showdate=0;
        

    if ($framenum > 0)
    {
        echo "<a name=Art" . $num . "></a>";
        if ($ENABLE_SPACER)
        {   
            if ($num == $MAXNUM) //experimental mio gnuaffedk
                if (!$sitemap && (!$toggleprior)) echo "<br>";
        }
        else
        {
            if (!$sitemap && (!$toggleprior)) echo "<br>";
        }
        
    }
    else
        $prevframenum=$num;

    if (!$toggle || ($viewArticle && ($num == $IDInput)))
    {
                        // show even in sitemap if we want just one article!
        if (! $sitemap || ($viewArticle && ($num == $IDInput) && isset($_GET['getArticle'])))
        {

            /* Spacer between articles */
            if ($ENABLE_SPACER) {
            if ($num>1)
            {
                echo "<div id=whitespace class=c1></div>";
                echo "<div id=c2>&nbsp;</div>";
                echo "<div id=whitespace class=c3></div>";
                echo "<div id=c2>&nbsp;</div>";
                echo "<div id=whitespace class=c1></div>";
            }
            }

            echo "<div id=cont name=Art". $num . "><table class=cont_inner bgcolor=white>";
            echo "<tr>";
            echo "<td valign=top class=padleft>";

            /* Title of article */
            if ($showdate)
                echo "<b>" . ucfirst($title) . "</b><br><font size=-1><i>$dateStr</i></font><br>";
            else
                echo "<b>" . ucfirst($title) . "</b>";

            include 'adminpanel.php';

            $arr=explode("\n",$text);

            echo "</td>\n";
            echo "<td class=padright>";

            /* contents of article */
            if (!$edit || ($edit && $editpreview_enable))
            {
                if (!$createNew)
                {
                    for ($i=0;$i<count($arr);$i++) 
                    {
                        $tstr=$arr[$i];
                        if (!strstr($tstr,"http")) //uppercase body text, but not urls
                            $tstr=ucfirst($arr[$i]);
                        if (!strstr($tstr,"<img") && !strstr($tstr,"<a href")) //img tags dont work!!
                            echo makeLink($tstr);
                        else
                            echo $tstr; // image files <img src= dont work in makeLink

                        echo "<br>";
                    }
                }
            }
            /* end contents */


            /* Create a new Article */
            if ($createNew)
            {
                newArticleForm($qstr,$title,$text="New article text here....",$realdate);
            } 
            if ($editArticle)
            {
                editArticleForm($qstr,$ID,$title,$text,$realdate);
            } 

            echo "</td></tr></table></div>\n";
        }
        else
        {
            $qstr=$_SERVER['QUERY_STRING'];
            $nqstr=clean_querystring($qstr);

            /* no ID in GET query it seems ... */

            if ($sitemap)
                echo "<a href=\"?" . $nqstr . "getArticle&ID=" . $num . "#Art" . $artnum . "\"><div id=cont_title><table><tr><td>";
            else
                echo "<a href=\"?" . $nqstr . "&getArticle&ID=" . $num . "#Art" . $artnum . "\"><div id=cont_title><table><tr><td>";

            if ($showdate)
                echo "<b>" . ucfirst($title) . "</b><br><font size=-1><i>$dateStr</i></font><br>";
            else
                echo "<b>" . ucfirst($title) . "</b>";
            echo "</td></table></div></a>";

        }
}
else
{
    $qstr=$_SERVER['QUERY_STRING'];
    $nqstr=clean_querystring($qstr);
    //toggle time... show toggle news sectons...
    if ($sitemap)
        echo "<a href=\"?" . $nqstr . "&getArticle&ID=" . $num . "#Art" . $artnum . "\"><div id=cont_title><table><tr><td>";
    else
        echo "<a href=\"?" . $nqstr . "&getArticle&ID=" . $num . "#Art" . $artnum . "\"><div id=cont_title><table><tr><td>";

    if ($showdate)
    echo "<b>" . ucfirst($title) . "</b> " . getAdminOpts($ID,$artnum,$sitemap) . "<br><font size=-1><i>$dateStr</i></font><br>";
    else
    echo "<b>" . ucfirst($title) . "</b> " . getAdminOpts($ID,$artnum,$sitemap);
    echo "</td></table></div></a>";

}

/* end each news article */

/* set each bars toggle status after displaying it */
$toggleprior= $toggle;

if ((! $toggleprior) && $toggle && (! $sitemap))
    echo "<br>";

$prevyearStr=$yearStr;

$prevframenum=$framenum;
$framenum++;

/* unset edit variables, IMPORTANT
 * so we dont keep editing all entries
 * really messed up the whole DB / all entries!*/
$createNew=0;
$editArticle=0; $edit=0;
$delArticle=0;
/* end edit-variable unset */

$prevID=$ID;
}

//FIXME ALWAYS PRINTS THIS, SOMEHOW
//if (is_numeric($IDInput) && $IDInput > $framenum)
//    echo "<div id=cont>No such article ID " . $IDInput . " found</div>";
//else
//    echo "<div id=cont>Invalid article ID " . $IDInput . "!</div>";

$m->close();
?>
