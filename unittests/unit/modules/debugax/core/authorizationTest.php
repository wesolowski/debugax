<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_authorizationTest extends OxidTestCase
{


    /**
     * @covers authorization
     */
    public function testClass()
    {
        $oTestObj = oxNew('authorization');
        $this->assertTrue( $oTestObj instanceof authorization );

    }


    /**
     * @covers authorization::_setClassReading
     */
    public function testSetClassReading()
    {
        $oTestClass = $this->getProxyClass('authorization');
        $bResult = $oTestClass->UNITgetClassReading();
        $this->assertFalse( $bResult );

        $oTestClass->UNITsetClassReading( true );
        $bResult = $oTestClass->UNITgetClassReading();
        $this->assertTrue( $bResult );
    }

    /**
     * @covers authorization::_getClassReading
     */
    public function testGetClassReading()
    {
        $oTestClass = $this->getProxyClass('authorization');
        $this->assertFalse( $oTestClass->UNITgetClassReading() );
    }

    /**
     * @covers authorization::_setAuthorization
     */
    public function testSetAuthorizationNull()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
                $oTestObj->expects($this->exactly(1))
                 ->method('_getConfig')
                 ->will($this->returnValue(null));
        $this->assertNull( $oTestObj->getAuthorization() );
    }

    /**
     * @covers authorization::_setAuthorization
     */
    public function testSetAuthorizationTrueIp()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
        $oTestObj->expects($this->exactly(3))
                 ->method('_getConfig')
                 ->will($this->returnValue(array('iAuthorization' => 2, 'sAuthorizationText' => $_SERVER['REMOTE_ADDR'])));
        $this->assertTrue( $oTestObj->getAuthorization() );
    }

    /**
     * @covers authorization::_setAuthorization
     */
    public function testSetAuthorizationFalseSufix()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
        $oTestObj->expects($this->exactly(3))
                 ->method('_getConfig')
                 ->will($this->returnValue(array('iAuthorization' => 3, 'sAuthorizationText' => 'test')));
        $this->assertFalse( $oTestObj->getAuthorization() );
    }

    /**
     * @covers authorization::getAuthorization
     */
    public function testGetAuthorization()
    {
        $oTestObj   = $this->getMock('authorization', array('_getConfig'));
                $oTestObj->expects($this->exactly(1))
                 ->method('_getConfig')
                 ->will($this->returnValue(null));
        $this->assertNull( $oTestObj->getAuthorization() );
    }

    /**
     * @covers authorization::_getConfig
     */
    public function testGetConfig()
    {

        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_setConfig'));
        $oTestObj->expects($this->once())
                 ->method('_setConfig')
                 ->will($this->returnValue( null ));
        $this->assertNull( $oTestObj->UNITgetConfig() );
    }

    /**
     * @covers authorization::_getConfig
     */
    public function testGetConfigArray()
    {
        $oTestClass = $this->getProxyClass('authorization');
        $this->assertType('array', $oTestClass->UNITgetConfig());
    }

    /**
     * @covers authorization::_setConfig
     */
    public function testSetConfig()
    {
        $oTestClass = $this->getProxyClass('authorization');
        $this->assertNull( $oTestClass->UNITsetConfig() );
        $this->assertType('array', $oTestClass->getNonPublicVar( "aConfig" ));

    }

    /**
     * @covers authorization::getClassName
     */
    public function testGetClassName()
    {
        $oTestObj   = $this->getMock('authorization', array('getAuthorization', '_getConfig'));
        $oTestObj->expects($this->at(0))
                 ->method('getAuthorization')
                 ->will($this->returnValue(null));
        $oTestObj->expects($this->at(1))
                 ->method('getAuthorization')
                 ->will($this->returnValue(false));
        $oTestObj->expects($this->at(2))
                 ->method('getAuthorization')
                 ->will($this->returnValue(true));
        $oTestObj->expects($this->at(3))
                 ->method('_getConfig')
                 ->will($this->returnValue( array("sendData" => 4) ));
        $this->assertSame( 'chromephp' , $oTestObj->getClassName() );
        $this->assertSame( 'chromephpblocked' , $oTestObj->getClassName() );
        $this->assertSame( 'chromephpMysqlReading' , $oTestObj->getClassName( true ) );
    }

    /**
     * @covers authorization::_checkServer
     */
    public function testCheckServer()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
        $oTestObj->expects($this->at(0))
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sAuthorizationText' => $_SERVER['REMOTE_ADDR']) ));
        $oTestObj->expects($this->at(1))
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sAuthorizationText' => '123') ));
        $this->assertTrue( $oTestObj->UNITcheckServer() );
        $this->assertFalse( $oTestObj->UNITcheckServer() );
    }

    /**
     * @covers authorization::_checkAuthorization
     */
    public function testCheckAuthorizationCheckServer()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_checkServer'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('iAuthorization' => 2) ));
        $oTestObj->expects($this->once())
                 ->method('_checkServer')
                 ->will($this->returnValue( true ));
        $oTestObj->expects($this->never())
                 ->method('_checkSufix');
        $this->assertTrue( $oTestObj->UNITcheckAuthorization() );
    }

    /**
     * @covers authorization::_checkAuthorization
     */
    public function testCheckAuthorizationCheckSufix()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_checkSufix'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('iAuthorization' => 3) ));
        $oTestObj->expects($this->once())
                 ->method('_checkSufix')
                 ->will($this->returnValue( true ));
        $oTestObj->expects($this->never())
                 ->method('_checkServer');
        $this->assertTrue( $oTestObj->UNITcheckAuthorization() );
    }

    /**
     * @covers authorization::_checkAuthorization
     */
    public function testCheckAuthorization()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('iAuthorization' => 'unit') ));

        $oTestObj->expects($this->never())
                 ->method('_checkServer');
        $oTestObj->expects($this->never())
                 ->method('_checkSufix');

        $this->assertFalse( $oTestObj->UNITcheckAuthorization() );
    }

    /**
     * @covers authorization::_checkSufix
     */
    public function testCheckSufix()
    {
        $_GET['test'] = true;
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig'));
        $oTestObj->expects($this->at(0))
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sAuthorizationText' => 'test') ));
        $oTestObj->expects($this->at(1))
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sAuthorizationText' => '123') ));
        $this->assertTrue( $oTestObj->UNITcheckSufix() );
        $this->assertFalse( $oTestObj->UNITcheckSufix() );
    }

    /**
     * @covers authorization::_getClassNameByConfig
     */
    public function testGetClassNameByConfigChromephpMysqlReading()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_getClassReading'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sendData' => 'test') ));
        $oTestObj->expects($this->once())
                 ->method('_getClassReading')
                 ->will($this->returnValue( true ));
        $this->assertSame( 'chromephpMysqlReading' , $oTestObj->UNITgetClassNameByConfig() );
    }

    /**
     * @covers authorization::_getClassNameByConfig
     */
    public function testGetClassNameByConfigChromephpHeader()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_getClassReading'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sendData' => 1) ));
        $oTestObj->expects($this->once())
                 ->method('_getClassReading')
                 ->will($this->returnValue( false ));
        $this->assertSame( 'chromephpHeader' , $oTestObj->UNITgetClassNameByConfig() );
    }

    /**
     * @covers authorization::_getClassNameByConfig
     */
    public function testGetClassNameByConfigChromephpFile()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_getClassReading'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sendData' => 2) ));
        $oTestObj->expects($this->once())
                 ->method('_getClassReading')
                 ->will($this->returnValue( false ));
        $this->assertSame( 'chromephpFile' , $oTestObj->UNITgetClassNameByConfig() );
    }

    /**
     * @covers authorization::_getClassNameByConfig
     */
    public function testGetClassNameByConfigChromephpMysql()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_getClassReading'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sendData' => 3) ));
        $oTestObj->expects($this->once())
                 ->method('_getClassReading')
                 ->will($this->returnValue( false ));
        $this->assertSame( 'chromephpMysql' , $oTestObj->UNITgetClassNameByConfig() );
    }

    /**
     * @covers authorization::_getClassNameByConfig
     */
    public function testGetClassNameByConfigChromephp()
    {
        $sTestClass = $this->getProxyClassName('authorization');
        $oTestObj   = $this->getMock($sTestClass, array('_getConfig', '_getClassReading'));
        $oTestObj->expects($this->once())
                 ->method('_getConfig')
                 ->will($this->returnValue( array('sendData' => 'unit') ));
        $oTestObj->expects($this->once())
                 ->method('_getClassReading')
                 ->will($this->returnValue( false ));
        $this->assertSame( 'chromephp' , $oTestObj->UNITgetClassNameByConfig() );
    }
}