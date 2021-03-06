<?php
#if(defined('LANGUAGE')){
#	include_once(LANGUAGE);
#}
function smarty_gettext($text){
	$LANGUAGE = array(
	'标题' => 'Title',
	'内容' => 'Content',
	'提交' => 'Submit',
	'修改' => 'Modify',
	'删除' => 'Delete',
	'搜索' => 'Search',
	'保存' => 'Add',
	'后台语言' => 'Language',
	'新增一个管理员' => 'Add A New Admin',
	'管理员' => 'Admin Name',
	'密&nbsp;码' => 'Password',
	'你确定要删除吗?' => 'Do you confirm to delete?',
	'模糊查找' => 'Find like',
	'用户名' => 'User Name',
	'名称' => 'Name',
	'图片' => 'Pic',
	'编号' => 'SN',
	'时间' => 'Date',
	'尺寸' => 'Size',
	'价格' => 'Price',
	'数量' => 'Quantity',
	'订单号' => 'Order No.',
	'操作' => 'Operator',
	'暂无内容' => 'Not Data for a while',
	'添加内容' => 'Add Content',
	'内容增加' => 'Add Content',
	'分类' => 'Class',
	'缺货产品管理' => 'OOS Product Manage',
	'公告管理' => 'Notice Manage',
	'网站参数与管理信息' => 'Setting and Admin',
	'管 理 员' => 'Admin',
	'退出' => 'Quit',
	'网站参数' => 'Site Setting',
	'商品管理' => 'Product Manage',
	'查看' => 'Look',
	'缺货' => 'OOS',
	'订单管理' => 'Order Manage',
	'全部' => 'All',
	'未 处 理' => 'New',
	'已 付 款' => 'Paying',
	'已 收 款' => 'Payed',
	'已 发 货' => 'In Transit',
	'已 收 货' => 'Finish',
	'无效订单' => 'Invalid',
	'用户管理' => 'User Manage',
	'注册协议' => 'Agreement',
	'支付与送货' => 'Payment and Deliver',
	'送货方式' => 'Deliver Type',
	'支付方式' => 'Pay Type',
	'在线支付' => 'Pay Online',
	'新闻与公告' => 'News And Notice',
	'新闻添加' => 'Add News',
	'修改删除' => 'Modify Or Del',
	'公告设置' => 'Notice Manage',
	'友情链接' => 'Friend Links',
	'帮助信息设置' => 'Help Content Manage',
	'分类内容管理' => 'Help Class Manage',
	'购 物 车' => 'Basket',
	'网站名称' => 'Site Name',
	'网站地址' => 'Site Loaction',
	'排序' => 'Sort',
	'请输入用户名' => 'Please input the user name',
	'请输入密码' => 'Please input the password',
	'请输入验证码' => 'Please input the validate code',
	'错误的验证码' => 'Validate Code Error',
	'请不要非法操作' => 'Request Error',
	'用户名或密码错误' => 'User Name or Password Error',
	'管理登陆' => 'Admin Login',
	'验证码' => 'Code',
	'没有新订单' => 'Not Any New Order',
	'点击查看' => 'Click To View',
	'新订单' => 'New Order',
	'所有订单' => 'All Order',
	'电话' => 'Tel',
	'邮编' => 'Postcode',
	'国家' => 'Country',
	'地址' => 'Address',
	'真实姓名' => 'real name',
	'积分修改' => 'Money',
	'附加费用' => 'Charge',
	'说明' => 'Description',
	'到货时间' => 'Reach Time',
	'新增网站信息分类名称' => 'Add Help Class Name',
	'注册时间' => 'Reg Date',
	'类型' => 'User Type',
	'订单' => 'Order',
	'状态' => 'State',
	'日期' => 'Date',
	'订货人' => 'Order People',
	'收货人' => 'Consignee',
	'其它说明' => 'Other',
	'合计' => 'Total',
	'订购货物列表' => 'Order Product List',
	'网站联系信息' => 'Site Info',
	'网站域名' => 'Domain',
	'网站代码' => 'Site Code',
	'网店地址' => 'Shop Location',
	'ICP备案号/证书' => 'ICP',
	'传真' => 'Fax',
	'网站显示设置' => 'Site Template Setting',
	'模板' => 'Template',
	'样式' => 'Style',
	'产品显示设置' => 'Product Show Setting',
	'每页显示产品数' => 'Number of Per Page',
	'商品缩略图尺寸' => 'Product Thumbnail Size',
	'宽×高' => 'width * height',
	'管理员用户名不能为空' => 'Admin User Name Can\'t be empty',
	'管理员密码不能为空' => 'Admin Password Can\'t be empty',
	'管理员已经存在!' => 'This admin user had exist!',
	'请先添加分类' => 'Pleas Add Type',
	'清空缓存' => 'Clear Cache',
	'是否打开缓存' => 'Open Cache',
	'请输入正确的paypal帐号' => 'Please input the right paypal account',
	'一级分类' => 'Category Level One',
	'二级分类' => 'Category Level Two',
	'三级分类' => 'Category Level Three',
	'数量列表' => 'List Of Quantity',
	'价格列表' => 'List Of Price',
	'修改价格' => 'Change Price',
	'各数量用/分开' => 'All of the quantity with / separated',
	'各价格用/分开' => 'All of the price with / separated',
	'分别与上边的数量对应' => 'With the number of corresponding upside',
	'静态文件目录' => 'Static file directory',
	'静态文件扩展名' => 'Static file ext',
	'商品默认详情' => 'Default Product Detail',
	'默认标题' => 'Default Page Title',
	'默认关键词' => 'Default Page Keywords',
	'默认描述' => 'Default Page Description'
);

	if(isset($LANGUAGE[$text])){
		return $LANGUAGE[$text];
	}else{
		return $text;
	}
}

function smarty_gettext_strarg($str)
{
	$tr = array();
	$p = 0;

	for ($i=1; $i < func_num_args(); $i++) {
		$arg = func_get_arg($i);
		
		if (is_array($arg)) {
			foreach ($arg as $aarg) {
				$tr['%'.++$p] = $aarg;
			}
		} else {
			$tr['%'.++$p] = $arg;
		}
	}
	
	return strtr($str, $tr);
}

function smarty_block_t($params, $text, &$smarty)
{
	$text = stripslashes($text);
	$text = smarty_gettext($text);

	// run strarg if there are parameters
	if (count($params)) {
		$text = smarty_gettext_strarg($text, $params);
	}
	return $text;
}
?>
