<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_view_helper_modulesTest extends OxidTestCase
{
    /**
     * @covers Helper_Modules
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Helper_Modules') instanceof Helper_Modules );
    }

    /**
     * @covers Helper_Modules
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/view/tpl/helper_modules.tpl';
        $oTestClass = oxNew('Helper_Modules');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }

    /**
     * @covers Helper_Modules::_getModuleManager
     */
    public function testGetModuleManager()
    {
        $oTestObj = $this->getProxyClass('Helper_Modules');
        $this->assertTrue( $oTestObj->UNITgetModuleManager() instanceof moduleManager );
    }


    /**
     * @covers Helper_Modules::render
     */
    public function testRenderTpl()
    {

        $oTestClass = oxNew('Helper_Modules');
        $this->assertSame( $oTestClass->render(), $oTestClass->getTemplateName());
        // $aViewData = $oTestClass->getViewData();
       // $this->assertType('array', $aViewData['aModules']);
    }


    /**
     * @covers Helper_Modules::_getProgress
     */
    public function testGetProgress()
    {
        $aTestArray = $this->_getTestFile();
        $oTestObj = $this->getProxyClass('Helper_Modules');
        $aResult = $oTestObj->UNITgetProgress( $aTestArray );
        $this->assertNull( $aResult );
        $aViewData = $oTestObj->getViewData();
        $this->assertSame($aViewData['iProgress'] , 3 );
    }


    /**
     * @covers Helper_Modules::_getModulesAnalize
     */
    public function testGetModulesAnalize()
    {
        modConfig::setParameter( "start", false );
        $oTestObj = $this->getProxyClass('Helper_Modules');
        $this->assertNull( $oTestObj->UNITgetModulesAnalize() );
    }

    /**
     * @covers Helper_Modules::_getModulesAnalize
     */
    public function testGetModulesAnalizeTwo()
    {
        modConfig::setParameter( "start", true );
        oxTestModules::addFunction('moduleManager', 'getModuleContentClass', '{ return true; }');
        oxTestModules::addFunction('moduleManagerAnalize', 'setAnalize', '{ return true; }');
        $oTestObj = $this->getProxyClass('Helper_Modules');
        $this->assertNull( $oTestObj->UNITgetModulesAnalize() );
    }

    /**
     * @covers Helper_Modules::_setModuleManager
     */
    public function testSetModuleManager()
    {
        $oTestObj = $this->getProxyClass('Helper_Modules');
        $this->assertNull( $oTestObj->UNITsetModuleManager() );

    }

    protected function _getTestFile()
    {
        return unserialize(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'modules.txt'));
    }

}