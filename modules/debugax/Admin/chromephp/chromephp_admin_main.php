<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @link      http://www.oxid-esales.com
 * @package   admin
 * @copyright (C) OXID eSales AG 2003-2011
 * @version OXID eShop EE
 * @version   SVN: $Id: manufacturer_main.php 33186 2011-02-10 15:53:43Z arvydas.vapsva $
 */

/**
 * Admin manufacturer main screen.
 * Performs collection and updating (on user submit) main item information.
 * @package admin
 */
class Chromephp_Admin_Main extends oxAdminDetails
{
    protected $_sThisTemplate = '../../../modules/debugax/Admin/chromephp/Templates/main.tpl';

    protected $_oMysqlManger = null;

    protected $_oFileManger = null;

    protected $_ochromephpManager = null;


    public function _getChromephpManager()
    {
        if(is_null($this->_ochromephpManager))
        {
            $this->_ochromephpManager = oxNew('chromephpManager');
        }
        return $this->_ochromephpManager;
    }


    protected function _getFileManger()
    {
        if(is_null($this->_oFileManger))
        {
            $this->_oFileManger = oxNew('fileManager');
        }
        return $this->_oFileManger;
    }

    protected function _getMysqlManager()
    {
        if(is_null($this->_oMysqlManger))
        {
            $this->_oMysqlManger = oxNew('mysqlManager');
        }
        return $this->_oMysqlManger;
    }


    public function render()
    {
        parent::render();

        $soxId = $this->_aViewData["oxid"] = 'chromephp';
        $this->_aViewData["edit"] = $aParams = $this->_getChromephpManager()->loadConfig();

        $this->_aViewData["aFnCheck"] = $this->_getChromephpManager()->getFunctionCheck();
        $this->_aViewData["sSession"] = oxSession::getVar( 'debugPHP' );

        $this->_getMysqlInfo();


        $oTestPerformance = oxNew('testPerformance');
        $this->_aViewData["aPerformTest"] = $oTestPerformance->getLastPerformTestResult();

        $this->_aViewData["iProductiveModus"] = $this->getConfig()->getActiveShop()->oxshops__oxproductive->value;
        $this->_aViewData["myIp"] = (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];

        if(strpos($aParams['filter']['sSearchText'], '#') !== false)
        {
            $aSearchText = explode('#', $aParams['filter']['sSearchText']);
            $this->_aViewData["edit"]['filter']['sSearchText'] = array_shift($aSearchText);
            $this->_aViewData['aMoreSearchText'] = $aSearchText;
            unset($aSearchText);
        }
        else
        {
            $this->_aViewData['aMoreSearchText'] = array();
        }

        return $this->_sThisTemplate;
    }

    protected function _getMysqlInfo()
    {
        if($this->_aViewData["bMySqlDB"] = $this->_getMysqlManager()->checkDebugphpLogTable())
        {
           $this->_aViewData["aMySqlInfo"] = $this->_getMysqlManager()->getMysqlInfo();
        }
    }

    /**
     * Saves selection list parameters changes.
     *
     * @return mixed
     */
    public function save()
    {

        $aParams =  $this->_getParams();
        $this->_checkSendData($aParams['sendData']);
        if(($aParams['sendData'] == 3 && $aParams['sqlCheck'] == 1 ) ||
           ($aParams['sendData'] == 3 && $aParams['sqlCheck'] == 4 ))
        {
            $this->_addErrorToDisplay( 'Fehler' );
        }
        else
        {
            if($this->_getChromephpManager()->saveConfig($aParams))
            {
                oxSession::deleteVar( 'debugPHP');
                oxSession::deleteVar( 'debugPHPSearch');
            }
        }

    }

    protected function _addErrorToDisplay( $sParam )
    {
        oxUtilsView::getInstance()->addErrorToDisplay( $sParam );
    }


    protected function _checkSendData($iSendData)
    {
        if($iSendData == 3 && !$this->_getMysqlManager()->checkDebugphpLogTable())
        {
            try
            {
                $this->_getMysqlManager()->setDebugphpLogTable();
            }
            catch (Exception $e)
            {
                $this->_addErrorToDisplay( $e->getMessage() );
            }
        }
        elseif($iSendData == 3)
        {
            $this->_getMysqlManager()->clearDebugMysql();
        }
        elseif($iSendData == 2)
        {
            $sFileDirPath = $this->_getFileManger()->getTmpPath() . 'file' . DIRECTORY_SEPARATOR;
            $this->_getFileManger()->createDir($sFileDirPath);
        }
    }

    protected function _getParams()
    {
        $aParams = oxConfig::getParameter( "editval");
        $aFilter = oxConfig::getParameter( "filter");
        $aMoreFilter = oxConfig::getParameter( "sSerchMore");

        foreach ($aFilter as $key => $value)
        {
            if($key == 'backtrace' && $aParams['sqlCheck'] == '4')
            {
                $value = 1;
            }
            elseif ($aParams['sqlCheck'] == '4' || ($aParams['sqlCheck'] == '1' && $key == 'backtrace'))
            {
                $value = 0;
            }
            $aParams['filter'][$key] = $value;
        }

        $aInput = array('debugActive', 'info', 'sendData');
        foreach ($aInput as  $sInputName)
        {
            if (!isset( $aParams[$sInputName]))
            {
                $aParams[$sInputName] = 0;
            }
        }


        $aParams['filter']['sSearchText'] = ($aParams['filter']['sSearchText'] && !empty($aParams['filter']['sSearchText']) && $aParams['filter']['search'] == 1) ? strtolower($aParams['filter']['sSearchText']) : false;

        if($aParams['filter']['sSearchText'] && !empty($aMoreFilter))
        {
            $aParams['filter']['sSearchText'] .= '#'.strtolower(implode('#', array_filter($aMoreFilter)));
            $aParams['filter']['moreFilter'] = 1;
        }
        else
        {
            $aParams['filter']['moreFilter'] = 0;
        }



        return $aParams;
    }


    public function backup()
    {
        $this->_getFileManger()->backup();
    }


}
