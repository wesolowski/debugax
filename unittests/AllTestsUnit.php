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
 * @version   SVN: $Id: $
 */

if (getenv('OXID_TEST_UTF8')) {
    define ('oxTESTSUITEDIR', 'unitUtf8');
} else {
    define ('oxTESTSUITEDIR', 'unit');
}

require_once 'PHPUnit/Framework/TestSuite.php';
error_reporting( (E_ALL ^ E_NOTICE) | E_STRICT );
ini_set('display_errors', true);

echo "=========\nrunning php version ".phpversion()."\n\n============\n";

require_once 'unit/test_config.inc.php';

/**
 * PHPUnit_Framework_TestCase implemetnation for adding and testing all unit tests from unit dir
 */
class AllTestsUnit extends PHPUnit_Framework_TestCase
{
    /**
     * Test suite
     *
     * @return object
     */
    static function suite()
    {
        $oSuite = new PHPUnit_Framework_TestSuite( 'PHPUnit' );
        $sFilter = getenv("PREG_FILTER");
        //foreach ( array( oxTESTSUITEDIR, oxTESTSUITEDIR.'/admin', oxTESTSUITEDIR.'/core', oxTESTSUITEDIR.'/views', oxTESTSUITEDIR.'/maintenance', oxTESTSUITEDIR.'/setup' ) as $sDir ) {
        $aTestDirs = array('', 'core', 'maintenance', 'views', 'admin', 'setup');
        if (getenv('TEST_DIRS')) {
            $aTestDirs = explode('%', getenv('TEST_DIRS'));
        }
        foreach ($aTestDirs as $sDir ) {
            if ($sDir == '_root_') {
                $sDir = '';
            }
            $sDir = rtrim(oxTESTSUITEDIR.'/'.$sDir, '/');
            //adding UNIT Tests
            echo "Adding unit tests from $sDir/*Test.php\n";
            foreach ( glob( "$sDir/*Test.php" ) as $sFilename) {
                if (!$sFilter || preg_match("&$sFilter&i", $sFilename)) {
                    error_reporting( (E_ALL ^ E_NOTICE) | E_STRICT );
                    ini_set('display_errors', true);

                    include_once $sFilename;
                    $sClassName = str_replace( array( "/", ".php" ), array( "_", "" ), $sFilename );

                    if ( class_exists( $sClassName ) ) {
                        $oSuite->addTestSuite( $sClassName );
                    } else {
                        echo "\n\nWarning: class not found: $sClassName in $sFilename\n\n\n ";
                    }
                } else {
                    echo "skiping $sFilename\n";
                }
            }
        }

        return $oSuite;
    }
}
