<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


class fileManager
{
    /**
     * Name der eigenen Klasse
     * @access protected
     * @var string
     */
    protected $_sClassName = 'fileManager';

    protected $_aConfig = null;

    protected $_aAllowedFile = array(
                0 => 'testPerformance',
                1 => 'countAllSql',
                2 => 'showAllSql',
                3 => 'showAllCud',
                41 => 'errorSql',

                21 => 'showAllSqlBacktrace',
                31 => 'showAllCudBacktrace',
    );

    protected $_aAllowedKeyConfig = array('filter', 'debugActive', 'sendData' , 'sqlCheck');

    /**
     * Path zum Adodb Sql Datei
     * @var [type]
     */
    protected $_sMysqlDriverPath = null;

    protected $_sAdodbPath = null;

    protected $_sAdodbPerfPath = null;

    protected $_sPearModulePath = null;

     /**
     * Path zum Ordner wo die Sicherheit-Datei sind
     * @var [type]
     */
    protected $_sBackupMysqlDriverPath = null;

    protected $_sBackupAdodbPath       = null;

    protected $_sBackupAdodbPerfPath   = null;

    protected $_sBackupPearModulePath  = null;

    /**
     * [$_bBackupStatus description]
     * @var [type]
     */
    protected $_bBackupStatus = null;

    /**
     * Path zum Ordner wo Basis-Datei liegen.
     * @var [type]
     */
    protected $_sSourcePath = null;

    /**
     * Path zum Temp Ordner
     * @var [type]
     */
    protected $_sTmpPath = null;


    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $sShopDir           = oxConfig::getInstance()->getConfigParam('sShopDir');
        $sModulPath         = $sShopDir . 'modules'.DS.'debugax'.DS;
        $this->_sTmpPath    = $sModulPath . 'tmp'.DS;
        $this->_sSourcePath = $sModulPath . 'source' .DS;


        $sAdodblitePath          = $sShopDir . 'core' .DS. 'adodblite' .DS;
        $this->_sMysqlDriverPath = $sAdodblitePath . 'adodbSQL_drivers' .DS. 'mysql' .DS. 'mysql_driver.inc';
        $this->_sAdodbPath       = $sAdodblitePath . 'adodb.inc.php';
        $this->_sAdodbPerfPath   = $sAdodblitePath . 'adodb-perf.inc.php';
        $this->_sPearModulePath  = $sAdodblitePath . 'generic_modules' .DS.  'pear_module.inc';

        $sBackupDirPath                = $sModulPath . 'backup' .DS ;
        $this->_sBackupMysqlDriverPath = $sBackupDirPath . 'mysql_driver.inc';
        $this->_sBackupAdodbPath       = $sBackupDirPath .DS . 'adodb.inc.php';
        $this->_sBackupAdodbPerfPath   = $sBackupDirPath .DS . 'adodb-perf.inc.php';
        $this->_sBackupPearModulePath  = $sBackupDirPath .DS . 'pear_module.inc';

