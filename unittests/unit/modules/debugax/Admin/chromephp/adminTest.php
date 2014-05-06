<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_chromephp_adminTest extends OxidTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * @covers Chromephp_Admin
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Chromephp_Admin') instanceof Chromephp_Admin);
    }

    /**
     * @covers Chromephp_Admin
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/chromephp/Templates/frame.tpl';
        $oTestClass = oxNew('Chromephp_Admin');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }
}
