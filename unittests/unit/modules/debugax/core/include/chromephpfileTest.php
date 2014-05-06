<?php
require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_include_chromephpFileTest extends OxidTestCase
{

    protected $sFileName = 'unit_test';

    protected $sContentTest = 'testUnit Oxid Debugax';
    /**
     * @covers chromephpFile
     */
    public function testClass()
    {
        $oTest = new chromephpFile;
        $this->assertTrue( $oTest instanceof chromephpFile  );
    }


    /**
     * @covers chromephpFile::_writeHeader
     */
    public function testWriteHeader()
    {

        $sTestClass     = $this->getProxyClassName('chromephpFile');
        $oTestObj       = $this->getMock($sTestClass, array('_getFileName'));
        $oTestObj->expects($this->once())
                 ->method('_getFileName')
                 ->will($this->returnValue( $this->sFileName ));
        $this->assertTrue( $oTestObj->UNITwriteHeader( $this->sContentTest ) );

        $sDirPath = $oTestObj->UNITgetFileFolderPath();
        $sTestFilePath = $sDirPath . $this->sFileName . '.json';
        $this->assertTrue( file_exists($sTestFilePath));

        $this->assertSame($this->sContentTest, json_decode(file_get_contents($sTestFilePath) ));
        unlink($sTestFilePath);

    }


    /**
     * @covers chromephpFile::_getFileName
     */
    public function testGetFileName()
    {
        $oTestObj = $this->getProxyClass('chromephpFile');
        $this->assertSame( '_shop', $oTestObj->UNITgetFileName() );
        modSession::getInstance()->setVar( 'debugPHP', 'test' );
        $this->assertSame( 'test_shop', $oTestObj->UNITgetFileName() );
    }

    /**
     * @covers chromephpFile::_getFileFolderPath
     */
    public function testGetFileFolderPath()
    {
        $oTestObj = $this->getProxyClass('chromephpFile');
        $sFolderPath = $oTestObj->UNITgetFileFolderPath();
        $this->assertType( 'string', $sFolderPath );
        $iResult = strpos($sFolderPath, 'modules/debugax/tmp/file');
        $this->assertType( 'int',$iResult );
    }

    /**
     * @covers chromephpFile::_writeFile
     */
    public function testWriteFile()
    {
        $oTestObj = $this->getProxyClass('chromephpFile');
        $sPath = $oTestObj->UNITgetFileFolderPath();
        $oTestObj->UNITwriteFile($this->sContentTest,$this->sFileName );
        $this->assertSame($this->sContentTest, json_decode(file_get_contents($sPath . $this->sFileName . '.json') ));
        $sTwoContent = $this->sContentTest . $this->sContentTest;
        $oTestObj->UNITwriteFile($sTwoContent,$this->sFileName );
        $this->assertSame($sTwoContent, json_decode(file_get_contents($sPath . $this->sFileName. '.json') ));
        unlink($sPath .  $this->sFileName. '.json');
    }
}