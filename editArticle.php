<?php

function admin_fail()
{
    unset($_SESSION['isadmin']);
    echo "<div class=alert-error>";
    echo "<center>";
    echo "Error: admin auth failure, not logged in!<br>";
    echo "Attempt has been logged";
    echo "</center>";
    echo "</div>";
    die();
}
function getLog()
{
    include 'settings.php';
    if (!isset($_SESSION['isadmin'])) admin_fail();

    $retval=0;
    $clIP  = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_REFERER']))
        $clRef = $_SERVER['HTTP_REFERER'];
    else
        $clRef = "";

    // don't show all ips, hide ips we in settings.php 
    // have chosen to hide from display
    $builtquery="WHERE '1'='1' ";
    foreach ($hideips as $w)
        $builtquery.=" AND NOT IP LIKE '" . $w . "'";

    $query="SELECT * FROM Log $builtquery ORDER BY DATE DESC LIMIT 250";
echo "<div id=cont>";
print_r($query);
echo "</div><br>";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) $retval=1;

    $id=0;
    $k=array();
    while($q = mysqli_fetch_array($res))
    {
        $date = $q['Date'];
        $ip   = $q['IP'];
        $url  = $q['URL'];
        $ref  = $q['Referer'];

        $k[$id]['Date']    = $date;
        $k[$id]['IP']      = $ip;
        $k[$id]['URL']     = $url;
        $k[$id]['Referer'] = $ref;

        $id++;
    }

    $m->close();

    return $k;
}
/* escape mysql string, return escaped string */
function escapestr($str) {
    include 'settings.php';

    $retval=0;
    $clIP  = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_REFERER']))
        $clRef = $_SERVER['HTTP_REFERER'];
    else
        $clRef = "";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");

    $escaped = $m->escape_string($str);
    $m->close();

return $escaped;

}
function saveLog()
{
    include 'settings.php';

    $retval=0;
    $clIP  = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_REFERER']))
        $clRef = $_SERVER['HTTP_REFERER'];
    else
        $clRef = "";

    $clIP=escapestr($clIP);
    $clURL=escapestr($_SERVER['REQUEST_URI']);
    $clRef=escapestr($clRef);
    $query="INSERT INTO Log VALUES(NOW(),'" . $clIP . "','" .
         $clURL . "','" . $clRef . "')";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) $retval=1;

    $m->close();

    return $retval;
}
function getPrevID($ID)
{
    include 'settings.php';
//SELECT a.*, @num := @num + 1 b from test a, (SELECT @num := 0) d;

    $retcode=1;
    $query="Select * FROM Articles ORDER BY DATE DESC";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) return -1;

    $previd=0;
    while($q = mysqli_fetch_array($res))
    {
        $rowid=$q['ID'];

        if ($rowid==$ID)
            break;

        $previd=$rowid;
    }

    $m->close();

    return $previd;
}

function ButtonGetGroupedCategories()
{
    include 'settings.php';

    $retcode=0;
    // top 15 most used categories are shown!!!!
    $limit = $group_cat_limit;

    /* if settings.php says we hide cats we view, hide it! */
    if ($group_cat_hide_active)
    {
        if (isset($_GET['catName']))
            $catname=$_GET['catName'];
        else
            $catname='0xdeadbeef';
        $tstr="WHERE Category != '" . $catname . "'";
    }
    else
        $tstr=" ";

    $query="SELECT Category,count(*) AS Count FROM Categories " .
        "$tstr " .
        "GROUP BY Category " .
        "ORDER BY Count DESC LIMIT " . $limit;

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) return 1;


    $qstr=$_SERVER['QUERY_STRING'];
    $nqstr=clean_querystring($qstr);
    while($q = mysqli_fetch_array($res))
    {
        $title= $q['Category'];
        $cnt  = $q['Count'];
        // GET CAT ID IF IT EXISTS!!
        $catID="SELECT ID FROM CategoryID " .
            "WHERE Category='" . $title . "' LIMIT 1";
        //put catid in a href string too... if it is there
        $catres  = $m->query($catID);
        $catid="";
        if ($catres)
        {
            $z = mysqli_fetch_array($catres);
            $catid=$z['ID'];
        }
        //END GET CATID TO QSTR
        if (isset($nqstr) && strlen($nqstr))
            $targstr="?" . $nqstr . "&getCat&catID=";
        else
            $targstr="?getCat&catID=";

        $targstr=remove_querystring_nokey_var($targstr,"sitemap&");
        $targstr=remove_querystring_nokey_var($targstr,"sitemap");

        echo "<a href=\"" . $targstr .
             $catid . "\"><div id=cont_title_gbutton><center><span class=redgroupedcats>" .
                 $title . "(" . $cnt . ")" . "</span></center></div></a>";
    }

    $m->close();

    return $retcode;
}
function getGroupedCategories($newcolor="")
{
    include 'settings.php';

    $retcode=0;
    // top 15 most used categories are shown!!!!
    $limit = $group_cat_limit;

    /* if settings.php says we hide cats we view, hide it! */
    if ($group_cat_hide_active)
    {
        if (isset($_GET['catName']))
            $catname=$_GET['catName'];
        else
            $catname='0xdeadbeef';
        $tstr="WHERE Category != '" . $catname . "'";
    }
    else
        $tstr=" ";

    $query="SELECT Category,count(*) AS Count FROM Categories " .
        "$tstr " .
        "GROUP BY Category " .
        "ORDER BY Count DESC LIMIT " . $limit;

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) return 1;


    $qstr=$_SERVER['QUERY_STRING'];
    $nqstr=clean_querystring($qstr);
    while($q = mysqli_fetch_array($res))
    {
        $title= $q['Category'];
        $cnt  = $q['Count'];
        // GET CAT ID IF IT EXISTS!!
        $catID="SELECT ID FROM CategoryID " .
            "WHERE Category='" . $title . "' LIMIT 1";
        //put catid in a href string too... if it is there
        $catres  = $m->query($catID);
        $catid="";
        if ($catres)
        {
            $z = mysqli_fetch_array($catres);
            $catid=$z['ID'];
        }
        //END GET CATID TO QSTR
        if (isset($nqstr) && strlen($nqstr))
            $targstr="?" . $nqstr . "&getCat&catID=";
        else
            $targstr="?getCat&catID=";

        if (strlen($newcolor))
            $colorstyle="color: " . $newcolor . ";";
        else
            $colorstyle="";

        echo "<a class=tagcat href=\"" . $targstr .
             $catid . "\" style=\"" . $colorstyle . "\">" . $title . "</a>(" . $cnt . ")" . " ";
    }

    $m->close();

    return $retcode;
}
/* Get all categories for an Article ID in the DB
 * only used in Admin mode, for editing article */
