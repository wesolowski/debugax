<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_include_chromephpmysqlreadingTest extends OxidTestCase
{
    /**
     * @covers chromephpMysqlReading
     */
    public function testClass()
    {
        $oTest = new chromephpMysqlReading;
        $this->assertTrue( $oTest instanceof chromephpMysqlReading  );
    }


    /**
     * @covers chromephpMysqlReading::getJsonResult
     */
    public function testGetJsonResult()
    {
        $oTest = new chromephpMysqlReading;
        $this->assertNull( $oTest->getJsonResult()  );
    }

    /**
     * @covers chromephpMysqlReading::_writeHeader
     */
    public function testWriteHeader()
    {
        $oTestObj = $this->getProxyClass('chromephpMysqlReading');
        $this->assertTrue( $oTestObj->UNITwriteHeader( 'test') );
    }
}