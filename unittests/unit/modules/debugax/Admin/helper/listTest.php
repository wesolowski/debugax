<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_helper_listTest extends OxidTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * @covers Helper_Admin_List
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Helper_Admin_List') instanceof Helper_Admin_List);
    }

    /**
     * @covers Helper_Admin_List
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/helper/Templates/list.tpl';
        $oTestClass = oxNew('Helper_Admin_List');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }


}
