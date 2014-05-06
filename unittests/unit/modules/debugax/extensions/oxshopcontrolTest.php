<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_extensions_oxshopcontrolTest extends OxidTestCase
{
    /**
     * @covers chromephp_oxshopcontrol
     */
    public function testClass()
    {
        ob_start();
        $oTestObj = oxNew('oxshopcontrol');
        $this->assertTrue( $oTestObj instanceof chromephp_oxshopcontrol );
        $txt = ob_get_clean();
        $this->assertType( 'string', $txt );

    }

    /**
     * @covers chromephp_oxshopcontrol::start
     */
    public function testStart()
    {
        $oTestClass = $this->getMock('chromephp_oxshopcontrol', array('_checkAuthorization'));
        $oTestClass->expects($this->once())
                   ->method('_checkAuthorization')
                   ->will($this->returnValue(null));
        $this->assertNull( $oTestClass->start() );
    }

    /**
     * @covers chromephp_oxshopcontrol::_enableChrome
     */
    public function testEnableChrome()
    {
        $sTestClass     = $this->getProxyClassName('chromephp_oxshopcontrol');
        $oTestObj       = $this->getMock($sTestClass, array('_getConfigFile'));
        $oTestObj->expects($this->at(0))
                 ->method('_getConfigFile')
                 ->will($this->returnValue(array('filter' => array('usermodel' => 0))));
        $oTestObj->expects($this->at(1))
                 ->method('_getConfigFile')
                 ->will($this->returnValue(array('info' => 1)));
        $oTestObj->expects($this->at(2))
                 ->method('_getConfigFile')
                 ->will($this->returnValue(array('sendData' => 3)));

        $this->assertNull( $oTestObj->UNITenableChrome() );
        $this->assertNull( $oTestObj->UNITenableChrome() );
        $this->assertNull( $oTestObj->UNITenableChrome() );
    }


    /**
     * @covers chromephp_oxshopcontrol::_checkAuthorization
     */
    public function testCheckAuthorization()
    {
        $oTestAuth   = $this->getMock('authorization', array('getAuthorization'));
        $oTestAuth->expects($this->at(0))
                 ->method('getAuthorization')
                 ->will($this->returnValue(true));
        $oTestAuth->expects($this->at(1))
                 ->method('getAuthorization')
                 ->will($this->returnValue(false));

        $sTestClass = $this->getProxyClassName('chromephp_oxshopcontrol');
        $oTestObj   = $this->getMock($sTestClass, array('_getAuthorization'));
        $oTestObj->expects($this->any())
                 ->method('_getAuthorization')
                 ->will($this->returnValue($oTestAuth));
        $this->assertNull($oTestObj->UNITcheckAuthorization( ));
        $this->assertNull($oTestObj->UNITcheckAuthorization( ));
    }

    /**
     * @covers chromephp_oxshopcontrol::_getAuthorization
     */
    public function testGetAuthorization()
    {
        $oTestObj   = $this->getProxyClass('chromephp_oxshopcontrol');
        $this->assertTrue( $oTestObj->UNITgetAuthorization( ) instanceof authorization );
    }

    /**
     * @covers chromephp_oxshopcontrol::_deleteMysqlRecord
     */
    public function testDeleteMysqlRecord()
    {
        $oTestOrder = $this->getMock('mysqlManager', array('clearDebugMysqlByLogin'));
        $oTestObj   = $this->getProxyClass('chromephp_oxshopcontrol');
        $this->assertNull($oTestObj->UNITdeleteMysqlRecord( ));
    }

    /**
     * @covers chromephp_oxshopcontrol::_setInfoToChromePHP
     */
    public function testSetInfoToChromePHP()
    {
        $_POST = $_GET = array(1,2);
        $oTestObj   = $this->getProxyClass('chromephp_oxshopcontrol');
        $this->assertNull($oTestObj->UNITsetInfoToChromePHP( ));
    }

    /**
     * @covers chromephp_oxshopcontrol::_initializeViewObject
     */
    public function testInitializeViewObject()
    {
        $this->markTestIncomplete('Waiting for Update OXID Shop to Version 4.5.11');
    }

    /**
     * @covers chromephp_oxshopcontrol::_debugaxPreloadClass
     */
    public function testDebugaxPreloadClass()
    {
        $sTestClass = $this->getProxyClassName('chromephp_oxshopcontrol');
        $oTestClass = $this->getMock($sTestClass, array('_classExists'));
        $oTestClass->expects($this->once())
                   ->method('_classExists')
                   ->with('helper_Modules')
                   ->will($this->returnValue(true));

        $this->assertTrue($oTestClass->UNITdebugaxPreloadClass('helper_Modules'));
    }

    /**
     * @covers chromephp_oxshopcontrol::_debugaxPreloadClass
     */
    public function testFailDebugaxPreloadClass()
    {
        $sTestClass = $this->getProxyClassName('chromephp_oxshopcontrol');
        $oTestClass = $this->getMock($sTestClass, array('_classExists'));
        $oTestClass->expects($this->never())
                   ->method('_classExists')
                   ->will($this->returnValue(false));

        $this->assertFalse($oTestClass->UNITdebugaxPreloadClass('failClassName'));
    } // function

    /**
     * @covers chromephp_oxshopcontrol::_classExists
     */
    public function testClassExists()
    {
        $oTestClass = $this->getProxyClass('chromephp_oxshopcontrol');
        $this->assertTrue($oTestClass->UNITclassExists('helper_Modules'));
        $this->assertFalse($oTestClass->UNITclassExists('failClassName'));
    } // function

    /**
     * @covers chromephp_oxshopcontrol::_getConfigFile
     */
    public function testGetConfigFile()
    {
        $oTestObj   = $this->getProxyClass('chromephp_oxshopcontrol');
        $this->assertType('array', $oTestObj->UNITgetConfigFile( ));
    }
}
