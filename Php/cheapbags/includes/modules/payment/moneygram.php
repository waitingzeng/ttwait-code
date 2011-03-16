<?php

/**
     西联汇款模块
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/moneygram.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'moneygram_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'TTwait';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.moneygram.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.1';  

    
    $modules[$i]['config'] = array();  
    return;
}



class westernunion
{
   /**
    * 构造函数
    *
    * @access  public
    * @param
    *
    * @return void
    */
    function westernunion()
    {

    }

    function __construct()
    {
        $this->westernunion();
    }

    /**
    * 生成支付代码
    * @param   array   $order  订单信息
    * @param   array   $payment    支付方式信息
    */

    function get_code($order, $payment)
    {
// 此处只是用于显示用户付款成功的提示信息。我并没有做成按钮的形式，可自行修改
        $def_url = '<br />'. $GLOBALS['_LANG']['pay_button'] ; 

        return $def_url;
    }   

}


?>