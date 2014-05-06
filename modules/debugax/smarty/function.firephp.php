<?php
function smarty_function_firephp($params, &$smarty)
{
    $var = $params['value'];
    FirePHP::getInstance()->log($var);
    return '';
    //return addslashes( $string );
}
