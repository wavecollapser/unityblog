<br><br>
New Category:<br>
<input type=text id=newCatVal value="" tabindex=5>
<input type=button onClick='admAddCategory();' value=Add tabindex=6> 
<input type=button onClick='admDelCategory();' value=Remove tabindex=6><br>
Categories for article <?php echo $ID; ?>:<br>
<select size=8 style="width: 150px;" name="Categories[]" id=admSel multiple="multiple">
<?php getCategories($ID); ?>
</select>
<br>
<br>
Multiple selections allowed, remove a category by deselecting it.
<br>
