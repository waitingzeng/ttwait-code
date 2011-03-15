<?php
	require('includes/application_top.php');
	if ($_POST['repair']) {
		$db->Execute("UPDATE " . TABLE_PRODUCTS . " SET products_price_retail=products_price*1.2 WHERE products_price_retail ='0' ");
		$products_price_retail_rows = mysql_affected_rows();
		
		$db->Execute("UPDATE " . TABLE_PRODUCTS . " SET products_price_sample=products_price*1.2 WHERE products_price_sample='0'");
		$products_price_sample_rows = mysql_affected_rows();
		
		$db->Execute("UPDATE " . TABLE_PRODUCTS . " p SET p.master_categories_id=(SELECT categories_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." pt WHERE pt.products_id=p.products_id LIMIT 1) WHERE master_categories_id='0'");
		$master_categories_id_rows = mysql_affected_rows();
		$repairSuccess = true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Products DB Repair - <?php echo TITLE;?></title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
  }
  // -->
</script>
<style type="text/css">
	#repairBox{
		margin:10px 15px;
	}
</style>
</head>

<body onload="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div id="repairBox">
	<h1>Products DB Repair</h1>
	<?php
	if ($repairSuccess) {
	?>
	<table cellpadding="5" cellspacing="5">
		<tr>
			<th><h2>Affected Rows</h2></th>
		</tr>
		<tr>
			<td align="right" width="120">products_price_retail: </td>
			<td><?php echo $products_price_retail_rows?></td>
		</tr>
		<tr>
			<td align="right">products_price_sample: </td>
			<td align="left"><?php echo $products_price_sample_rows?></td>
		</tr>
		<tr>
			<td align="right">master_categories_id: </td>
			<td align="left"><?php echo $master_categories_id_rows?></td>
		</tr>
	</table>
	<?php
	}
	?>
	<form action="" method="POST">
		<input type="hidden" name="repair" value="1" />
		<button type="submit"><b>Repair</b></button>
	</form>
</div>
</body>
</html>