        $this->_bBackupStatus    = $this->checkBackup();
    }

    public function debugTxt($sSeite = 'test')
    {
        $f = fopen( $this->_sTmpPath . 'perform' .DS. $sSeite .'.txt', 'a' );
        fputs( $f, "1\n" );
        fclose( $f );
    }


    public function getFileInfo()
    {
        $aFiles = array();
        $sDirPath = substr(__DIR__, 0, -4) . 'tmp' . DS . 'file';
        foreach (new DirectoryIterator($sDirPath) as $fileInfo)
        {
            $sKbSize = round($fileInfo->getSize() / 1024, 2);
            $sMbSize = round($fileInfo->getSize() / 1048576, 2);
            $aFiles[$fileInfo->getFileName()] = array(
                1 => date('d.m.Y H:i:s', $fileInfo->getCTime()),
                2 => $sKbSize,
                3 => $sMbSize
            );
        }
        unset($aFiles['.']);
        unset($aFiles['..']);
        arsort($aFiles);
        return $aFiles;
    }

    public function getDirFileUrl()
    {
        return '/modules/debugax/tmp/file/';
    }

    public function changeAdodbFile(array $aParams)
    {
        return ($this->_checkConfigParams($aParams)) ? $this->_getFileBySendConfig() : false;
    }

    protected function _checkConfigParams(array $aParams)
    {
        $bResult = true;
        foreach ($this->_aAllowedKeyConfig as $sKey)
        {
            if(!array_key_exists($sKey, $aParams))
            {
                $bResult = false;
            }
        }
        return ($bResult) ? $this->_setConfig($aParams) : false;
    }

    public function createDir($sPath)
    {
        if (!is_dir($sPath))
        {
            mkdir($sPath, 0777);
        }
    }

    protected function _isFilePathAllowed($sPath)
    {
         return (file_exists($sPath) && in_array(basename($sPath, '.inc'), $this->_aAllowedFile)) ? true : false;
    }

    public function getMysqlDriverBackup()
    {
        return ($this->_bBackupStatus) ? copy($this->_sBackupMysqlDriverPath ,$this->_sMysqlDriverPath) : false;
    }


    public function getBackup()
    {
        $bMysqlDriverBackup = $this->getMysqlDriverBackup();
        $bAdodbBackup = $this->getAdodbBackup();
        return ($bMysqlDriverBackup && $bAdodbBackup) ? true : false;
    }

    public function getAdodbBackup()
    {
        if($this->_bBackupStatus)
        {
            $sResult1 =  copy($this->_sBackupAdodbPath,      $this->_sAdodbPath);
            $sResult2 =  copy($this->_sBackupAdodbPerfPath,  $this->_sAdodbPerfPath);
            $sResult3 =  copy($this->_sBackupPearModulePath, $this->_sPearModulePath);
        }
        else
        {
            $sResult1 = $sResult2 = $sResult3 = false;
        }
        return ($sResult1 && $sResult2 && $sResult3) ? true : false;
    }



    protected function _changeFile($sPath)
    {
        $bResult = false;
        if($this->_bBackupStatus == true && $this->_isFilePathAllowed($sPath))
        {
            $bResult = $this->_copyFile($sPath , $this->_sMysqlDriverPath);
        }
        return $bResult;
    }

    public function changePerformFile()
    {
        $sPath = $this->getSourcePath(). 'mysqlDriver'.DS.'nofilter'. DS. 'testPerformance.inc';
        return $this->_changeFile($sPath);
    }

    public function backup()
    {
        $oChromeManager = oxNew('chromephpManager');
        $_aConfig = $oChromeManager->loadConfig();
        if(!empty($_aConfig))
        {
            $_aConfig['debugActive'] = 0;
            $oChromeManager->saveConfig($_aConfig);
        }
        return $this->getBackup();
    }


    protected function _setConfig(array $aNewConfig)
    {
        $this->_aConfig = $aNewConfig;
        return $this;
    }

    public function getTmpPath()
    {
        return $this->_sTmpPath;
    }


    public function getSourcePath()
    {
        return $this->_sSourcePath;
    }

    protected function _getFileBySendConfig()
    {
    	$this->getBackup();
      	return ($this->_aConfig['sendData'] == 3) ? $this->_changeAdodbFiles() : $this->_getFileByConfig();
    }

    protected function _changeSourceAdodbFiles()
    {
        $sAdodbSourceFile = $this->_sSourcePath . 'adodblite' . DS;
        $bResult1 = $this-> _copyFile($sAdodbSourceFile . basename($this->_sPearModulePath), $this->_sPearModulePath);
        $bResult2 = $this-> _copyFile($sAdodbSourceFile . basename($this->_sAdodbPath), $this->_sAdodbPath);
        return ($bResult1 && $bResult2) ? true: false;
    }
    protected function _copyFile($sSource, $sDest)
    {
        return (file_exists($sSource)) ? copy($sSource , $sDest) : false;
    }

    protected function _changeAdodbFiles()
    {
        return ($this->_changeSourceAdodbFiles()) ? $this->_changeAdodbPerfFile() : false;
    }


    protected function _changeAdodbPerfFile()
    {
        $sDirFilterName = $this->_getFilterDirName();
        $sConfig = $this->_aConfig['sqlCheck'];
        $sConfig .= ($this->_aConfig['filter']['backtrace']) ? '1' : '';
        $sFileName = $this->_sSourcePath . 'adodblite' . DS . $sDirFilterName . DS . $this->_aAllowedFile[$sConfig] . '.inc.php';
        return $this-> _copyFile($sFileName , $this->_sAdodbPerfPath);
    }
    /**
     * [_changeFileByConfig description]
     * @return [type]          [description]
     */
    protected function _getFileByConfig()
    {
        $sFilePath = $this->_getFilePathByConfig();
        return (!is_null($sFilePath)) ? $this->_changeFile($sFilePath) : false;
    }


    protected function _getFilterDirName()
    {
        if($this->_aConfig['filter']['search'] && $this->_aConfig['filter']['moreFilter'] && !empty($this->_aConfig['filter']['sSearchText']))
        {
            $sDirName = 'morefilter';
        }
        elseif($this->_aConfig['filter']['search'] && !empty($this->_aConfig['filter']['sSearchText']))
        {
            $sDirName = 'filter';
        }
        else
        {
            $sDirName = 'nofilter';
        }
        return $sDirName;
    }

    protected function _getFilePathByConfig()
    {
        $sDirFilterName = $this->_getFilterDirName();
        $sConfig = $this->_aConfig['sqlCheck'];
        $sConfig .= ($this->_aConfig['filter']['backtrace']) ? '1' : '';
        $sFileName = $this->_sSourcePath . 'mysqlDriver' . DS . $sDirFilterName . DS . $this->_aAllowedFile[$sConfig] .'.inc';
        return (!is_null($sConfig) && file_exists($sFileName))  ? $sFileName : null ;
    }


    public function checkBackup()
    {
        $sResult1 = (!file_exists($this->_sBackupMysqlDriverPath)) ? copy($this->_sMysqlDriverPath, $this->_sBackupMysqlDriverPath) : true;
        $sResult2 = (!file_exists($this->_sBackupAdodbPath))       ? copy($this->_sAdodbPath, $this->_sBackupAdodbPath)             : true;
        $sResult3 = (!file_exists($this->_sBackupAdodbPerfPath))   ? copy($this->_sAdodbPerfPath, $this->_sBackupAdodbPerfPath)     : true;
        $sResult4 = (!file_exists($this->_sBackupPearModulePath))  ? copy($this->_sPearModulePath, $this->_sBackupPearModulePath)   : true;

        return $this->_bBackupStatus = ($sResult1 && $sResult2 && $sResult3 && $sResult4) ? true : false;
    }
}
