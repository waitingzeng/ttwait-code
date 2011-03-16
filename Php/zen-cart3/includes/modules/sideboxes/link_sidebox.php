<?php
	
  require($template->get_template_dir('tpl_link_sidebox.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_link_sidebox.php');

  $title = BOX_HEADING_LINK_SIDEBOX;
  $left_corner = false;
  $right_corner = false;
  $right_arrow = false;
  $title_link = false;

   require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);

    

?>