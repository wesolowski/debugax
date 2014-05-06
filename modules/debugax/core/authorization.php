<?php


class authorization
{
    /**
     * Name der eigenen Klasse
     * @access protected
     * @var string
     */
    protected $_sClassName = 'authorization';

    protected $_bClassReading = false;

    protected $aConfig = null;

    protected $bAuthorization = null;


    protected function _setClassReading($bReading = false)
    {
        $this->_bClassReading = $bReading;
    }

    protected function _getClassReading()
    {
        return $this->_bClassReading;
    }


    protected function _setAuthorization()
    {
        $aConfig = $this->_getConfig();
        $this->bAuthorization = (!empty($aConfig) ) ? $this->_checkAuthorization() : null;
    }

    public function getAuthorization()
    {
        if( is_null($this->bAuthorization) )
        {
            $this->_setAuthorization();
        }
        return $this->bAuthorization;
    }

    protected function _setConfig()
    {
        $oDebugaxConfig = new Debugax_Config();
        $this->aConfig = $oDebugaxConfig->getConfigFile();
    }

    protected function _getConfig()
    {
        if( is_null( $this->aConfig ) )
        {
            $this->_setConfig();
        }
        return $this->aConfig;
    }

    public function getClassName($bReading = false)
    {
        $bAuthorization = $this->getAuthorization();
        $this->_setClassReading($bReading);
        if(is_null($bAuthorization))
        {
            $sClassName = 'chromephp';
        }
        else if($bAuthorization == false)
        {
            $sClassName = 'chromephpblocked';
        }
        else
        {
            $sClassName = $this->_getClassNameByConfig();
        }
        return $sClassName;
    }


    protected function _checkAuthorization()
    {
        $aConfig = $this->_getConfig();
        if($aConfig['iAuthorization'] == 2)
        {
            $bResult =  $this->_checkServer();
        }
        else if($aConfig['iAuthorization'] == 3)
        {
            $bResult =  $this->_checkSufix();
        }
        else
        {
            $bResult = false;
        }
        return $bResult;
    }

    protected function _checkServer()
    {
        $aConfig = $this->_getConfig();
        $ip = $aConfig['sAuthorizationText'];
        return ($_SERVER['REMOTE_ADDR'] == $ip || $_SERVER['HTTP_X_FORWARDED_FOR'] == $ip) ? true : false;
    }

    protected function _checkSufix()
    {
        $aConfig = $this->_getConfig();
        return (!is_null($_GET[$aConfig['sAuthorizationText']] )) ? true : false;
    }

    protected function _getClassNameByConfig()
    {
        $aConfig = $this->_getConfig();
        switch ($aConfig['sendData']) {
            case $this->_getClassReading():
                $sClassName = 'chromephpMysqlReading';
                break;
            case 1:
                $sClassName = 'chromephpHeader';
                break;
            case 2:
                $sClassName = 'chromephpFile';
                break;
            case 3:
                $sClassName = 'chromephpMysql';
                break;
            default:
                $sClassName = 'chromephp';
                break;
        }
        return $sClassName;
    }

}
