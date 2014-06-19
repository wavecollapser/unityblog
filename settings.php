<?php
$db_host        = "localhost";
$db_name        = "unityblog";
$user           = "unityblog";
$pass           = "h4TnJxvqw753m6ta";

/* Show category menu to the right for Normal browsers (wont show in android/textmode) ? */
/* Dont show: less is more */
$showcategorymenu=1;
$showfeaturedmenu=1;
$rightmenufavcss="margin-top: 0px"; 
$rightmenucss="margin-top: 300px"; 

/* CATEGORIES MENU SETTINGS */
$group_cat_limit       = 16;

/* hide category that you are viewing currently from the category list */
$group_cat_hide_active = 1;

/* title for the blog pages, set to your name! */
$blogtitle="rlogin.dk - Michael Olsen's blog";
$bloghead="blog";
$blogurl="rlogin.dk";
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
    "66.249.69.%", //google
    "66.249.66.%", //googlebots
    "66.249.78.%" //googlebots
)


?>
