<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


class chromephpManager
{
    /**
     * Name der eigenen Klasse
     * @var string
     */
    protected $_sClassName = 'chromephpManager';

    /**
     * Die Configuration-Datei von Modul (Backend).
     * @var [type]
     */
    protected $_sConfigPath = null;

    protected $_oFileManger = null;

    protected function _getFileManger()
    {
        if(is_null($this->_oFileManger))
        {
            $this->_oFileManger = oxNew('fileManager');
        }
        return $this->_oFileManger;
    }

    public function getFunctionCheck()
    {
        $aTest = array();
        $aTest['startDebug']    = (function_exists('startDebug'))       ? 1 : 0;
        $aTest['stopDebug']     = (function_exists('stopDebug'))        ? 1 : 0;
        $aTest['backtrace']     = (function_exists('backtrace'))        ? 1 : 0;
        $aTest['chromephp']     = (function_exists('chromephp'))        ? 1 : 0;

        return $aTest;
    }

    protected function _getConfigPath()
    {
        if( is_null( $this->_sConfigPath ))
        {
            $this->_sConfigPath = $this->_getFileManger()->getTmpPath() . 'config.json';
        }
        return $this->_sConfigPath;
    }

    /**
    * Wir bekommen eine Array mit die Module Configuration
    * @author Rafal Wesolowski <wesolyy@gmail.com>
    * @return array
    */
    public function loadConfig()
    {
        $oDebugaxConfig = new Debugax_Config();
        return $oDebugaxConfig->getConfigFile();
    }

    /**
     * Die Methode erstellt ein Config-datei
     * und ('tworzy wszytsko co powiinna zrobic')
     * @param  array  $aParams [description]
     * @return [type]
     */
    public function saveConfig(array $aParams)
    {
        $bFileChangeResult = ($aParams['debugActive'] == 1 && $aParams['sqlCheck'] )
                             ?  $this->_getFileManger()->changeAdodbFile($aParams)
                             : $this->_getFileManger()->getBackup();
        $bFileConfig       = file_put_contents($this->_getConfigPath(), json_encode($aParams));

        return ($bFileConfig && $bFileChangeResult) ? true : false;
    }


}

