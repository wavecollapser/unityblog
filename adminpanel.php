<?php
/* Left admin panel of article
 * Add the admin features you want here..
 * */

/* Build the query string */
$nqstr=clean_querystring($qstr);

if ($isadmin)
            {
                echo "<font size=1px>";

                echo "[<a href=\"?" . $nqstr . "&getArticle&ID=" . $ID . "&edit="      . $ID . "#Art" . $ID . "\">Edit</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&disable="   . $ID . "#Art" . $ID . "\">Disable</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&mark="      . $ID . "#Art" . $ID . "\">Mark</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&delete="    . $ID . "#Art" . $ID . "\">Delete</a>]<br>";
                if (!$createNew)
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&topArt="    . $ID . "#Art" . $ID . "\">To Top</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&bottomArt=" . $ID . "#Art" . $ID . "\">To Bottom</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&mailArt="   . $ID . "#Art" . $ID . "\">Mail it</a>]<br>";
                echo "<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&pictureTag="   . $ID . "#Art" . $ID . "\">Picture tag</a>]<br>";
                echo "[<a href=\"?" . $nqstr . "&ID=" . $ID . "&scienceTag="   . $ID . "#Art" . $ID . "\">Science tag</a>]<br>";
                echo "</font>";
            }

                echo "<font size=1px>";
                echo "<br>";
                echo "[<a href=\"?" . $nqstr . "&getArticle&ID=" . $ID . "#Art" . $ID . "\">Share link</a>]<br>";
                echo "</font>";

?>
