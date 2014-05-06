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
class Helper_Admin_Modules extends oxAdminDetails
{
    protected $_sThisTemplate = '../../../modules/debugax/Admin/helper/Templates/modules.tpl';

    protected $_oModuleManager = null;

    public function render()
    {
        parent::render();

        $aResult = $this->_getModuleManager()->getResultFile();
        $this->addTplParam('aModules', $aResult);

        return $this->_sThisTemplate;
    }


    public function _getModuleManager()
    {
        if($this->_oModuleManager == null)
        {
            $this->_setModuleManager();
        }
        return $this->_oModuleManager;
    }

    public function _setModuleManager()
    {
        $this->_oModuleManager = oxNew('moduleManager');
    }
}
