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
 * @package   tests
 * @copyright (C) OXID eSales AG 2003-2010
 * @version OXID eShop EE
  * @version   SVN: $Id: $
 */

if (getenv('oxPATH')) {
    define ('oxPATH', getenv('oxPATH'));
} else {
    if (!defined('oxPATH')) {
        die('oxPATH is not defined');
    }
}

if (!defined('OXID_VERSION_SUFIX')) {
    define('OXID_VERSION_SUFIX', '');
}


require_once 'unit/test_config.inc.php';

define('oxADMIN_LOGIN', oxDb::getDb()->getOne("select OXUSERNAME from oxuser where oxid='oxdefaultadmin'"));
if (getenv('oxADMIN_PASSWD')) {
    define('oxADMIN_PASSWD', getenv('oxADMIN_PASSWD'));
} else {
    define('oxADMIN_PASSWD', 'admin');
}


if (getenv('CODECOVERAGE')) {
    // PHPUnit_Util_Filter configuration
    PHPUnit_Util_Filter::$addUncoveredFilesFromWhitelist = true;



    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/chromephp/chromephp_admin_list.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/chromephp/chromephp_admin_file.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/chromephp/chromephp_admin.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/chromephp/chromephp_admin_perform.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/chromephp/chromephp_admin_main.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/helper/helper_admin_list.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/helper/helper_admin_modules.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/Admin/helper/helper_admin_iframe.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/testperformance.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/modulemanagerlist.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/filemanager.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/chromephpmanager.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/authorization.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/chromephp.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/modulemanager.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/mysqlmanager.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/modulemanageranalize.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/include/chromephpfile.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/include/chromephpmysqlreading.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/include/chromephpmysql.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/include/chromephpheader.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/core/include/chromephpblocked.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/extensions/chromephp_oxutilsview.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/extensions/chromephp_oxshopcontrol.php');
    PHPUnit_Util_Filter::addFileToWhitelist(oxPATH.'modules/debugax/view/helper_modules.php');

}


