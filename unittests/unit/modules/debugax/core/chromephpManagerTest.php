<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_chromephpManagerTest extends OxidTestCase
{

    protected $sFileTestPath = null;
    /**
     * Initialize the fixture.
     *
     * @return null
     */
    protected function setUp()
    {
        $this->sFileTestPath = __DIR__ . DIRECTORY_SEPARATOR . 'test.json';
        parent::setUp();

    }

    /**
     * Executed after test is down
     *
     */
    protected function tearDown()
    {
        if(file_exists($this->sFileTestPath))
        {
            unlink($this->sFileTestPath);
        }
        parent::tearDown();
    }
    /**
     * @covers chromephpManager
     */
    public function testClass()
    {
        $oTestObj = new chromephpManager;
        $this->assertTrue( $oTestObj instanceof chromephpManager );

    }

    /**
     * @covers chromephpManager::_getFileManger
     */
    public function testGetFileManger()
    {
        $oTestObj = $this->getProxyClass('chromephpManager');
        $this->assertTrue( $oTestObj->UNITgetFileManger() instanceof fileManager );
    }

    /**
     * @covers chromephpManager::_getConfigPath
     */
    public function testGetConfigPath()
    {
        $oFileManeger = new fileManager();
        $oTestObj = $this->getProxyClass('chromephpManager');
        $sResult =  $oFileManeger->getTmpPath() . 'config.json';
        $this->assertNull( $oTestObj->getNonPublicVar( '_sConfigPath') );
        $this->assertSame($sResult, $oTestObj->UNITgetConfigPath() );
        $this->assertSame($sResult, $oTestObj->getNonPublicVar( '_sConfigPath') );
    }


    /**
     * @covers chromephpManager::getFunctionCheck
     */
    public function testGetFunctionCheck()
    {
        $oTestClass = oxNew('chromephpManager');
        $this->assertType('array', $oTestClass->getFunctionCheck());
    }

    /**
     * @covers chromephpManager::loadConfig
     */
    public function testLoadConfig()
    {
        $oDebugaxConfig = new Debugax_Config();
        $aResult = $oDebugaxConfig->getConfigFile();

        $oTestClass = oxNew('chromephpManager');
        $aConfig = $oTestClass->loadConfig();
        $this->assertType('array',$aConfig);
        $this->assertSame($aResult, $aConfig);
    }

    /**
     * @covers chromephpManager::saveConfig
     */
    public function testSaveConfigOnce()
    {
        $aUnitArray = array('debugActive' => 1, 'sqlCheck' => 'unit');
        $oTestFile   = $this->getMock('fileManager', array('changeAdodbFile', 'getBackup'));
        $oTestFile->expects($this->once())
                 ->method('changeAdodbFile')
                 ->will($this->returnValue(true));
        $oTestFile->expects($this->never())
                 ->method('getBackup');

        $oTestObj = $this->getMock('chromephpManager', array('_getFileManger', '_getConfigPath'));
        $oTestObj->expects($this->any())
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestFile));
        $oTestObj->expects($this->any())
                 ->method('_getConfigPath')
                 ->will($this->returnValue($this->sFileTestPath));
        $this->assertTrue($oTestObj->saveConfig($aUnitArray));
        $this->assertSame($this->_getTestArray(), $aUnitArray);
    }

    /**
     * @covers chromephpManager::saveConfig
     */
    public function testSaveConfigOnceFalse()
    {
        $aUnitArray = array('debugActive' => 1, 'sqlCheck' => 'unit');
        $oTestFile   = $this->getMock('fileManager', array('changeAdodbFile', 'getBackup'));
        $oTestFile->expects($this->once())
                 ->method('changeAdodbFile')
                 ->will($this->returnValue(false));
        $oTestFile->expects($this->never())
                 ->method('getBackup');

        $oTestObj = $this->getMock('chromephpManager', array('_getFileManger', '_getConfigPath'));
        $oTestObj->expects($this->any())
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestFile));
        $oTestObj->expects($this->any())
                 ->method('_getConfigPath')
                 ->will($this->returnValue($this->sFileTestPath));
        $this->assertFalse($oTestObj->saveConfig($aUnitArray));
    }

    /**
     * @covers chromephpManager::saveConfig
     */
    public function testSaveConfigTwo()
    {
        $aUnitArray = array('debugActive' => 0, 'sqlCheck' => 'unit');
        $oTestFile   = $this->getMock('fileManager', array('changeAdodbFile', 'getBackup'));
        $oTestFile->expects($this->once())
                 ->method('getBackup')
                 ->will($this->returnValue(true));
        $oTestFile->expects($this->never())
                 ->method('changeAdodbFile');

        $oTestObj = $this->getMock('chromephpManager', array('_getFileManger', '_getConfigPath'));
        $oTestObj->expects($this->any())
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestFile));
        $oTestObj->expects($this->any())
                 ->method('_getConfigPath')
                 ->will($this->returnValue($this->sFileTestPath));
        $this->assertTrue($oTestObj->saveConfig($aUnitArray));
        $this->assertSame($this->_getTestArray(), $aUnitArray);
    }

    /**
     * @covers chromephpManager::saveConfig
     */
    public function testSaveConfigTwoFalse()
    {
        $aUnitArray = array('debugActive' => 0, 'sqlCheck' => 'unit');
        $oTestFile   = $this->getMock('fileManager', array('changeAdodbFile', 'getBackup'));
        $oTestFile->expects($this->once())
                 ->method('getBackup')
                 ->will($this->returnValue(false));
        $oTestFile->expects($this->never())
                 ->method('changeAdodbFile');

        $oTestObj = $this->getMock('chromephpManager', array('_getFileManger', '_getConfigPath'));
        $oTestObj->expects($this->any())
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestFile));
        $oTestObj->expects($this->any())
                 ->method('_getConfigPath')
                 ->will($this->returnValue($this->sFileTestPath));
        $this->assertFalse($oTestObj->saveConfig($aUnitArray));
    }

    protected function _getTestArray()
    {
        return json_decode(file_get_contents($this->sFileTestPath), true);
    }
}