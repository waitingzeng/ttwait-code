<?php

if (!defined('IN_ECS'))
{
die('Hacking attempt');
}
function insert_bought_notes($arr)
{
$need_cache = $GLOBALS['smarty']->caching;
$need_compile = $GLOBALS['smarty']->force_compile;

$GLOBALS['smarty']->caching = false;
$GLOBALS['smarty']->force_compile = true;
$sql = 'SELECT u.user_name, og.goods_number, oi.add_time, IF(oi.order_status IN (2, 3, 4), 0, 1) AS order_status ' .
'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $arr['id'] . ' ORDER BY oi.add_time DESC LIMIT 5';
$bought_notes = $GLOBALS['db']->getAll($sql);

foreach ($bought_notes as $key => $val)
{
$bought_notes[$key]['add_time'] = local_date("Y-m-d G:i:s", $val['add_time']);
}

$sql = 'SELECT count(*) ' .
'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $arr['id'];
$count = $GLOBALS['db']->getOne($sql);

$pager = array();
$pager['page']         = $page = 1;
$pager['size']         = $size = 5;
$pager['record_count'] = $count;
$pager['page_count']   = $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;;
$pager['page_first']   = 'javascript:gotoBuyPage(1,$arr[id])';
$pager['page_prev']    = $page > 1 ? 'javascript:gotoBuyPage(' .($page-1). ',$arr[id])' : 'javascript:;';
$pager['page_next']    = $page < $page_count ? 'javascript:gotoBuyPage(' .($page + 1) . ',$arr[id])' : 'javascript:;';
$pager['page_last']    = $page < $page_count ? 'javascript:gotoBuyPage(' .$page_count. ',$arr[id])'  : 'javascript:;';

$GLOBALS['smarty']->assign('notes', $bought_notes);
$GLOBALS['smarty']->assign('pager', $pager);
$val= $GLOBALS['smarty']->fetch('library/bought_notes.lbi');

$GLOBALS['smarty']->caching = $need_cache;
$GLOBALS['smarty']->force_compile = $need_compile;

return $val;
}

?>

