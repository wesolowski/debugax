<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_helper_iframeTest extends OxidTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * @covers Helper_Admin_Iframe
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Helper_Admin_Iframe') instanceof Helper_Admin_Iframe);
    }

    /**
     * @covers Helper_Admin_Iframe
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/helper/Templates/frame.tpl';
        $oTestClass = oxNew('Helper_Admin_Iframe');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }
}
