<?php

/**
 * ECSHOP 站点地图生成程序
 * ============================================================================
 * 版权所有 2005-2008 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: sitemap.php 16470 2009-07-20 02:34:29Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- 生成站点地图
/*------------------------------------------------------ */
//include_once(ROOT_PATH. 'admin/includes/cls_phpzip.php');

$domain = $ecs->url();
$urls = array();
$urls[] = array('url' => $domain, 'title' => $_CFG['shop_title'], 'desc' => htmlspecialchars($_CFG['shop_keywords']));

/* 商品分类 */
$sql = "SELECT cat_id, cat_name, keywords FROM " .$ecs->table('category'). " ORDER BY parent_id";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
	$url = $domain . build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);
    $urls[] = array('url' => $url, 'title' => 'WholeSale '. $row['cat_name'], 'desc' => htmlspecialchars($row['keywords']));
}

/* 文章分类 */
$sql = "SELECT cat_id,cat_name, keywords FROM " .$ecs->table('article_cat'). " WHERE cat_type=1";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
	$url = $domain . build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
	$urls[] = array('url' => $url, 'title' =>  $row['cat_name'], 'desc' => htmlspecialchars($row['keywords']));
}

/* 商品 */
$sql = "SELECT goods_id, goods_name, keywords FROM " .$ecs->table('goods'). " WHERE is_delete = 0";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
	$url = $domain . build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
	$urls[] = array('url' => $url, 'title' => 'WholeSale '. $row['goods_name'], 'desc' => htmlspecialchars($row['keywords']));
}

/* 文章 */
$sql = "SELECT article_id,title,file_url,open_type, keywords FROM " .$ecs->table('article'). " WHERE is_open=1";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
    $url=$row['open_type'] != 1 ? build_uri('article', array('aid'=>$row['article_id']), $row['title']) : trim($row['file_url']);
    $urls[] = array('url' => $url, 'title' =>  $row['title'], 'desc' => htmlspecialchars($row['keywords']));
}
echo json_encode($urls);
?>