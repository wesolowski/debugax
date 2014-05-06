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
 * @version OXID eShop PE
 * @version   SVN: $Id: test_config.inc.php 26863 2010-03-26 09:43:10Z arvydas $
 */

// DO NOT TOUCH THIS _ INSTEAD FIX NOTICES - DODGER
error_reporting( (E_ALL ^ E_NOTICE) | E_STRICT );
ini_set('display_errors', true);

define ('OXID_PHP_UNIT', true);

function getShopBasePath()
{
    return oxPATH;
}

function getTestsBasePath()
{
    return realpath(dirname(__FILE__).'/../');
}

require_once 'test_utils.php';

// Generic utility method file.
require_once getShopBasePath() . 'core/oxfunctions.php';


/**
 * Useful for defining custom time
 */
class modOxUtilsDate extends oxUtilsDate
{
    protected $_sTime = null;

    public function UNITSetTime($sTime)
    {
        $this->_sTime = $sTime;
    }

    public function getTime()
    {
        if (!is_null($this->_sTime))
            return $this->_sTime;

        return parent::getTime();
    }
}

// Utility class
require_once getShopBasePath() . 'core/oxutils.php';

// Standard class
require_once getShopBasePath() . 'core/oxstdclass.php';

// Database managing class.
require_once getShopBasePath() . 'core/adodblite/adodb.inc.php';

// Session managing class.
require_once getShopBasePath() . 'core/oxsession.php';

// Database session managing class.
// included in session file if needed - require_once( getShopBasePath() . 'core/adodb/session/adodb-session.php');

// DB managing class.
//require_once( getShopBasePath() . 'core/adodb/drivers/adodb-mysql.inc.php');
require_once getShopBasePath() . 'core/oxconfig.php';

require_once getShopBasePath() . 'modules/functions.php';

function initDbDump()
{
    static $done = false;
    if ($done) {
        throw new Exception("init already done");
    }
    include_once 'unit/dbMaintenance.php';
    $dbM = new dbMaintenance();
    $dbM->dumpDB();
    $done = true;
}
initDbDump();
