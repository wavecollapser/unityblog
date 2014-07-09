<?php
/* This file contains your files category, customize as you want ! */

/* Change this array to your links you want to show in Files button click / main page */
$links=array(
    /* Title */      /* URL */
    "SVN"         => "http://svn.rlogin.dk",
    "Files"       => "http://files.rlogin.dk",
    "Images"      => "http://images.rlogin.dk",
    "Electronics" => "../gadgets",
    "Screenshots" => "../screenshots",
    "Physics"     => "../physics",
    "Comics"      => "../comics",
    "My budgies"  => "?sitemap&getArticle&ID=52#Art22",
    "Pictures of me"          => "?custPage&custPageID=44",
    "Funny childhood/school pics"    => "?custPage&custPageID=42",
    "About me"    => "?custPage&custPageID=33",
    "My geekcode" => "?custPage&custPageID=43",
    "Sitemap<br>
    <center><span class=black>
    comments? send me a mail: 
    <a class=email href=http://rlogin.dk/mio-pubkey.asc>my gpg keyid</a>
    </span></center>"
     => "?sitemap"
);

foreach ($links as $text=>$link)
{
    if ($textmode)
        echo "<a href=\"" . $link . "\">" . $text . "</a> - ";
    else
        makeSubcatLink($link,$text);
}


?>
