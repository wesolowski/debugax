<?php
function smarty_function_chromephp($params, &$smarty)
{
    $var = $params['value'];
    chromephp::getInstance()->info($params);
    return '';
    //return addslashes( $string );
}
