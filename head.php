<?php

if (isset($_GET['catName']))
    $extra="- " . strip_tags($_GET['catName']) . " articles";
else if (isset($_GET['catID']))
    $extra="- " . getCatbyID(strip_tags($_GET['catID'])) . " articles";
else if (isset($_GET['listFiles']))
    $extra="- Files";
else if (isset($_GET['listCategories']))
    $extra="- Categories";
else if (isset($_GET['sitemap']))
    $extra="- Sitemap";
else
    $extra="";

?>
<head>
<meta content="width=device-width" name="viewport" />
<link rel="shortcut icon" href="img/blog/blog-icon.png">
<link rel="stylesheet" type="text/css" href="<?php echo "css/$CSSFILE"; ?>">
<link rel="stylesheet" type="text/css" href="lightbox.css">
<link rel="stylesheet" type="text/css" href="screen.css">
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/lightbox.min.js"></script>
<script src="js/blog.js"></script>
<script src="js/hammer.js"></script>

<title><?php echo $blogtitle;?> <?php echo $extra;?></title>




<script type="text/javascript">

function getcss(cssfile)
{
    loadcss = document.createElement('link')
    loadcss.setAttribute("rel", "stylesheet")
    loadcss.setAttribute("type", "text/css")
    loadcss.setAttribute("href", cssfile)
    document.getElementsByTagName("head")[0].appendChild(loadcss)
}
function admAddCategory()
{
    var val = $('#newCatVal').val();
    if (val != "") {
        $('#admSel').append('<option value=\"' + val + '\" selected>' + val + '</option>');
    }
    $('#newCatVal').val('').focus();

    admAddCategory.count+=1;
}
function admDelCategory()
{
    $("#admSel option:selected").remove();
}
admAddCategory.count=1000;

//if(screen.width >= '1280' || screen.height >= '900')
//{
//    getcss('css/style-nobg.css')
//    document.write('<div class=alert>Warn: Your browser res is not supported, everything might not look right</div>');
//}
//
//$(this).children('#cont_title.adminHiddenMenu').hide();



</script>
</head>
