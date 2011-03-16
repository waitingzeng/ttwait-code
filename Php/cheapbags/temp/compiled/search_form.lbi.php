 <ul class="searchbox blank">
  <li class="Search f_l">
 
   <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
	  <span class="WhiteKey">Search</span>
   <select name="category" id="category" style="position: relative; _top:3px;" class="InBorder">
      <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
      <?php echo $this->_var['category_list']; ?>
    </select>
   <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="InBorder" size="20" style="position: relative; _top:3px;"/> 
   <input name="imageField" type="submit" value=" " class="go"  /> 
  <a href="search.php?act=advanced_search"><span class="ad"><?php echo $this->_var['lang']['advanced_search']; ?></span></a>
   </form>
	 </li>
   <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script>		
		<li class="Key f_r">
		 <?php if ($this->_var['searchkeywords']): ?>
    <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
    <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endif; ?> 
		</li>		
	</ul>	

  






















