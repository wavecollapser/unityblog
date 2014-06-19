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

$query="select * from Comments order by ID ASC";
$m = new mysqli($db_host, $user, $pass, $db_name);

if ($m->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
mysqli_set_charset($m,"utf8");
$res = $m->query($query);

$atext="";
while($q = mysqli_fetch_array($res)) {
    $nick = $q['Nick'];
    $text = ucfirst($q['Comment']);
    $web  = $q['Website'];
    $date = $q['Date'];
    $ID   = $q['ID'];
    $IP   = $q['IP'];
    $webstr="";
    $text=str_replace("\\","",$text);
    $text=str_replace("\n","<br>",$text);
    $web =str_replace("@","-at-",$web);

    if ($isadmin)
    {
        $atext="<span class=adminctl>";
        if (strlen($q['IP']))
            $atext.="- " . $q['IP'];
        $atext.=" - [<a href=?delComment=" . $ID . "#acomment>Delete</a>]";
        $atext.=" - [<a href=?banIP=" . $IP . "#acomment>Ban</a>]";
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
