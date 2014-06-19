<?php

$gotnum=0;
if (isset($_GET['num']))
{
    $tnum= strip_tags($_GET['num']);
    $gotnum=1;
}
else if (isset($_GET['ID']))
{
    $tnum= strip_tags($_GET['ID']);
    $gotnum=1;
}


if ($gotnum)
{
    require_once 'editArticle.php';
    $tnum=getPrevID($tnum);

    // mysql query for previous ID failed, set a failsafe option
    if ($tnum == -1)
    {
        if (strlen($tnum)>0)
            $tnum--;
    }
}

// no javascript if we specifically request nocss fuzz
if (isset($_GET['nocss']))
    $gotnum=0;

/* problems if we edit or delete , the javascript adds last row #Artnum and goes there afterwards */
$nofuzz=1;
if (isset($_GET['edit']) || isset($_GET['delete'])) $nofuzz=0;

if ($gotnum && $nofuzz && strlen($tnum)>0)
{
?>
<script type=text/javascript>
$(window).load(function(event)
{
    window.location.hash = "#Art<?php echo $tnum; ?>";
});
</script>
<?php
}
?>
