<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_chromephp_listTest extends OxidTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * @covers Chromephp_Admin_List
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Chromephp_Admin_List') instanceof Chromephp_Admin_List);
    }

    /**
     * @covers Chromephp_Admin_List
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/chromephp/Templates/list.tpl';
        $oTestClass = oxNew('Chromephp_Admin_List');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }


}
