<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_helper_modulesTest extends OxidTestCase
{
    /**
     * @covers Helper_Admin_Modules
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Helper_Admin_Modules') instanceof Helper_Admin_Modules );
    }

    /**
     * @covers Helper_Admin_Modules
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/helper/Templates/modules.tpl';
        $oTestClass = oxNew('Helper_Admin_Modules');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }

    /**
     * @covers Helper_Admin_Modules::_getModuleManager
     */
    public function testGetModuleManager()
    {
        $oTestObj = $this->getProxyClass('Helper_Admin_Modules');
        $this->assertTrue( $oTestObj->UNITgetModuleManager() instanceof moduleManager );
    }


    /**
     * @covers Helper_Admin_Modules::render
     */
    public function testRenderTpl()
    {
        $oTestClass = oxNew('Helper_Admin_Modules');
        $this->assertSame( $oTestClass->render(), $oTestClass->getTemplateName());
        $aViewData = $oTestClass->getViewData();
        $this->assertType('array', $aViewData['aModules']);
    }

    /**
     * @covers Helper_Admin_Modules::_setModuleManager
     */
    public function testSetModuleManager()
    {
        $oTestObj = $this->getProxyClass('Helper_Admin_Modules');
        $this->assertNull( $oTestObj->UNITsetModuleManager() );
    }
}