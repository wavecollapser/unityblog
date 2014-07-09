<br>
<form method=post action=>
<div id=cont style="text-align:left;">
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
<textarea name=comment maxlength=300 cols=50 rows=5></textarea>
<input type=submit class=formbutton>
</form>
<span style="display:none" id=web2>
<br>
Note: If you enter your email it will NOT be shown in the comments page, but the blog owner will get an email about it
</span>
<br>
<br>

</div>
<div id=cont class=center>
<a name=acomment></a>
<h3>
Comments received:
</h3>
<table width=100% bgcolor=white>
<tr><td>
<br>
<?php

if (isset($_GET['delComment']))
{
    $w = new mysqli($db_host, $user, $pass, $db_name);

    if ($w->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    mysqli_set_charset($w,"utf8");
    $delid=$w->escape_string($_GET['delComment']);
    deleteComment($delid);
}


$m = new mysqli($db_host, $user, $pass, $db_name);

if ($m->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
mysqli_set_charset($m,"utf8");
$artCommentStr="";
/* If enabled, only show comments relevant for current
 * article or category viewed */
if ($custompage_comments)
{
    $tmp1="";$tmp2="";$tmp3="";
    if (isset($_GET['ID']))
        $tmp1=$m->escape_string(strip_tags($_GET['ID']));
    if (isset($_GET['custPageID']))
        $tmp2=$m->escape_string(strip_tags($_GET['custPageID']));
    if (isset($_GET['catName']))
        $tmp3=$m->escape_string(strip_tags($_GET['catName']));
    if (isset($_GET['catID']))
        $tmp3=$m->escape_string(strip_tags($_GET['catID']));

    if (strlen($tmp3))
        $artCommentStr="WHERE Qrystr_catID='$tmp3'";
    if (strlen($tmp1) && strlen($tmp3))
        $artCommentStr="WHERE Qrystr_articleID='$tmp1' AND Qrystr_catID='$tmp3'";
    if (strlen($tmp2) && strlen($tmp3))
        $artCommentStr="WHERE Qrystr_custsiteID='$tmp2' AND Qrystr_catID='$tmp3'";
    if (strlen($tmp1) && strlen($tmp2) && strlen($tmp3))
        $artCommentStr="WHERE Qrystr_custsiteID='$tmp2' AND Qrystr_articleID='$tmp1' AND Qrystr_catID='$tmp3'";
    if (strlen($tmp1) && strlen($tmp2))
        $artCommentStr="WHERE Qrystr_custsiteID='$tmp2' AND Qrystr_articleID='$tmp1'";
    if (strlen($tmp1) && !strlen($tmp2))
        $artCommentStr="WHERE Qrystr_articleID='$tmp1'";
    if (strlen($tmp2) && !strlen($tmp1))
        $artCommentStr="WHERE Qrystr_custsiteID='$tmp2'";
}

$query="select * from Comments $artCommentStr ORDER BY ID ASC";
$res = $m->query($query);
if (!$res->num_rows)
{
echo "No comments received for this page/article.<br><br>";

}

$atext="";
while($q = mysqli_fetch_array($res)) {
    $nick   = $q['Nick'];
    $text   = ucfirst($q['Comment']);
    $web    = $q['Website'];
    $date   = $q['Date'];
    $cdate  = date_create($date);
    $date   = date_format($cdate,'Y-m-d');
    $ID     = $q['ID'];
    $IP     = $q['IP'];
    $webstr="";
    $text=str_replace("\\","",$text);
    $text=str_replace("\n","<br>",$text);
    $web =str_replace("@","-at-",$web);

    if ($isadmin)
    {
        $atext="<span class=adminctl>";
        if (strlen($q['IP']))
            $atext.="- " . $q['IP'];
        
        $tq=clean_querystring(NULL,1,$removeID=0);
        $atext.=" - [<a href=?" . $tq . "&delComment=" . $ID . "#acomment>Delete</a>]";
        $atext.=" - [<a href=?" . $tq . "&banIP=" . $IP . "#acomment>Ban</a>]";
        $atext.="</span>";
    }
    else
        $atext="";

    if (strlen($web))
        $webstr="- <span class=webstr>" . $web . "</span>";

    echo "<b class=commentheader>$nick - $date $webstr $atext</b><br>";
    echo "$text";
    echo "<br><br><br>";

}



$m->close();

?>
</td></tr>
</table>

</div>
