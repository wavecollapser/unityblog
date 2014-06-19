function showDiv(objectID)
{
    var theElementStyle = document.getElementById(objectID);
    theElementStyle.style.display = "block";
}

function hidebox(objectID)
{
    var theElementStyle = document.getElementById(objectID);
    theElementStyle.style.display = "none";
    //startslide();
}

/* reset form fields after clicking on them when creating new article */
function reset1()
{
    //document.getElementById('newtitle').value="";
    $('.r1').val('')
}
function reset2()
{
    //document.getElementById('newtext').value="";
    $('.r2').val('')
}
