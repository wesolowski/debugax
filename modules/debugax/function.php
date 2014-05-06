<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


if ( !function_exists( 'backtrace' ) )
{
    /**
     * Die Methode gibt uns ein Backtrace
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @param  string  $sValue    die Nachricht ist in JS-Console angezeigt, als Group-Name
     * @param  integer $iNumber   Anzahl des BacktraceInfo
     * @param  boolean $obj       Soll objekte angezeigt sein ( vorsicht, die Objekte können Gross sein )
     * @return void
     */
    function backtrace($sValue = 'debug', $iNumber = 0 ,$obj = false)
    {
        $deb = debug_backtrace();
        array_shift($deb);
        chromephp::getInstance()->groupCollapsed($sValue);
            $lp = 1;
            foreach ($deb as $d)
            {
                if($iNumber && $iNumber == $lp-1)
                {
                    continue;
                }
                chromephp::getInstance()->group($lp . '. | Class: ' . $d['class'].  ' | File: ' . $d['file']);
                    chromephp::getInstance()->log('Function: ',$d['function']);
                    chromephp::getInstance()->log('Line: ', $d['line']);
                    chromephp::getInstance()->log('Type: ', $d['type']);
                    chromephp::getInstance()->log('Args: ', $d['args']);
                    if($obj != false)
                    {
                        chromephp::getInstance()->log('Object: ', $d['object']);
                    }
                chromephp::getInstance()->groupEnd();
                $lp++;
            }
        chromephp::getInstance()->groupEnd();
    }

}

if ( !function_exists( 'chromephp' ) )
{

    /**
     * Die Methode ist eine abkürzun von chromephp::getInstance()
     * Mögliche parameter:
     * chromephp('test')
     * chromephp('test1', 'test2')
     * chromephp('test1', 'warn')
     * chromephp('test1', 'error')
     * chromephp('test1', 'test2', 'warn')
     * chromephp('test1', 'test2', 'error')
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @return void
     */
    function chromephp()
    {
        $args = func_get_args();
        $iCountArgs = count($args);
        if($iCountArgs > 3 || $iCountArgs < 1)
        {
            trigger_error("Error func_get_args. function debugphp ", E_USER_ERROR);
        }
        elseif($iCountArgs == 3)
        {
            $severity = array_pop($args);
        }
        elseif($iCountArgs == 2)
        {
            $severity = array_pop($args);
            $args[1] = '';
        }
        else
        {
            $severity = '';
        }
        chromephp::getInstance()->log($args[0], $args[1] ,$severity);
    }

}


if ( !function_exists( 'startDebug' ) )
{
    /**
     * Die Methode ist gebraucht wenn ein Filte auf UserModel
     * eingestellt ist.
     * Bitte setzt die Funktion da wo möchest du
     * die SQL-Abfrage sehen.
     * Bitte mit stopDebug() benutzen.
     * Example:
     * public function getVariants()
     * {
     *    startDebug();
     *    $bRes = parent::getVariants();
     *    stopDebug();
     *    return $bRes;
     * }
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @return void
     */
    function startDebug($header = false)
    {
        $oDebugaxConfig = new Debugax_Config();
        $mResult = true;
        if($header == false)
        {

            $mResult = $oDebugaxConfig->getIdent();
        }
        $oDebugaxConfig->setSearchText();
        return ($mResult && !oxSession::hasVar( 'debugPHP')) ? oxSession::setVar( 'debugPHP', $mResult) : false;
    }
}

if ( !function_exists( 'stopDebug' ) )
{
    /**
     * Stop die Filte startDebug
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @return void
     */
    function stopDebug()
    {
        oxSession::deleteVar( 'debugPHP');
    }
}




/*=========================================================
===========================================================
                    INTERNAL FUNCTIONS
===========================================================
=========================================================*/
class Debugax_Config
{




    public function getIdent()
    {
        $aChromePHPident = explode('chromephp=', $_SERVER['HTTP_USER_AGENT']);
        return (isset($aChromePHPident[1])) ? $aChromePHPident[1] :  'chromephp';
    }


    public function getShopBasePath()
    {
        return strstr(dirname(__FILE__), 'modules', true) .DS ;
    }



    public function getConfigFile()
    {
        $sConfigPath = dirname(__FILE__) . DS . 'tmp'. DS .'config.json';
        return (file_exists($sConfigPath)) ? json_decode(file_get_contents($sConfigPath), true) : array() ;
    }




    public function setSearchText()
    {
        $aConfig = $this->getConfigFile();
        if($aConfig['filter']['search'] == 1
            && !empty($aConfig['filter']['sSearchText'])
            && (!oxSession::hasVar( 'debugPHPSearch') || oxSession::getVar( 'debugPHPSearch') != $aConfig['filter']['sSearchText'] ))
        {
            oxSession::setVar( 'debugPHPSearch', $aConfig['filter']['sSearchText']);
        }
    }



    #http://stackoverflow.com/questions/8396917/php-json-encode-a-debug-backtrace-with-resource-types
    public function clean_trace($branch)
    {
        if(is_object($branch)){
            // object
            $props = array();
            $branch = clone($branch); // doesn't clone cause some issues?
            foreach($props as $k=>$v)
                $branch->$i = $this->clean_trace($v);
        }elseif(is_array($branch)){
            // array
            foreach($branch as $i=>$v)
                $branch[$i] = $this->clean_trace($v);
        }elseif(is_resource($branch)){
            // resource
            $branch = (string)$branch.' ('.get_resource_type($branch).')';
        }elseif(is_string($branch)){
            // string (ensure it is UTF-8, see: https://bugs.php.net/bug.php?id=47130)
            $branch = utf8_encode($branch);
        }
        // other (hopefully serializable) stuff
        return $branch;
    }


}
