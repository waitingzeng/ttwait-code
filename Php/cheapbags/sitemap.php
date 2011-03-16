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
include_once(ROOT_PATH. 'admin/includes/cls_google_sitemap.php');

$domain = $ecs->url();
$today  = local_date('Y-m-d');

$sm     =& new google_sitemap();
$smi    =& new google_sitemap_item($domain, $today, $_POST['homepage_changefreq'], $_POST['homepage_priority']);
$sm->add_item($smi);

$config = array(
    'homepage_changefreq' => 'hourly',
    'homepage_priority' => 0.9,
    'category_changefreq' => 'hourly',
    'category_priority' => 0.8,
    'content_changefreq' => 'hourly',
    'content_priority' => 0.7,
    );

$db->query("UPDATE " .$ecs->table('shop_config'). " SET VALUE='$config' WHERE code='sitemap'");

/* 商品分类 */
$sql = "SELECT cat_id,cat_name FROM " .$ecs->table('category'). " ORDER BY parent_id";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
    $smi =& new google_sitemap_item($domain . build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']), $today,
        $config['category_changefreq'], $config['category_priority']);
    $sm->add_item($smi);
}

/* 文章分类 */
$sql = "SELECT cat_id,cat_name FROM " .$ecs->table('article_cat'). " WHERE cat_type=1";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
    $smi =& new google_sitemap_item($domain . build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']), $today,
        $config['category_changefreq'], $config['category_priority']);
    $sm->add_item($smi);
}

/* 商品 */
$sql = "SELECT goods_id, goods_name FROM " .$ecs->table('goods'). " WHERE is_delete = 0";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
    $smi =& new google_sitemap_item($domain . build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']), $today,
        $config['content_changefreq'], $config['content_priority']);
    $sm->add_item($smi);
}

/* 文章 */
$sql = "SELECT article_id,title,file_url,open_type FROM " .$ecs->table('article'). " WHERE is_open=1";
$res = $db->query($sql);

while ($row = $db->fetchRow($res))
{
    $article_url=$row['open_type'] != 1 ? build_uri('article', array('aid'=>$row['article_id']), $row['title']) : trim($row['file_url']);
    $smi =& new google_sitemap_item($domain . $article_url,
        $today, $config['content_changefreq'], $config['content_priority']);
    $sm->add_item($smi);
}

clear_cache_files();    // 清除缓存

$res = $sm->build();
header('Content-type: application/xml; charset=utf-8');
header("Expires: -1");
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
echo $res;

?>