function getCategories($ID)
{
    include 'settings.php';
    // check user is an admin, else don't allow SQL insertion, return the function call
    if (!isset($_SESSION['isadmin'])) admin_fail();

    $retcode=0;
    $cat = ucfirst($category);
    $query="SELECT Category FROM Categories WHERE ID='" . $ID . "'";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) return 1;

    while($q = mysqli_fetch_array($res))
    {
        echo "<option value=\"" . $q['Category'] .
             "\" selected>" . $q['Category'] . "</option>";
        echo "\n";
    }

    $m->close();

    return $retcode;
}
function flushCategories($ID)
{
    include 'settings.php';
    // check user is an admin, else don't allow SQL insertion, return the function call
    if (!isset($_SESSION['isadmin'])) admin_fail();

    $retcode=1;
    $qrydel="DELETE FROM Categories WHERE ID='" . $ID . "'";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res2  = $m->query($qrydel);

    if ($res2) $retcode=0;

    $m->close();

    return $retcode;
}

/* Set Article's category as Picture */
function pictureTag($ID)
{
    if (!isset($_SESSION['isadmin'])) admin_fail();
    flushCategories($ID);
    addCategory($ID,"Pictures");

}
function addCategory($ID,$category)
{
    include 'settings.php';
    // check user is an admin, else don't allow SQL insertion, return the function call
    if (!isset($_SESSION['isadmin'])) admin_fail();

    // no need we delete all cats and add them again already!!
    //if (CategoryExists($ID,$category)) return 0;

    $retcode=1;
    $cat = ucfirst($category);
    $query="INSERT IGNORE INTO Categories(`ID`,`Category`) VALUES('" . 
        $ID . "','" . $cat . "')";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    if ($res) $retcode=0;

    $m->close();

    return $retcode;
}
function delCategory($ID,$category)
{
    include 'settings.php';

    $retcode=1;
    $query="DELETE FROM Categories where ID='" . 
        $ID . "' AND Category='" . $category . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    if ($res) $retcode=0;

    $m->close();

    return $retcode;
}
/* remove all category texts on an Article ID */
function clearArticleCategories($ID)
{
    include 'settings.php';

    $retcode=1;
    $query="DELETE FROM Categories where ID='" . 
        $ID . "'";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    if ($res) $retcode=0;

    $m->close();

    return $retcode;
}

