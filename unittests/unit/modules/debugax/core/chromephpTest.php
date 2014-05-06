<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_chromephpTest extends OxidTestCase
{
    protected function setUp()
    {
        parent::setUp();
        ob_start();
    }

    protected function tearDown()
    {
        header_remove();
        parent::tearDown();
    }
    /**
     * @covers chromephp
     */
    public function testClass()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertTrue( $oTestObj instanceof chromephp );

    }

    /**
     * @covers chromephp::getInstance
     */
    public function testGetInstance()
    {
        $oTestObj = oxNew('chromephp');
        $oTestObj->clearSingelton();
        $this->assertTrue($oTestObj->getInstance(true) instanceof chromephp);
    }

    /**
     * @covers chromephp::clearSingelton
     */
    public function testClearSingelton()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull($oTestObj->clearSingelton() );
    }


    /**
     * @covers chromephp::_getOxidInstance
     */
    public function testGetOxidInstance()
    {
        $oTestObj = $this->getProxyClass('chromephp');
        $oTestObj->clearSingelton();
        $oTestObj->UNITsetClassName();
        $this->assertNull($oTestObj->UNITgetOxidInstance());
    }

    /**
     * @covers chromephp::_getPhpInstance
     */
    public function testGetPhpInstance()
    {
        $oTestObj = $this->getProxyClass('chromephp');
        $oTestObj->clearSingelton();
        $oTestObj->UNITsetClassName();
        $this->assertNull($oTestObj->UNITgetPhpInstance());
    }

    /**
     * @covers chromephp::log
     */
    public function testLog()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->log() );
        $this->assertNull( $oTestObj->log('test', 'test2', 'log') );
    }

    /**
     * @covers chromephp::Warn
     */
    public function testWarn()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->warn() );
    }

    /**
     * @covers chromephp::Error
     */
    public function testError()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->error() );
    }

    /**
     * @covers chromephp::Group
     */
    public function testGroup()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->group() );
    }

    /**
     * @covers chromephp::Info
     */
    public function testInfo()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->info() );
    }

    /**
     * @covers chromephp::GroupEnd
     */
    public function testGroupEnd()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->groupEnd() );
    }

    /**
     * @covers chromephp::GroupCollapsed
     */
    public function testGroupCollapsed()
    {
        $oTestObj = oxNew('chromephp');
        $this->assertNull( $oTestObj->groupCollapsed() );
    }

    /**
     * @covers chromephp::_setClassName
     */
    public function testGetClassName()
    {
        $oTestClass = $this->getProxyClass('chromephp');
        $this->assertNull($oTestClass->UNITsetClassName( true ));
    }

    /**
     * @covers chromephp::_log
     */
    public function testProtectedLogFirstReturn()
    {
        $sTestClass = $this->getProxyClassName('chromephp');
        $oTestObj   = $this->getMock($sTestClass, array('_convert', 'getSetting', '_addRow'));
        $oTestObj->expects($this->never())
                 ->method('_convert');
        $oTestObj->expects($this->never())
                 ->method('getSetting');
        $oTestObj->expects($this->never())
                 ->method('_addRow');
        $this->assertNull($oTestObj->UNITlog( array('type' => 'groupEnd') ));
    }

    /**
     * @covers chromephp::_log
     */
    public function testProtectedLogFirstReturnTwo()
    {
        $sTestClass = $this->getProxyClassName('chromephp');
        $oTestObj   = $this->getMock($sTestClass, array('_convert', 'getSetting', '_addRow'));
        $oTestObj->expects($this->never())
                 ->method('_convert');
        $oTestObj->expects($this->never())
                 ->method('getSetting');
        $oTestObj->expects($this->never())
                 ->method('_addRow');
        $this->assertNull($oTestObj->UNITlog( array() ));
    }


    /**
     * @covers chromephp::_log
     */
    public function testProtectedLogTwoArgs()
    {
        $oTestClass = $this->getProxyClass('chromephp');
        $this->assertNull($oTestClass->UNITlog( array( 'test', 'unit') ));
    }

    /**
     * @covers chromephp::_convert
     */
    public function testConvert()
    {
        $oTestClass = $this->getProxyClass('chromephp');
        $aTest = array( 'test', 'unit');
        $this->assertSame($oTestClass->UNITconvert( $aTest ), $aTest);

        $aResultOnce = array(
          '___class_name' => 'TestConvert',
          'aTest' =>
          array(
            0 => 'unit',
            1 => 'test',
          ),
          'sId' => 'myUnitId',
        );

        $aResultTwo = array(
          '___class_name' => 'TestConvertTwo',
          'oObj' =>
          array(
            '___class_name' => 'TestConvert',
            'aTest' =>
            array(
              0 => 'unit',
              1 => 'test',
            ),
            'sId' => 'myUnitId',
          ),
          'aTest' =>
          array(
            0 => 'unit',
            1 => 'test',
          ),
          'sId' => 'myUnitId',
          'protected aTestTwo' =>
          array(
            0 => 'unit',
            1 => 'test',
          ),
          'private sIdTwo' => 'myUnitId',
        );

        $this->assertSame($oTestClass->UNITconvert( new TestConvert() ), $aResultOnce);
        $this->assertSame($oTestClass->UNITconvert( new TestConvertTwo() ), $aResultTwo);
        $this->assertSame($oTestClass->UNITconvert( new TestConvert() ), $aResultOnce);
        $this->markTestIncomplete('Waiting for More Time');

    }

    /**
     * @covers chromephp::_getPropertyKey
     */
    public function testGetPropertyKey()
    {
        $aResultTest = array(
            'protected aTestTwo',
            'private sIdTwo',
            'public oObj',
            'public aTest',
            'public sId',
        );
        $oTestClass = $this->getProxyClass('chromephp');
        $aTest = array( 'test', 'unit');
        $reflection = new ReflectionClass( 'TestConvertTwo' );
        $iKey = 0;
        foreach ($reflection->getProperties() as $property)
        {
            $this->assertSame($aResultTest[$iKey], $oTestClass->UNITgetPropertyKey( $property ));
            $iKey++;
        }
    }

    /**
     * @covers chromephp::_addRow
     */
    public function testAddRow()
    {
        $oTestClass = $this->getProxyClass('chromephp');
        $this->assertSame(array(), $oTestClass->getNonPublicVar('_backtraces'));
        $aJson = array(
          'version' => '3.0',
          'columns' =>
          array(
            'label',
            'log',
            'backtrace',
            'type',
          ),
          'rows' =>
          array(
          ),
          'request_uri' => NULL,
        );
        $this->assertSame($aJson, $oTestClass->getNonPublicVar('_json'));
        $aJson = array(
          'version' => '3.0',
          'columns' =>
          array(
            'label',
            'log',
            'backtrace',
            'type',
          ),
          'rows' =>
          array(array(
              'test1',
              'test2',
              'test3',
              'test4',
            ),
          ),
          'request_uri' => NULL,
        );

        $this->assertNull($oTestClass->UNITaddRow( 'test1', 'test2', 'test3', 'test4' ));
        $this->assertSame(array('test3'), $oTestClass->getNonPublicVar('_backtraces'));
        $this->assertSame($aJson, $oTestClass->getNonPublicVar('_json'));

        $oTestClass->setNonPublicVar('_backtraces', array('test3', 'unitTest'));
        $this->assertNull($oTestClass->UNITaddRow( 'test1', 'test2', 'test3', 'test4' ));
        $aJson = array(
          'version' => '3.0',
          'columns' =>
          array('label', 'log', 'backtrace', 'type', ),
          'rows' =>
          array(
            array('test1', 'test2', 'test3', 'test4', ),
            array('test1', 'test2', NULL, 'test4', ),
          ),
          'request_uri' => NULL,
        );
        $this->assertSame($aJson, $oTestClass->getNonPublicVar('_json'));
    }

    /**
     * @covers chromephp::_writeHeader
     */
    public function testWriteHeader()
    {
        $oTestClass = $this->getProxyClass('chromephp');
        $this->assertNull($oTestClass->UNITwriteHeader( array('test') ));
    }

    /**
     * @covers chromephp::_encode
     */
    public function testEncode()
    {
        $sTest = 'unittest';
        $oTestClass = $this->getProxyClass('chromephp');
        $this->assertSame(base64_encode(utf8_encode(json_encode($sTest))), $oTestClass->UNITencode( $sTest ));
    }

    /**
     * @covers chromephp::addSetting
     */
    public function testAddSetting()
    {
        $sKey = 'UnitKey';
        $sValue = 'UnitValue';
        $oTestClass = new chromephp;
        $this->assertNull($oTestClass->addSetting( $sKey, $sValue ));
        $this->assertSame($sValue, $oTestClass->getSetting($sKey));
    }

    /**
     * @covers chromephp::addSettings
     */
    public function testAddSettings()
    {
        $aTest = array(
            'UnitKey' => 'UnitValue',
            'UnitKey2' => 'UnitValue2'
        );
        $oTestClass = new chromephp;
        $this->assertNull($oTestClass->addSettings( $aTest ));
        foreach ($aTest as $sKey => $sValue)
        {
            $this->assertSame($sValue, $oTestClass->getSetting($sKey));
        }
    }

    /**
     * @covers chromephp::getSetting
     */
    public function testgetSetting()
    {
        $sKey = 'UnitTest';
        $oTestClass = new chromephp;
        $this->assertNull($oTestClass->getSetting( '123456' ));
        $oTestClass->addSetting( $sKey, true );
        $this->assertTrue($oTestClass->getSetting( $sKey ));
    }

}

class TestConvert
{
    public $aTest = array('unit', 'test');
    public $sId = 'myUnitId';

    public function testPub() {}
    public function testPubTwo() {}
}

class TestConvertTwo extends TestConvert
{
    protected $aTestTwo = array('unit', 'test');
    private $sIdTwo = 'myUnitId';
    public $oObj = null;


    public function __construct()
    {
        $this->oObj = new TestConvert;
    }
    protected function testPro() {}
    protected function testProTwo() {}
}