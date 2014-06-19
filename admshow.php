<?php
/* show Refer ips on blog */
if (isset($_GET['admshow']))
{
    $k=getLog();
    echo "<center>";
    echo "<div id=cont class=admlog><div id=rednav>IP LIST</div><table class=admlog>";
    echo "<tr><th>Date</th><th>IP</th><th>Hostname</th><th>URL</th><th>Referer</th></tr>";
    $cIP="";
    $newip=1;
    foreach ($k as $l=>$w)
    {
        if (strstr($k[$l]['URL'],"%")) continue;
        //$fc=($newip)? "<font color=red>" : "<font color=black>";
        $fc=($newip)? "<font color=black>" : "<font color=black>";
        echo "<tr>";
        $newip=0;
        if ($cIP != $k[$l]['IP']) $newip=1;
        $cIP=$k[$l]['IP'];
        echo "<td>" . $fc;
        echo $k[$l]['Date'];
        echo "</font></td><td>" . $fc;
        echo $k[$l]['IP'];
        echo "</font></td><td>" . $fc;
        echo gethostbyaddr($k[$l]['IP']);
        echo "</td>";
        echo "<td>" . $fc;
        echo $k[$l]['URL'];
        echo "</font></td>";
        echo "<td>" . $fc;
        echo $k[$l]['Referer'];
        echo "</font></td>";
        echo "</tr>";
    }
    echo "</tr></table></div>";
    echo "</center>";
}

?>
