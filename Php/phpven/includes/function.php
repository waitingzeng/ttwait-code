<?php 
	
	function getTitle(){
		$hw_id = $_REQUEST['hw_id'];
		if($hw_id > 0){
			$sql = "select hw_name from hw where hw_id=".$hw_id;
			$hw = $GLOBALS['db']->getRow($sql);
			return $hw[0];
		}
		return '';
	}
	
	function getCacheId($str){
		return sprintf('%X', crc32($str));
	}
	
	function getBooks(){
		return $GLOBALS['db']->getAll('select typeid,id,title from book');
	}
	
	function getPinpais(){
		return $GLOBALS['db']->getAll('select distinct name from category where depth=2 and html != 2 order by name');
	}
	
	function getCurrentPinPai(){
		if(isset($_REQUEST['pinpai'])){
			return $_REQUEST['pinpai'];
		}
		return '';
	}
	
	function getInsort(){
		return $GLOBALS['db']->getAll("select id, name, depth from category where depth=1 and html != 2 order by name");
	}
	
	function getPubs(){
		return $GLOBALS['db']->getAll('select * from pub order by id desc');
	}
	
	function getLinks(){
		return $GLOBALS['db']->getAll('select * from venlink order by bs');
	}
	
	function getHelps(){
		$types = $GLOBALS['db']->getAll('select * from type');
		if(count($types) != 0){
			$bs = $GLOBALS['db']->getAll('select typeid,id,title from book order by id desc');
			$booklists = array();
			foreach ($bs as $item){
				$typeid = $item['typeid'];
				if(!isset($booklists[$typeid])){
					$booklists[$typeid] = array();
				}
				$booklists[$typeid][] = $item;
			}
		}
		return array('bookslist' => $booklists, 'types' => $types);
	}
	
	function getPayments(){
		$sql = "select * from pay order by pay_id";
		return $GLOBALS['db']->getAll($sql);
	}
	
	function getPS(){
		$sql = "select * from ps order by ps_id";
		return $GLOBALS['db']->getAll($sql);
	}
	
	function getPayOnline(){
		$sql = "select * from payonline";
		return $GLOBALS['db']->getRow($sql, true);
	}
	
	function getParents($cat_id){
		$parentpath = $GLOBALS['db']->getOne('select parentpath from category where id='.$cat_id);
		if(!$parentpath){
			return array();
		}
		return $GLOBALS['db']->getAll("select id, name,depth, alias from category where id in (".substr($parentpath, 0, -1).") order by depth asc");
	}
	
	function makeCatWhere($cat_id){
		global $db;
		$sql = "select distinct id from category where depth=3 and parentpath like '%,$cat_id,%'";
		$ids = $db->getCol($sql);
		$arr = array();
		foreach ($ids as $id){
			$arr[] = 'cat_id = '.$id;
		}
		return join($arr, ' or ');
	}
	
	
	function pagination($table, $field='*', $where='', $page=1, $pagesize=30, $order=''){
		$pages = array();
		$total = $GLOBALS['db']->count($table, $where);
		$pages['totalrec'] = $total;
		if($total > 0){
			if($page == 0) $page = 1;
			$pages['pageIndex'] = $page;
			$pages['pageSize'] = $pagesize;
			$pages['totalpage'] = ceil($total / $pagesize);
			$top = $page * $pagesize;
			if($top > $total)
				$top = $total;
			$pages['top'] = $top;
			$bottom = ($page-1) * $pagesize;
			$pages['bottom'] = $bottom+1;
			$sql = (empty($where) ? "SELECT $field FROM $table" : "SELECT $field FROM $table WHERE $where");
			$sql = $sql.' '.$order;
			$pages['items'] = $GLOBALS['db']->getLimit($sql, $pagesize, $bottom);
		}
		return $pages;
	}
	
	function getUserInfo($username){
		$sql = "select * from user where username='$username'";
		return $GLOBALS['db']->getRow($sql);
	}
	
	
	 function modifyPrice($username='', $sub_number=''){
	 	if(empty($username) && empty($sub_number))
	 		return;
	 	$db = $GLOBALS['db'];
	 	if(strlen($sub_number) == 0)
			$sql = "select sum(basket_count) as sumcount from basket where user_name='$username' and sub_number is null";
		else
			$sql = "select sum(basket_count) as sumcount from basket where sub_number='sub_number'";
		$total = $db->getOne($sql);
		if(strlen($sub_number) == 0)
			$sql="select basket.*,hw.pricelist,hw.qualist from basket,hw where user_name='$username' and sub_number is null and basket.hw_id=hw.hw_id";
		else
			$sql="select basket.*,hw.pricelist,hw.qualist from basket,hw where sub_number='$sub_number' and basket.hw_id=hw.hw_id";
		$list = $db->getAll($sql);
		$db->begin();
		foreach ($list as $item){
			$pricelist = $item['pricelist'];
			$qualist = $item['qualist'];
			if(!$qualist) $qualist = DEFAULTQUALIST;
			$kprice = split('/', $pricelist);
			$kqua = split('/', $qualist);
			$length = count($kqua);
			//print $kqua[$length-1] < $total;
			if($kqua[$length-1] < $total)
				$mmprice = $kprice[$length];
			elseif($total == $kqua[0])
				$mmprice = $kprice[0];
			else{
				$i=1;
				while ($i<$length) {
					if($total <= $kqua[$i] && $total > $kqua[$i-1]){
						$mmprice = $kprice[$i];
						break;
					}
					$i+=1;
				}
			}
			$sql = "update basket set hw_price=$mmprice where basket_id=".$item['basket_id'];
			if(!$db->query($sql)){
				$db->roolback();
				return;
			}
		}
		$db->commit();
	}
	
	function setLoginCookie($username=0){
		if($username){
			setcookie('username', $username);
			$userquiz = md5($username.COOKIES_QUIZ);
			setcookie('userquiz', $userquiz);
		}else{
			setcookie('username', '');
			setcookie('userquiz', '');
		}
	}
	
	function hadLogin(){
		if(empty($_COOKIE['username']))
			return 0;
		$username = $_COOKIE['username'];
		$userquiz = $_COOKIE['userquiz'];
		if($userquiz == md5($username.COOKIES_QUIZ))
			return 1;
		return 0;
	}
	
	function checkLogin($url){
		if(!hadLogin()){
			redirect("login.asp?comurl=$url");
		}
		noCache();
		return $_COOKIE['username'];
	}
	
	function getTop(){
		global $tpl;
		$caching = $tpl->caching;
		$tpl->caching = false;
		$cache_id = getCacheId('top');
		if(!$tpl->is_cached('top.html', $cache_id)){
			$tpl->assign_by_ref('books', getBooks());
			$tpl->assign_by_ref('pinpais', getPinpais());
			$tpl->assign_by_ref('currentpinpai', getCurrentPinPai());
		}
		$result = $tpl->fetch('top.html', $cache_id);
		$tpl->caching = $caching;
		return $result;
	}
	
	function getCopy(){
		global $tpl;
		$caching = $tpl->caching;
		$tpl->caching = false;
		$cache_id = getCacheId('copy');
		if(!$tpl->is_cached('copy.html', $cache_id)){
			$tpl->assign_by_ref('links', getLinks());
		}
		$result = $tpl->fetch('copy.html', $cache_id);
		$tpl->caching = $caching;
		return $result;
	}
	
	function initHeaderAndFooter(){
		$GLOBALS['tpl']->assign_by_ref('header', getTop());
		$GLOBALS['tpl']->assign_by_ref('footer', getCopy());
	}

?>