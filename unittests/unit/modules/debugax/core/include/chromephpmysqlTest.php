<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_include_chromephpmysqlTest extends OxidTestCase
{
    /**
     * Initialize the fixture.
     *
     * @return null
     */
    protected function setUp()
    {
        parent::setUp();

        $oMyslqManager = new mysqlManager;

        if(!$oMyslqManager->checkDebugphpLogTable())
        {
            $oMyslqManager->setDebugphpLogTable();
        }
    }

    /**
     * @covers chromephpMySql
     */
    public function testClass()
    {
        $oTest = new chromephpMySql;
        $this->assertTrue( $oTest instanceof chromephpMySql  );
    }



    /**
     * @covers chromephpMySql::_writeHeader
     */
    public function testWriteHeader()
    {
        $sTestClass     = $this->getProxyClassName('chromephpMySql');
        $oTestObj       = $this->getMock($sTestClass, array('_saveResultToMysql'));
        $oTestObj->expects($this->once())
                 ->method('_saveResultToMysql')
                 ->will($this->returnValue( null ));
        $this->assertTrue( $oTestObj->UNITwriteHeader( 'test') );
    }

    // modSession
    /**
     * @covers chromephpMySql::_saveResultToMysql
     */
    public function testSaveResultToMysql()
    {
        modSession::getInstance()->setVar( 'debugPHP', 'oxidTest' );
        // $oTest = new chromephpMySql();
        // $oTest->log('testUnit', 'unit');
        $oTestObj = $this->getProxyClass('chromephpMySql');
        $this->assertNull( $oTestObj->UNITsaveResultToMysql() );
        // $sCheckOxid = oxDb::getDb( oxDB::FETCH_MODE_ASSOC )->getOne( "select oxid from oxactions2article where oxactionid = '".$this->_oAction->getId()."' and oxartid = '$sArtOxid' ");
    }

    /**
     * @covers chromephpMySql::_getLogArray
     */
    public function testGetLogArray()
    {
        $oTestObj = $this->getProxyClass('chromephpMySql');
        $this->assertType('array', $oTestObj->UNITgetLogArray() );
        $this->assertSame( 6, count($oTestObj->UNITgetLogArray()) );
    }
}