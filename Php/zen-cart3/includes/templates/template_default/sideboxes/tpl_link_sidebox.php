<?php
$links = array('Western Union' => 'http://www.westernunion.com',
	 'MoneyBookers' => 'http://www.moneybookers.com',
	 'MoneyGram' => 'http://www.moneygram.com',
	 'Bank Of China' => 'http://www.boc.cn/en/index.html',
	 'EMS' => 'http://www.ems.com.cn', 
	 'DHL' => 'http://www.dhl.com', 
	 'TNT' => 'http://www.tnt.com', 
	 'UPS' => 'http://www.ups.com');
$content = '';
foreach ($links as $name=>$link) {
	$content .= '<div class="sideBoxContent"><a href="'.$link.'" target="_blank"><img src="images/links/' . strtolower($name) .'.gif" alt="'.$name.'" title="'.$name.'" width="100" /></a></div>';
}
?>