function deleteComment($ID)
{
    include 'settings.php';

    $retcode=1;
    $query="Delete FROM Comments " .
           " WHERE ID='" . $ID . "' LIMIT 1";
    $bck  ="INSERT Comments_Old " .
           " SELECT * FROM Articles WHERE ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    //$res2 = $m->query($bck);
    $res  = $m->query($query);

    //if ($res->num_rows)
    if ($res)
        $retcode=0;

    $m->close();

    return $retcode;
}
function deleteArticle($ID)
{
    include 'settings.php';

    $retcode=1;
    $query="Delete FROM Articles " .
           " WHERE ID='" . $ID . "' LIMIT 1";
    $bck  ="INSERT Articles_Old " .
           " SELECT * FROM Articles WHERE ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res2 = $m->query($bck);
    $res  = $m->query($query);

    //if ($res->num_rows)
    if ($res)
        $retcode=0;

    $m->close();

    return $retcode;
}
function createArticle($title,$date,$text)
{
    include 'settings.php';
    $retcode=1;

    $query="INSERT INTO Articles (Title,Date,Text) VALUES(" .
           "'" . $title . "'," .
           "'" . $date  . "'," .
           "'" . $text  . "\n')";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res = $m->query($query);

    //if ($res->num_rows)
    if ($res)
        $retcode=0;

    $m->close();

    return $retcode;
}
function editArticle($ID,$title,$date,$text,$newid="")
{
    include 'settings.php';
    $retcode=1;
    if ($newid == "") $newid=$ID;

    $query="UPDATE Articles " .
           "SET Title='" . $title . "'," .
           "    Text='"  . $text  . "'," .
           "    Date='"  . $date  . "',"  .
           "    ID='"    . $newid . "'"  .
           " WHERE ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res = $m->query($query);

    if ($res)
        $retcode=0;

    $m->close();

    return $retcode;
}
function doBackup()
{
    include 'settings.php';

    $retcode=1;
    $bcktbl="Backup_" . date("YmdHis");
    $query = "CREATE TABLE IF NOT EXISTS `" . $bcktbl . "` (".
        "  `ID` bigint(20) NOT NULL AUTO_INCREMENT,".
        "  `Date` datetime NOT NULL,".
        "  `Title` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,".
        "  `Text` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,".
        "  `LastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,".
        "  PRIMARY KEY (`ID`)".
        ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;";

    $bck  ="INSERT " . $bcktbl . " " .
           " SELECT * FROM Articles";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    $res2 = $m->query($bck);

    //if ($res->num_rows)
    if ($res)
        $retcode=0;

    $m->close();

    return $retcode;
}
function sql_get_title($ID)
{
    include 'settings.php';

    $retcode=1;
    $query="SELECT Title FROM Articles " .
           " WHERE ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    //if ($res)
    //    $retcode=0;

    $q = mysqli_fetch_array($res);
    echo $q['Title'];

    $m->close();

    return $retcode;
}
/* Get category name by ID */
function getCatbyID($ID)
{
    include 'settings.php';

    $retcode=0;
    $query="SELECT Category FROM CategoryID WHERE ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);
    if (!$res) return "";

    if ($res->num_rows)
    {
        $q = mysqli_fetch_array($res);
        return $q['Category'];
    }

    $m->close();

    return "";
}
function CategoryExists($ID,$category)
{
    include 'settings.php';
    // check user is an admin, else don't allow SQL insertion, return the function call
    if (!isset($_SESSION['isadmin'])) admin_fail();

    $retcode=0;
    $cat = ucfirst($category);
    $query="SELECT ID FROM Categories WHERE Category='" . $cat . "' AND ID='" . $ID . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    if ($res->num_rows) $retcode=1;

    $m->close();

    return $retcode;
}
/* Create new category in DB if not exists */
function newCategoryID($category)
{
    include 'settings.php';
    // check user is an admin, else don't allow SQL insertion, return the function call
    if (!isset($_SESSION['isadmin'])) admin_fail();

    $retcode=0;
    $showCat=1; // show the category globally after creating it?
    $cat = ucfirst($category);
    $query="SELECT ID FROM CategoryID WHERE Category='" . $cat . "' LIMIT 1";

    $m = new mysqli($db_host, $user, $pass, $db_name);

    if ($m->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    mysqli_set_charset($m,"utf8");
    $res  = $m->query($query);

    if ($res->num_rows)
        $retcode=1;

    /* Didn't exist in DB, so we have to create it in CategoryID table */
    if (!$retcode)
    {
        $query="INSERT INTO CategoryID VALUES" . 
            "(NULL,'" . $cat . "','" . $showCat . "',NOW())";
        $res  = $m->query($query);

        if ($res)
        {
            //if ($res->num_rows)
            $retcode=1;
        }
    }

    $m->close();

    return $retcode;
}

function getAdminOpts($ID,$artnum,$isadmin,$sitemap=0)
{
    if (!isset($_SESSION['isadmin'])) return "";

    $qstr=$_SERVER['QUERY_STRING'];
    $nqstr=clean_querystring($qstr);

    $out="<span class=adminHiddenMenu>";

    // Edit
    $out.="<a href=\"?" . $nqstr .
        "&getArticle&ID=" . $ID .
        "&edit=" . $ID . "#Art" . $artnum . "\">Edit</a>";

    // Delete (with confirm Dialog)
    $ctext="Are you really sure you want to delete Article "  . $ID . " ?\\n";
    $ctext.="Article cannot be recovered easily!";
    $out.=" - <a onClick=\"return confirm('" . $ctext . "')\" href=\"?" . $nqstr .
        "&getArticle&ID=" . $ID .
        "&delete=" . $ID . "&confirmDelete#Art" . $artnum . "\">Delete</a>";

    // Mark Old
    $out.=" - <a href=\"?" . $nqstr .
        "&getArticle&ID=" . $ID .
        "&setOld=" . $ID . "#Art" . $artnum . "\">Mark Old</a>";

    $out.="</span>";

    return $out;
}

?>
