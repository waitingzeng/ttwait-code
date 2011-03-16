<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function get_first_parent( $cat_id = 0 )
{
	$parent = "";
	if ( $cat_id )
	{
		$parent = $GLOBALS['db']->getone( "select parent_id from ".$GLOBALS['ecs']->table( "category" ).( " where cat_id = ".$cat_id ) );
	}
	if ( $parent == 0 )
	{
		return $cat_id;
	}
	return get_first_parent( $parent );
}

function get_subcate_byurl( $url )
{
	$rs = strpos( $url, "category" );
	if ( $rs !== false )
	{
		preg_match( "/\\d+/i", $url, $matches );
		$cid = $matches[0];
		$cat_arr = array( );
		$sql = "select * from ".$GLOBALS['ecs']->table( "category" )." where parent_id=".$cid." and is_show=1 ORDER BY sort_order ASC, cat_id ASC";
		$res = $GLOBALS['db']->getall( $sql );
		foreach ( $res as $idx => $row )
		{
						$cat_arr[$idx]['id'] = $row['cat_id'];
						$cat_arr[$idx]['name'] = $row['cat_name'];
						$cat_arr[$idx]['url'] = build_uri( "category", array(
										"cid" => $row['cat_id']
						), $row['cat_name'] );
						$cat_arr[$idx]['children'] = get_clild_list( $row['cat_id'] );
		}
		return $cat_arr;
	}
	return false;
}

function get_clild_list( $pid )
{
	$sql_sub = "select * from ".$GLOBALS['ecs']->table( "category" )." where parent_id=".$pid." and is_show=1";
	$subres = $GLOBALS['db']->getall( $sql_sub );
	if ( $subres )
	{
		foreach ( $subres as $sidx => $subrow )
		{
			$children[$sidx]['id'] = $subrow['cat_id'];
			$children[$sidx]['name'] = $subrow['cat_name'];
			$children[$sidx]['url'] = build_uri( "category", array(
							"cid" => $subrow['cat_id']
			), $subrow['cat_name'] );
		}
		return $children;
	}
	$children = null;
	return $children;
}

$url = $_SERVER['PHP_SELF'];
$filename = end( explode( "/", $url ) );
if ( $filename == "goods.php")
{
    $goods_id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
    $goods = get_goods_info( $goods_id );
}
else if ( isset( $_REQUEST['id'] ) )
{
    $cat_id = intval( $_REQUEST['id'] );
}
else if ( isset( $_REQUEST['category'] ) )
{
    $cat_id = intval( $_REQUEST['category'] );
}
if ( $filename == "goods.php" )
{
    $GLOBALS['smarty']->assign( "topcat_id", get_first_parent( $goods['cat_id'] ) );
    $GLOBALS['smarty']->assign( "now_id", $goods['cat_id'] );
}
else
{
    $GLOBALS['smarty']->assign( "topcat_id", get_first_parent( $cat_id ) );
    $GLOBALS['smarty']->assign( "now_id", $cat_id );
}
?>
