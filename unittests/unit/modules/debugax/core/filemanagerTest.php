<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_fileManagerTest extends OxidTestCase
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
     * @covers fileManager
     */
    public function testClass()
    {
        $oTestObj = new fileManager;
        $this->assertTrue( $oTestObj instanceof fileManager );
    }

    /**
     * @covers fileManager::init
     */
    public function testInit()
    {
        $oTestClass = $this->getProxyClass('fileManager');
        $this->assertNull( $oTestClass->init() );
        $this->assertNotNull($oTestClass->getNonPublicVar('_sTmpPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sSourcePath'));


        $this->assertNotNull($oTestClass->getNonPublicVar('_sMysqlDriverPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sAdodbPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sAdodbPerfPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sPearModulePath'));

        $this->assertNotNull($oTestClass->getNonPublicVar('_sBackupMysqlDriverPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sBackupAdodbPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sBackupAdodbPerfPath'));
        $this->assertNotNull($oTestClass->getNonPublicVar('_sBackupPearModulePath'));

        $this->assertNotNull($oTestClass->getNonPublicVar('_bBackupStatus'));
    }

    /**
     * @covert fileManager::debugTxt
     */
    public function testDebugTxt()
    {
        $sTestFileName = 'unit';
        $oTestClass = $this->getProxyClass('fileManager');
        $sTmpFile = $oTestClass->getNonPublicVar('_sTmpPath') . 'perform' . DIRECTORY_SEPARATOR . $sTestFileName . '.txt';
        $this->assertFalse(file_exists($sTmpFile));
        $this->assertNull( $oTestClass->debugTxt($sTestFileName) );
        $this->assertTrue(file_exists($sTmpFile));
        for ($iVar=2; $iVar < 5; $iVar++)
        {
            $oTestClass->debugTxt($sTestFileName);
            $this->assertSame($iVar, count(file($sTmpFile)));
        }
        unlink($sTmpFile);
    }

    /**
     * @covert fileManager::getFileInfo
     */
    public function testGetFileInfo()
    {
        $sTestFileName = 'unit';
        $oTestClass = $this->getProxyClass('fileManager');
        $sTmpPath = $oTestClass->getNonPublicVar('_sTmpPath') . 'file' . DIRECTORY_SEPARATOR;
        $sFileOne = $sTmpPath . 'unit.txt';
        $sToday = date('d.m.Y');
        file_put_contents($sFileOne, "123123123456132156013512313");
        $aResult = $oTestClass->getFileInfo();
        $this->assertSame($sToday, substr( $aResult[basename($sFileOne)][1], 0, 10));
        $this->assertSame( 0.03, $aResult[basename($sFileOne)][2]);
        $this->assertSame( (double)0, $aResult[basename($sFileOne)][3]);
        unlink($sFileOne);
    }

    /**
     * @covert fileManager::getDirFileUrl
     */
    public function testGetDirFileUrl()
    {
        $oClass = new fileManager();
        $this->assertSame('/modules/debugax/tmp/file/', $oClass->getDirFileUrl());
    }

    /**
     * @covers fileManager::changeAdodbFile
     */
    public function testChangeAdodbFileTrue()
    {
        $oTestObj = $this->getMock('fileManager', array('_checkConfigParams', '_getFileBySendConfig'));
        $oTestObj->expects($this->once())
                 ->method('_checkConfigParams')
                 ->with(array('test'))
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->once(1))
                 ->method('_getFileBySendConfig')
                 ->will($this->returnValue(true));
        $this->assertTrue($oTestObj->changeAdodbFile(array('test')));
    }

    /**
     * @covers fileManager::changeAdodbFile
     */
    public function testChangeAdodbFileFalse()
    {
        $oTestObj = $this->getMock('fileManager', array('_checkConfigParams', '_getFileBySendConfig'));
        $oTestObj->expects($this->once())
                 ->method('_checkConfigParams')
                 ->with(array('test'))
                 ->will($this->returnValue(false));
        $oTestObj->expects($this->never())
                 ->method('_getFileBySendConfig');
        $this->assertFalse($oTestObj->changeAdodbFile(array('test')));
    }

    /**
     * @covers fileManager::_checkConfigParams
     */
    public function testCheckConfigParams()
    {
        $aTestArray = array('filter' => 0, 'debugActive' => 0, 'sendData'=> 0 , 'sqlCheck' => 0);
        $sTestClass     = $this->getProxyClassName('fileManager');
        $oTestObj       = $this->getMock($sTestClass, array('_setConfig'));
        $oTestObj->expects($this->once())
                 ->method('_setConfig')
                 ->with( $aTestArray)
                 ->will($this->returnValue(true));

        $this->assertTrue($oTestObj->UNITcheckConfigParams($aTestArray));
        $this->assertFalse($oTestObj->UNITcheckConfigParams(array('test')));
    }

    /**
     * @covert fileManager::createDir
     */
    public function testCreateDir()
    {
        $sTestDir = __DIR__ . DIRECTORY_SEPARATOR . 'unit';
        $oClass = new fileManager();
        $this->assertNull( $oClass->createDir( $sTestDir ));
        $this->assertTrue( is_dir($sTestDir) );
        rmdir($sTestDir);
    }

    /**
     * @covers fileManager::_isFilePathAllowed
     */
    public function testIsFilePathAllowed()
    {
        $oTestClass = $this->getProxyClass('fileManager');
        $aTestFile = array(
            'testPerformance', 'countAllSql', 'showAllSql', 'showAllCud',
            'errorSql', 'showAllSqlBacktrace', 'showAllCudBacktrace'
        );
        foreach ($aTestFile as  $sFileName)
        {
            $sFile = __DIR__ . DIRECTORY_SEPARATOR . $sFileName . '.inc';
            file_put_contents($sFile, 'test');
            $this->assertTrue($oTestClass->UNITisFilePathAllowed($sFile));
            unlink($sFile);
            $this->assertFalse($oTestClass->UNITisFilePathAllowed($sFile));
        }

        $sFile = __DIR__ . DIRECTORY_SEPARATOR . 'test.inc';
        file_put_contents($sFile, 'test');
        $this->assertFalse($oTestClass->UNITisFilePathAllowed($sFile));
        unlink($sFile);
    }

    /**
     * @covert fileManager::getMysqlDriverBackup
     */
    public function testGetMysqlDriverBackup()
    {
        $oTestClass = $this->getProxyClass('fileManager');
        $oTestClass->setNonPublicVar('_bBackupStatus', false);
        $this->assertFalse( $oTestClass->getMysqlDriverBackup() );
        $sMysqDriverPathTest = $oTestClass->getNonPublicVar('_sMysqlDriverPath') . 'unitTest';
        $oTestClass->setNonPublicVar('_bBackupStatus', true);
        $oTestClass->setNonPublicVar('_sMysqlDriverPath', $sMysqDriverPathTest);
        $this->assertTrue( $oTestClass->getMysqlDriverBackup() );
        $sMysqDriverBackaupPath = $oTestClass->getNonPublicVar('_sBackupMysqlDriverPath');
        $this->assertSame(filesize($sMysqDriverBackaupPath), filesize($sMysqDriverPathTest));
        unlink($sMysqDriverPathTest);
    }

    /**
     * @covers fileManager::getBackup
     */
    public function testGetBackup()
    {
        $oTestObj = $this->getMock('fileManager', array('getMysqlDriverBackup', 'getAdodbBackup'));
        $oTestObj->expects($this->at(0))
                 ->method('getMysqlDriverBackup')
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->at(1))
                 ->method('getAdodbBackup')
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->at(2))
                 ->method('getMysqlDriverBackup')
                 ->will($this->returnValue(false));
        $oTestObj->expects($this->at(3))
                 ->method('getAdodbBackup')
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->at(4))
                 ->method('getMysqlDriverBackup')
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->at(5))
                 ->method('getAdodbBackup')
                 ->will($this->returnValue(false));
        $this->assertTrue($oTestObj->getBackup());
        $this->assertFalse($oTestObj->getBackup());
        $this->assertFalse($oTestObj->getBackup());
    }

    /**
     * @covert fileManager::getAdodbBackup
     */
    public function testGetAdodbBackup()
    {
        $oTestClass = $this->getProxyClass('fileManager');
        $oTestClass->setNonPublicVar('_bBackupStatus', false);
        $this->assertFalse( $oTestClass->getAdodbBackup() );
        // $sMysqDriverPathTest = $oTestClass->getNonPublicVar('_sMysqlDriverPath') . 'unitTest';
        // $oTestClass->setNonPublicVar('_bBackupStatus', true);
        // $oTestClass->setNonPublicVar('_sMysqlDriverPath', $sMysqDriverPathTest);
        // $this->assertTrue( $oTestClass->getMysqlDriverBackup() );
        // $sMysqDriverBackaupPath = $oTestClass->getNonPublicVar('_sBackupMysqlDriverPath');
        // $this->assertSame(filesize($sMysqDriverBackaupPath), filesize($sMysqDriverPathTest));
        // unlink($sMysqDriverPathTest);
    }
}