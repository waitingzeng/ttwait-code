<?php

/**
 * ECSHOP JSON 类
 * ===========================================================
 * 版权所有 2005-2008 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ==========================================================
 * $Author: testyang $
 * $Id: cls_json.php 15013 2008-10-23 09:31:42Z testyang $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

if (!defined('EC_CHARSET'))
{
    define('EC_CHARSET', 'utf-8');
}

class JSON
{
    var $at   = 0;
    var $ch   = '';
    var $text = '';

    function encode($arg, $force = true)
    {
        static $_force;
        if (is_null($_force))
        {
            $_force = $force;
        }

        if ($_force && EC_CHARSET == 'utf-8' && function_exists('json_encode'))
        {
            return json_encode($arg);
        }

        $returnValue = '';
        $c           = '';
        $i           = '';
        $l           = '';
        $s           = '';
        $v           = '';
        $numeric     = true;

        switch (gettype($arg))
        {
            case 'array':
                foreach ($arg AS $i => $v)
                {
                    if (!is_numeric($i))
                    {
                        $numeric = false;
                        break;
                    }
                }

                if ($numeric)
                {
                    foreach ($arg AS $i => $v)
                    {
                        if (strlen($s) > 0)
                        {
                            $s .= ',';
                        }
                        $s .= $this->encode($arg[$i]);
                    }

                    $returnValue = '[' . $s . ']';
                }
                else
                {
                    foreach ($arg AS $i => $v)
                    {
                        if (strlen($s) > 0)
                        {
                            $s .= ',';
                        }
                        $s .= $this->encode($i) . ':' . $this->encode($arg[$i]);
                    }

                    $returnValue = '{' . $s . '}';
                }
                break;

            case 'object':
                foreach (get_object_vars($arg) AS $i => $v)
                {
                    $v = $this->encode($v);

                    if (strlen($s) > 0)
                    {
                        $s .= ',';
                    }
                    $s .= $this->encode($i) . ':' . $v;
                }

                $returnValue = '{' . $s . '}';
                break;

            case 'integer':
            case 'double':
                $returnValue = is_numeric($arg) ? (string) $arg : 'null';
                break;

            case 'string':
                $returnValue = '"' . strtr($arg, array(
                    "\r"   => '\\r',    "\n"   => '\\n',    "\t"   => '\\t',     "\b"   => '\\b',
                    "\f"   => '\\f',    '\\'   => '\\\\',   '"'    => '\"',
                    "\x00" => '\u0000', "\x01" => '\u0001', "\x02" => '\u0002', "\x03" => '\u0003',
                    "\x04" => '\u0004', "\x05" => '\u0005', "\x06" => '\u0006', "\x07" => '\u0007',
                    "\x08" => '\b',     "\x0b" => '\u000b', "\x0c" => '\f',     "\x0e" => '\u000e',
                    "\x0f" => '\u000f', "\x10" => '\u0010', "\x11" => '\u0011', "\x12" => '\u0012',
                    "\x13" => '\u0013', "\x14" => '\u0014', "\x15" => '\u0015', "\x16" => '\u0016',
                    "\x17" => '\u0017', "\x18" => '\u0018', "\x19" => '\u0019', "\x1a" => '\u001a',
                    "\x1b" => '\u001b', "\x1c" => '\u001c', "\x1d" => '\u001d', "\x1e" => '\u001e',
                    "\x1f" => '\u001f'
                )) . '"';
                break;

            case 'boolean':
     