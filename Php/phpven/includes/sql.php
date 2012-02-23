<?php

/*************************
说明：PHP通用防注入代码
功能：防止注入
**************************/

//要过滤的非法字符
$arrFiltrate=array("'",';','union','select','insert','update','delete','load_file','outfile', 'exists', 'and', 'or', 'instr'); 

function funStringExist($strFiltrate,$arrFiltrate)
{
	foreach ($arrFiltrate as $value)
	{
		if (stripos($strFiltrate, $value))
		{
      		return $value;
    	}
  	}
  	return false;
}

$string = implode("",$_REQUEST);

//验证
/*
if($v = funStringExist($string, $arrFiltrate))
{
  echo '<script language="javascript">alert("'.$v.' error");</script>';
  exit();
}
*/
?>