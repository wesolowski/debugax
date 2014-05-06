<?php

class mysqlManager
{
    /**
     * Name der eigenen Klasse
     * @access protected
     * @var string
     */
    protected $_sClassName = 'mysqlManager';

    protected $_sSqlInstallPath = null;

    protected $_sMysqlFile = null;

    /**
     * [__construct description]
     * @author Rafal           Wesolowski
     * @access public
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * [init description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function init()
    {
       if(is_null($this->_sMysqlFile))
       {
            $this->_sMysqlFile =  substr(__DIR__, 0, -4) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'mySqlConfig.json';
       }
       if(is_null($this->_sSqlInstallPath))
       {
            $this->_sSqlInstallPath =  substr(__DIR__, 0, -4) . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'install.sql';
       }
    }

    public function saveConfig(array $aParams)
    {
        if(is_numeric($aParams['sleep']) && is_numeric($aParams['limit']))
        {
            $this->_saveFile($aParams);
        }
    }


    protected function _saveFile(array $aParams)
    {
        return (!empty($aParams)) ? file_put_contents($this->_sMysqlFile, json_encode($aParams)) : false;
    }

    public function getConfigFile()
    {
        return (file_exists($this->_sMysqlFile)) ? json_decode(file_get_contents($this->_sMysqlFile), true) : array();
    }


    /**
     * Liefert die Datenbankverbindung
     *
     * @author Rafal Wesolowski
     * @return oxDb
     */
    protected function _getDb()
    {
        return oxDb::getDb(true);
    }

    public function countDebugMysql()
    {
        $oDb = $this->_getDb();
        $sSql = 'Select count(id) FROM adodb_debugphp_logsql';
        return $this->checkDebugphpLogTable() ? $oDb->getOne($sSql) : false;
    }

    public function clearDebugMysql()
    {
        $oDb = $this->_getDb();
        $sSql = 'TRUNCATE TABLE adodb_debugphp_logsql';
        return $oDb->Execute($sSql);
    }

    public function clearDebugMysqlByLogin()
    {
        $aResult = $this->getConfigFile();
        if(array_key_exists('send',$aResult) && $aResult['send'] == 0)
        {
            $this->_countDebugMysqlByTime();
        }
    }

    protected function _countDebugMysqlByTime()
    {
    	$oDb = $this->_getDb();
        $sPastTime =  $this->_getPastTime();
        $sSql = 'DELETE FROM adodb_debugphp_logsql WHERE created < "'. $sPastTime . '"';
        return $this->checkDebugphpLogTable() ? $oDb->Execute($sSql) : false;
    }

    protected function _getPastTime($value='')
    {
        return date('Y-m-d H:i:s', strtotime ('-5 minutes'));
    }

    public function checkDebugphpLogTable()
    {
        //OXID 4.5
        // $oDbMetaDataHandler = oxNew('oxDbMetaDataHandler');
        // return $oDbMetaDataHandler->tableExists('adodb_debugphp_logsql');
        //OXID 4.4
        $oDb = $this->_getDb();
        $aTables = $oDb->getAll("show tables like ". $oDb->quote('adodb_debugphp_logsql'));
        return count($aTables) > 0;
    }

    public function setDebugphpLogTable()
    {
        $oDb = $this->_getDb();
        $sSql = file_get_contents($this->_sSqlInstallPath);
        if(!$oDb->execute( $sSql ))
        {
            throw new oxException( 'Fehler! Bitte SQL-Query manuell ausführen:<br>' . $sSql);
        }
    }

    public function getMysqlInfo()
    {
        $oDb = $this->_getDb();
        $sSql = 'Select count(id) as count, ident FROM adodb_debugphp_logsql GROUP BY ident';
        $aResult = $oDb->getAll($sSql);
        return (is_array($aResult) && $this->checkDebugphpLogTable()) ? $aResult : array();
    }
}
