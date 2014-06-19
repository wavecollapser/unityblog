<?php
$outf="comments.txt";
$textmode=0;
$android=0;

// replace - and _ in titles with " " (space)
function get_title($a)
{
    return str_replace("_"," ",str_replace("-"," ",$a));
}
function makeLink($string){

    if (strstr($string,"lightbox")) return $string;

    /*** make sure there is an http:// on all URLs ***/
    $string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
    /*** make all URLs links ***/
    $string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a href=\"$1\" target=\"_new\">$1</A>",$string);
    /*** make all emails hot links ***/
    $string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);

    return $string;
}


if (isset($_GET['sitemap']))
    $sitemap=1;
else
    $sitemap=0;
$ADDCOMMENT= (isset($_POST['nick']) && isset($_POST['comment'])) ? 1:0;
//$CSSFILE = ($sitemap) ? "style-nocss.css" : "style.css" ;
$CSSFILE = ($sitemap) ? "style.css" : "style.css" ;

//starts with sunday 1st day, (0) Sunday
$timestamp=time(0);
$tm = localtime($timestamp, TRUE);
$dow = $tm['tm_wday'];
/* weekends show a grean leaf background instead, relaxing */
if ($dow == 0 || $dow == 5 || $dow == 6)
    $CSSFILE = ($sitemap) ? "newbg1.css" : "newbg1.css" ;

// support android devices, no background for webpage there..
if (strstr($_SERVER['HTTP_USER_AGENT'],"Android"))
{
    $CSSFILE="android2.css";
    //$sitemap=1;
    $android=1;
}
// support links or other textmode clients, only sitemap for those..
if (strstr($_SERVER['HTTP_USER_AGENT'],"Links"))
{
    $CSSFILE="android2.css";
    $sitemap=1;
    $textmode=1;
}
// support links or other textmode clients, only sitemap for those..
if (strstr($_SERVER['HTTP_USER_AGENT'],"Lynx"))
{
    $CSSFILE="android2.css";
    $sitemap=1;
    $textmode=1;
}
// support links or other textmode clients, only sitemap for those..
if (strstr($_SERVER['HTTP_USER_AGENT'],"Wget"))
{
    $CSSFILE="android2.css";
    $sitemap=1;
    $textmode=1;
}

// to test textmode in real browser, looks good there too?
//$textmode=1;

function DEBUG() {
    $arr=(array)func_get_args();
    $arr=$arr[0];
    for ($i=1;$i<=10;$i++)
        print_r($arr);
}
function remove_querystring_nokey_var($url, $key) { 
    $url=str_replace("&" . $key,"",$url);
    $url=str_replace($key,"",$url);
    return $url; 
}
function remove_querystring_var($url, $key) { 
    $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
    // no key val replace fixme , ?createArticle i.e. , just the key
    //$url = preg_replace('/(.*)(?|&)' . $key . '(.*)/i', '$3', $url . '&'); 
    $url = substr($url, 0, -1); 
    return $url; 
}
function clean_querystring($url=NULL,$keep_sitemap=1)
{
    if ($url == NULL) $url= $_SERVER['QUERY_STRING'];
    $url=remove_querystring_var($url, "sortBy");
    $url=remove_querystring_var($url, "createArticle");
    $url=remove_querystring_var($url, "edit");
    $url=remove_querystring_var($url, "delete");
    $url=remove_querystring_var($url, "disable");
    $url=remove_querystring_var($url, "mark");
    $url=remove_querystring_var($url, "topArt");
    $url=remove_querystring_var($url, "bottomArt");
    $url=remove_querystring_var($url, "emailArt");
    $url=remove_querystring_nokey_var($url, "logout");
    $url=remove_querystring_nokey_var($url, "login");
    $url=remove_querystring_nokey_var($url, "doBackup");
    $url=remove_querystring_var($url, "delComment");
    $url=remove_querystring_var($url, "banIP");
    $url=remove_querystring_var($url, "ID");
    $url=remove_querystring_var($url, "num");
    $url=remove_querystring_nokey_var($url, "admshow");
    $url=remove_querystring_nokey_var($url,"listCategories");
    $url=remove_querystring_nokey_var($url,"listFiles");
    if (!$keep_sitemap)
        $url=remove_querystring_nokey_var($url,"sitemap");
    //$url=remove_querystring_nokey_var($url,"getCat");
    //$url=remove_querystring_var($url, "catName");
    //$url=remove_querystring_var($url, "catID");
    if (!isset($_GET['ID'])) 
        $url=remove_querystring_nokey_var($url,"getArticle");
    if (!isset($_GET['edit'])) 
        $url=remove_querystring_nokey_var($url,"getArticle");
    $url=str_replace("?&","?",$url);
    $url=str_replace("&?","&",$url);
    if (substr($url,0,1) == "&")
        $url=substr($url,1);

    return $url;

}
/* Make a files link on main page, for 'files category' */
function makeTopLink($url,$title,$extra="")
{

    echo "<a href=\"" . $url . "\">";
    echo "<div id=cont_title><table><tr><td>" .
        "<span class=redbold>" . $title . "</span></td></tr></table>";
    if (strlen($extra))
        echo "<br>" . $extra;
    echo "</div></a>";

}

/* Main page, Files, Overview, Categories top buttons
 * or any top button you want to make! */
function makeTopbutton($url,$title,$hlqry="")
{
    /* change button background if we are on the page 
     * (highlight button) */
    $xtra="";
    $qry= $_SERVER['QUERY_STRING'];

    // hlqry is the text we want to hl in query string $qry
    if (strlen($hlqry) && strstr($qry,$hlqry))
        $xtra="style=\"background-color: #ffffff\"";

    if (!strlen($qry) && $hlqry=="emptyStr")
        $xtra="style=\"background-color: #ffffff\"";

    echo "<a href=\"" . $url . "\">";
    echo "<div id=cont_titlebtn class=inline_button " . $xtra . ">";
    echo "<table class=a2><tr><td>";
    echo "<span class=button>" . $title . "</span>";
    echo "</td></tr></table>";
    echo "</div></a>";
    echo "&nbsp;";
}

/* Make a files link on main page, for 'files category' */
function makeSubcatLink($url,$title,$extra="",$center=0)
{
    // center if called to center it
    if ($center)
    {
        $xt="<center>";
        $xt2="</center>";
    }
    else
    {
        $xt=""; $xt2="";
    }
        

    echo "<a href=\"" . $url . "\">";
    echo "<div id=cont_title><table><tr><td>" . $xt .
        "<span class=redbold>" . $title . "</span>" . $xt2 . "</td></tr></table>";
    if (strlen($extra))
        echo "<br>" . $extra;
    echo "</div></a>";

}
if (isset($_GET['nocss']))
    $CSSFILE="nocss1.css";
?>
