<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_include_chromephpheaderTest extends OxidTestCase
{
    /**
     * @covers chromephpHeader
     */
    public function testClass()
    {
        $oTest = new chromephpHeader;
        $this->assertTrue( $oTest instanceof chromephpHeader  );
    }



    /**
     * @covers chromephpHeader::_writeHeader
     */
    public function testWriteHeader()
    {
        $oTestObj = $this->getProxyClass('chromephpHeader');
        $this->assertNull( $oTestObj->UNITwriteHeader( 'test') );
    }
}