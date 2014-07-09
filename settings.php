<?php
$db_host        = "localhost";
$db_name        = "unityblog";
$user           = "unityblog";
$pass           = "your pc here :-)";


/* Useful for google, page title will be
 * Mr Anderson's blog - Got r00t?
 * instead of 
 * Mr Anderson's blog - System administration articles
 */
$realpagetitle=1;

/* Only show comments for article/category viewed,
 * no global comments */
$custompage_comments=1;

/* Show category menu to the right for Normal browsers (wont show in android/textmode) ? */
/* Dont show: less is more */
$showcategorymenu=0;
$showfeaturedmenu=0;
$rightmenufavcss="margin-top: 0px"; 
$rightmenucss="margin-top: 330px"; 

/* CATEGORIES MENU SETTINGS */
$group_cat_limit       = 16;

/* hide category that you are viewing currently from the category list */
$group_cat_hide_active = 1;

/* title for the blog pages, set to your name! */
$blogtitle="Mr Anderson's blog";
$bloghead="blog";
$blogurl="yourblogurl.com";
$subtitle="contents includes linux,programming," .
    "gaming,electronics,system administration,other random stuff";
//personal blog about a lot of stuff...


/* max number of articles to show on main page, reduces bandwidth
 * user can load any he choses by clicking anyway */
$MAXNUM=27;


/* IPs not to show in admin referer log, you can empty this array if you want */
$hideips=array(
    "81.161.190.59",
    "81.161.188.225",
    "180.76.6.%", // spiders all of these ips below
    "180.76.5.%", 
    "5.255.253.%",
    "37.58.100.%",
    "5.9.18.147",
    "192.34.109.230",
    "173.208.183.%",
    "148.251.23.%",
    "66.249.%.%", //googlebots
    "66.249.67.%", //google
    "66.249.69.%", //google
    "66.249.66.%", //googlebots
    "66.249.78.%" //googlebots
)


?>
