<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
    <input type="text" value="Keyword" name="s" id="s" onfocus="if (this.value != '') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Keyword';}"/>
    <input type="submit" id="searchsubmit" value="Search" />
</div>
</form>