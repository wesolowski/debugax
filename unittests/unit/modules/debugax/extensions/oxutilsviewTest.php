<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_extensions_oxutilsviewTest extends OxidTestCase
{


    /**
     * @covers chromephp_oxutilsview
     */
    public function testClass()
    {
        $oTestObj = oxNew('oxutilsview');
        $this->assertTrue( $oTestObj instanceof chromephp_oxutilsview );

    }

    /**
     * @covers chromephp_oxutilsview::getSmarty
     */
    public function testGetSmarty()
    {
        $sTest = getShopBasePath() . 'modules/debugax/smarty';
        $oTestClass = $this->getMock('chromephp_oxutilsview', array('_debugaxGetPluginDirectories'));
        $oTestClass->expects($this->once())
                   ->method('_debugaxGetPluginDirectories')
                   ->will($this->returnValue($sTest));
        $this->assertTrue($oTestClass->getSmarty() instanceof Smarty);
    } // function

    /**
     * @covers chromephp_oxutilsview::_debugaxGetPluginDirectories
     */
    public function testDebuaxGetPluginDirectories()
    {
        $oTestClass = $this->getProxyClass('chromephp_oxutilsview');
        $sTest = $oTestClass->UNITdebugaxGetPluginDirectories();
        $bTest = (strpos($sTest, 'modules'.DIRECTORY_SEPARATOR.'debugax'.DIRECTORY_SEPARATOR.'smarty') !== false)
                    ? true : false;
        $this->assertType('string', $sTest);
        $this->assertTrue($bTest );

    } // function

    /**
     * @covers chromephp_oxutilsview::getSmarty
     */
    public function testGetSmartyTwo()
    {
        $oTestClass = oxNew('oxutilsview');
        $this->assertTrue($oTestClass->getSmarty() instanceof Smarty);
    } // function
}