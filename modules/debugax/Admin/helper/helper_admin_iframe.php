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
 * @version   SVN: $Id: manufacturer.php 25466 2010-02-01 14:12:07Z alfonsas $
 */

/**
 * Returns template, that arranges two other templates ("manufacturer_list.tpl"
 * and "manufacturer_main.tpl") to frame.
 * Admin Menu: Settings -> Manufacturers
 * @package admin
 */
class Helper_Admin_Iframe extends oxAdminView
{
    /**
     * Current class template name.
     * @var string
     */
    protected $_sThisTemplate = '../../../modules/debugax/Admin/helper/Templates/frame.tpl';

}
