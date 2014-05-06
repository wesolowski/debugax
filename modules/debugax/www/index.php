<?php
    #turn off Notice report
    error_reporting(0);
    #Debug
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    function getShopBasePath()
    {
        return realpath(dirname(__FILE__).'/../../../') .DIRECTORY_SEPARATOR;
    }
    require_once substr(__DIR__, 0, -3) . 'function.php';
    $sBasePath = getShopBasePath();
    include_once $sBasePath . 'modules/functions.php';
    include_once $sBasePath . 'core/oxfunctions.php';
    include_once $sBasePath . 'core/adodblite/adodb.inc.php';
    include_once $sBasePath . 'core/oxconfig.php';
    include_once $sBasePath . 'core/oxsupercfg.php';


    include_once $sBasePath . "core/oxutils.php";

    $myConfig = oxConfig::getInstance();

    // Includes Utility module.
    $sUtilModule = $myConfig->getConfigParam( 'sUtilModule' );
    if ( $sUtilModule && file_exists( getShopBasePath()."modules/".$sUtilModule ) )
        include_once getShopBasePath()."modules/".$sUtilModule;

    require_once substr(__DIR__, 0, -3) . 'core'. DS .  'chromephp.php';
    $sMySqlConfigPath = substr(__DIR__, 0, -3) . 'tmp' . DS . 'mySqlConfig.json';
    if(file_exists($sMySqlConfigPath))
    {
        $aResult = json_decode(file_get_contents($sMySqlConfigPath, true),true);
    }
    $iSleepTime  = (isset($aResult['sleep']) && !empty($aResult['sleep'])) ? $aResult['sleep'] : 3;
    $iLimit      = (isset($aResult['limit']) && !empty($aResult['limit'])) ? $aResult['limit'] : 30;
    $bIfComplete = (isset($aResult['send']) && $aResult['send'] == true)   ? true              : false;
    $aConfig     = getConfigFile();
    $iBacktrace  = $aConfig ['filter']['backtrace'];
    unset($aConfig);
    if(!isset($_GET["checkid"]) || $_GET["checkid"] != '720a7d2b56c90e503d2589f8c565b02c' && !empty($sIdent))
    {
        die('..');
    }
    elseif($_GET["start"] == true)
    {
        sleep($iSleepTime);
    }

    $bResult = false;
    $oDb = oxDb::getDb(true);
    $sIdent = ( $_SESSION['debugPHP'] ) ? $_SESSION['debugPHP'] : getIdent() ;

    //$sSql = 'select id, sql1, timer,params, tracer, type from adodb_debugphp_logsql WHERE `check` is null  ORDER BY `id` ASC  LIMIT ' . $iLimit;
    $sSql = 'select id, sql1, timer,params, tracer, type from adodb_debugphp_logsql WHERE `check` is null AND `ident` = ?  ORDER BY `id` ASC  LIMIT ?';

    $rs = $oDb->execute( $sSql, array($sIdent,$iLimit ) );

    if ($rs != false && $rs->recordCount() > 0)
    {
        while (!$rs->EOF)
        {
            $bResult = true;

            if($rs->fields['type'] == 'sql')
            {
                $sql = ltrim($rs->fields['sql1']);
                $iError = (strtolower(substr(trim($rs->fields['tracer']) , 0, 5)) == 'error' ) ? true : false;

                if($iBacktrace)
                {
                    $aResult = json_decode($rs->fields['params'],true);
                    if($iError)
                    {
                        chromephp::getInstance(true)->group('Error! SQL type: ' . trim(current(explode(' ',$sSql))));
                            chromephp::getInstance(true)->error($sql);
                    }
                    else
                    {
                        chromephp::getInstance(true)->groupCollapsed('SQL type: ' . trim(current(explode(' ',$sSql))));
                            chromephp::getInstance(true)->warn($sql);
                    }
                            chromephp::getInstance(true)->info('Result: ', $aResult);
                            chromephp::getInstance(true)->log('Request URL: ');
                            chromephp::getInstance(true)->info($rs->fields['tracer']);
                            chromephp::getInstance(true)->info('Timer: ',  $rs->fields['timer']);
                       chromephp::getInstance(true)->groupEnd();
                }
                else
                {
                    if( $iError )
                    {
                        chromephp::getInstance(true)->group('SQL Error!!!');
                            chromephp::getInstance(true)->error($sql);
                            chromephp::getInstance(true)->info($rs->fields['tracer']);
                        chromephp::getInstance(true)->groupEnd();
                    }
                    else
                    {
                        chromephp::getInstance(true)->warn($sql);
                    }
                }
            }
            else
            {
                $param1 = unserialize($rs->fields['sql1']);
                $param2 = unserialize($rs->fields['params']);
                $param1 = (is_null($param1)) ? '' : $param1;
                $param2 = (is_null($param2)) ? '' : $param2;

                chromephp::getInstance(true)->log($param2, $param1 ,$rs->fields['type']);
            }
            $rs->moveNext();
        }
    }
    if($bIfComplete)
    {
         //$sLastSql = 'DELETE FROM adodb_debugphp_logsql ORDER BY `id` ASC  LIMIT ' . $iLimit;
        $sLastSql = 'DELETE FROM adodb_debugphp_logsql WHERE `ident` = "'.$sIdent.'" ORDER BY `id` ASC  LIMIT ' . $iLimit;
    }
    else
    {
        //$sLastSql = 'UPDATE adodb_debugphp_logsql SET `check`=1 WHERE  `check` is null  ORDER BY `id` ASC  LIMIT ' . $iLimit;
        $sLastSql = 'UPDATE adodb_debugphp_logsql SET `check`=1 WHERE  `check` is null AND  `ident` = "'.$sIdent.'" ORDER BY `id` ASC  LIMIT ' . $iLimit;
    }
    $oDb->execute($sLastSql);

    ($bResult == true) ? chromephp::getInstance(true)->getJsonResult() : die('.');



