<?php
class chromephp_oxshopcontrol extends chromephp_oxshopcontrol_parent{

    protected $_aConfig = null;



    public function start()
    {
        $this->_checkAuthorization();
        return parent::start();
    }


    protected function _enableChrome()
    {
        $aConfig = $this->_getConfigFile();
        if ($aConfig['filter']['usermodel'] != 1)
        {
            startDebug();
        }
        if($aConfig['info'] == 1)
        {
            $this->_setInfoToChromePHP();
        }
        if($aConfig['sendData'] == 3)
        {
            header('view:' . 'http://' .$_SERVER['SERVER_NAME'].'/modules/debugax/www/index.php' );
            $this->_deleteMysqlRecord();
        }
    }



    protected function _checkAuthorization()
    {
        startProfile('ChromePHP: ' . __CLASS__ . ' / ' . __FUNCTION__);
        if($this->_getAuthorization()->getAuthorization())
        {
            $this->_enableChrome();
        }
        stopProfile('ChromePHP: ' . __CLASS__ . ' / ' . __FUNCTION__);
    }

    protected function _getAuthorization()
    {
        return new authorization();
    }

    protected function _setInfoToChromePHP()
    {
        chromephp::getInstance()->log('Info:');
        chromephp::getInstance()->log('SESSION: ', $_SESSION);
        chromephp::getInstance()->log('SERVER: ', $_SERVER);
        if(!empty($_GET))
        {
            chromephp::getInstance()->log('GET: ', $_GET);
        }
        if(!empty($_POST))
        {
            chromephp::getInstance()->log('POST: ', $_POST);
        }
        chromephp::getInstance()->log('-------------------------------------------');
    }


    protected function _deleteMysqlRecord()
    {
        $oMysqlManager = oxNew('mysqlManager');
        $oMysqlManager->clearDebugMysqlByLogin();
    }


    protected function _initializeViewObject($sClass, $sFunction)
    {
        $this->_debugaxPreloadClass( $sClass );
        return parent::_initializeViewObject($sClass, $sFunction);
    }

    protected function _debugaxPreloadClass( $sClass )
    {
        if (strpos($sClass, 'helper') !== false)
        {
            return $this->_classExists($sClass);
        }
        return false;
    }


    /**
     * Ruft die class_exists-Funktion mit Autoloader auf
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @param  string $sClass Der Klassenname
     * @return boolean
     */
    protected function _classExists($sClass)
    {
        return class_exists($sClass, true);
    }


    protected function _getConfigFile()
    {
        $oDebugConfig = new Debugax_Config();
        return $oDebugConfig->getConfigFile();
    }
}
