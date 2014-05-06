<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_chromephp_mainTest extends OxidTestCase
{
    /**
     * @covers Chromephp_Admin_Main
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('Chromephp_Admin_Main') instanceof Chromephp_Admin_Main );
    }

    /**
     * @covers Chromephp_Admin_Main
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/chromephp/Templates/main.tpl';
        $oTestClass = oxNew('Chromephp_Admin_Main');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }

    /**
     * @covers Chromephp_Admin_Main::_getFileManger
     */
    public function testGetFileManger()
    {
        $oTestObj = $this->getProxyClass('Chromephp_Admin_Main');
        $this->assertTrue( $oTestObj->UNITgetFileManger() instanceof fileManager );
    }

    /**
     * @covers Chromephp_Admin_Main::_getChromephpManager
     */
    public function testGetChromephpManager()
    {
        $oTestObj = $this->getProxyClass('Chromephp_Admin_Main');
        $this->assertTrue( $oTestObj->UNITgetChromephpManager() instanceof chromephpManager );
    }

    /**
     * @covers Chromephp_Admin_Main::_getMysqlManager
     */
    public function testGetMysqlManager()
    {
        $oTestObj = $this->getProxyClass('Chromephp_Admin_Main');
        $this->assertTrue( $oTestObj->UNITgetMysqlManager() instanceof mysqlManager );
    }

    /**
     * @covers Chromephp_Admin_Main::backup
     */
    public function testBackup()
    {
        $oTestAuth   = $this->getMock('fileManager', array('backup'));
        $oTestAuth->expects($this->once())
                 ->method('backup')
                 ->will($this->returnValue(true));


        $oTestObj = $this->getMock('Chromephp_Admin_Main', array('_getFileManger'));
        $oTestObj->expects($this->any())
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestAuth));
        $this->assertNull($oTestObj->backup());
    }

    /**
     * @covers Chromephp_Admin_Main::_getMysqlInfo
     */
    public function testGetMysqlInfoTrue()
    {
        $oTestAuth   = $this->getMock('mysqlManager', array('checkDebugphpLogTable'));
        $oTestAuth->expects($this->any())
                 ->method('checkDebugphpLogTable')
                 ->will($this->returnValue(true));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getMysqlManager'));
        $oTestObj->expects($this->any())
                 ->method('_getMysqlManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertNull($oTestObj->UNITgetMysqlInfo());

        $aViewData = $oTestObj->getViewData();
        $this->assertTrue( $aViewData['bMySqlDB'] );
        $this->assertType('array', $aViewData['aMySqlInfo']);
    }

    /**
     * @covers Chromephp_Admin_Main::_getMysqlInfo
     */
    public function testGetMysqlInfoFalse()
    {
        $oTestAuth   = $this->getMock('mysqlManager', array('checkDebugphpLogTable'));
        $oTestAuth->expects($this->any())
                 ->method('checkDebugphpLogTable')
                 ->will($this->returnValue(false));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getMysqlManager'));
        $oTestObj->expects($this->any())
                 ->method('_getMysqlManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertNull($oTestObj->UNITgetMysqlInfo());

        $aViewData = $oTestObj->getViewData();
        $this->assertFalse( $aViewData['bMySqlDB'] );
        $this->assertNull( $aViewData['aMySqlInfo']);
    }

    /**
     * @covers Chromephp_Admin_Main::render
     */
    public function testRenderTpl()
    {
        $oTestClass = oxNew('Chromephp_Admin_Main');
        $this->assertSame( $oTestClass->render(), $oTestClass->getTemplateName());
    }

    /**
     * @covers Chromephp_Admin_Main::render
     */
    public function testRenderViewData()
    {
        $oTestAuth   = $this->getMock('chromephpManager', array('loadConfig'));
        $oTestAuth->expects($this->any())
                 ->method('loadConfig')
                 ->will($this->returnValue(array('filter' => array('sSearchText' => 'test#test2#test3'))));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getChromephpManager'));
        $oTestObj->expects($this->any())
                 ->method('_getChromephpManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertSame( $oTestObj->render(), $oTestObj->getTemplateName());

        $aViewData = $oTestObj->getViewData();

        $this->assertType('string', $aViewData['oxid']);
        $this->assertSame( 'chromephp', $aViewData['oxid']);

        $sMyIp = (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];
        $this->assertSame( $sMyIp, $aViewData['myIp']);
        $this->assertSame( $aViewData["aMoreSearchText"][0], 'test2');
        $this->assertSame( $aViewData["aMoreSearchText"][1], 'test3');
        $this->assertSame(2, count($aViewData["aMoreSearchText"]));

    }

    /**
     * @covers Chromephp_Admin_Main::render
     */
    public function testRenderViewDataElseSearch()
    {
        $oTestAuth   = $this->getMock('chromephpManager', array('loadConfig'));
        $oTestAuth->expects($this->once())
                 ->method('loadConfig')
                 ->will($this->returnValue(array('filter' => array('sSearchText' => 'test'))));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getChromephpManager'));
        $oTestObj->expects($this->exactly(2))
                 ->method('_getChromephpManager')
                 ->will($this->returnValue($oTestAuth));
        $oTestObj->render();
        $aViewData = $oTestObj->getViewData();
        $this->assertType('array', $aViewData["aMoreSearchText"]);

    }

    /**
     * @covers Chromephp_Admin_Main::save
     */
    public function testSave()
    {
        $oTestAuth   = $this->getMock('chromephpManager', array('saveConfig'));
        $oTestAuth->expects($this->once())
                 ->method('saveConfig')
                 ->will($this->returnValue(true));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getParams', '_getChromephpManager', '_addErrorToDisplay'));
        $oTestObj->expects($this->once())
                 ->method('_getParams')
                 ->will($this->returnValue(array('sendData' => 3, 'sqlCheck' => 2)));

        $oTestObj->expects($this->never())
                 ->method('_addErrorToDisplay');

        $oTestObj->expects($this->once())
                 ->method('_getChromephpManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertNull($oTestObj->save());
    }

    /**
     * @covers Chromephp_Admin_Main::save
     */
    public function testSaveFailOne()
    {
        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getParams','_getChromephpManager', '_addErrorToDisplay'));
        $oTestObj->expects($this->once())
                 ->method('_getParams')
                 ->will($this->returnValue(array('sendData' => 3, 'sqlCheck' => 1)));
        $oTestObj->expects($this->never())
                 ->method('_getChromephpManager');
        $oTestObj->expects($this->once())
                 ->method('_addErrorToDisplay')
                 ->with('Fehler')
                 ->will($this->returnValue(null));
        $this->assertNull($oTestObj->save());

    }

    /**
     * @covers Chromephp_Admin_Main::save
     */
    public function testSaveFailTwo()
    {
        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getParams','_getChromephpManager', '_addErrorToDisplay'));
        $oTestObj->expects($this->once())
                 ->method('_getParams')
                 ->will($this->returnValue(array('sendData' => 3, 'sqlCheck' => 4)));
        $oTestObj->expects($this->never())
                 ->method('_getChromephpManager');
        $oTestObj->expects($this->once())
                 ->method('_addErrorToDisplay')
                 ->with('Fehler')
                 ->will($this->returnValue(null));
        $this->assertNull($oTestObj->save());
    }

    /**
     * @covers Chromephp_Admin_Main::_checkSendData
     */
    public function testCheckSendDataWithParam3()
    {
        $oTestAuth   = $this->getMock('mysqlManager', array('clearDebugMysql', 'checkDebugphpLogTable'));
        $oTestAuth->expects($this->any())
                 ->method('clearDebugMysql')
                 ->will($this->returnValue(true));
        $oTestAuth->expects($this->any())
                 ->method('checkDebugphpLogTable')
                 ->will($this->returnValue(true));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getMysqlManager'));

        $oTestObj->expects($this->any())
                 ->method('_getMysqlManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertNull($oTestObj->UNITcheckSendData(3));

    }

    /**
     * @covers Chromephp_Admin_Main::_checkSendData
     */
    public function testCheckSendDataWithParam2()
    {
        $oTestAuth   = $this->getMock('fileManager', array('createDir'));
        $oTestAuth->expects($this->once())
                 ->method('createDir')
                 ->will($this->returnValue('testPath'));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getFileManger', '_getMysqlManager'));

        $oTestObj->expects($this->exactly(2))
                 ->method('_getFileManger')
                 ->will($this->returnValue($oTestAuth));
        $oTestObj->expects($this->never())
                 ->method('_getMysqlManager');
        $this->assertNull($oTestObj->UNITcheckSendData(2));
    }

    /**
     * @covers Chromephp_Admin_Main::_checkSendData
     */
    public function testCheckSendDataWithParam3AndTry()
    {
        $oTestAuth   = $this->getMock('mysqlManager', array('clearDebugMysql', 'checkDebugphpLogTable', 'setDebugphpLogTable'));
        $oTestAuth->expects($this->any())
                 ->method('clearDebugMysql')
                 ->will($this->returnValue(true));
        $oTestAuth->expects($this->any())
                 ->method('checkDebugphpLogTable')
                 ->will($this->returnValue(false));
        $oTestAuth->expects($this->any())
                 ->method('setDebugphpLogTable')
                 ->will($this->returnValue(true));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getMysqlManager'));

        $oTestObj->expects($this->any())
                 ->method('_getMysqlManager')
                 ->will($this->returnValue($oTestAuth));

        $this->assertNull($oTestObj->UNITcheckSendData(3));
    }

    /**
     * @covers Chromephp_Admin_Main::_checkSendData
     */
    public function testCheckSendDataWithParam3AndCache()
    {
        $oTestAuth   = $this->getMock('mysqlManager', array('clearDebugMysql', 'checkDebugphpLogTable', 'setDebugphpLogTable'));
        $oTestAuth->expects($this->never())
                 ->method('clearDebugMysql');
        $oTestAuth->expects($this->once())
                 ->method('checkDebugphpLogTable')
                 ->will($this->returnValue(false));
        $oTestAuth->expects($this->once())
                 ->method('setDebugphpLogTable')
                 ->will($this->throwException(new Exception('foo', 99945)));

        $sTestClass     = $this->getProxyClassName('Chromephp_Admin_Main');
        $oTestObj       = $this->getMock($sTestClass, array('_getMysqlManager', '_addErrorToDisplay', '_getFileManger'));

        $oTestObj->expects($this->exactly(2))
                 ->method('_getMysqlManager')
                 ->will($this->returnValue($oTestAuth));
        $oTestObj->expects($this->once())
                 ->method('_addErrorToDisplay')
                 ->with('foo')
                 ->will($this->returnValue(null));
        $oTestObj->expects($this->never())
                 ->method('_getFileManger');
        $this->assertNull($oTestObj->UNITcheckSendData(3));
    }

    /**
     * @covers Chromephp_Admin_Main::_addErrorToDisplay
     */
    public function testAddErrorToDisplay()
    {
        $oTestClass = $this->getProxyClass('Chromephp_Admin_Main');
        $this->assertNull($oTestClass->UNITaddErrorToDisplay('testErrMessage'));
    }

    /**
     * @covers Chromephp_Admin_Main::_getParams
     */
    public function testGetParamsNODebagAxActiv()
    {
        modConfig::setParameter( "editval",array(
          'sendData' => '1',
          'sAuthorizationText' => '',
          'info' => '1',
        ));
        modConfig::setParameter( "filter", array(
          'usermodel' => '0',
          'backtrace' => '0',
          'search' => '0',
          'sSearchText' => '',
        ));
        modConfig::setParameter( "sSerchMore", null );

        $oTestClass = $this->getProxyClass('Chromephp_Admin_Main');


        $aReturn = array(
          'sendData' => '1',
          'sAuthorizationText' => '',
          'info' => '1',
          'filter' =>
          array(
            'usermodel' => '0',
            'backtrace' => '0',
            'search' => '0',
            'sSearchText' => false,
            'moreFilter' => 0,
          ),
          'debugActive' => 0,
        );

        $this->assertSame($oTestClass->UNITgetParams(), $aReturn);

    }


    /**
     * @covers Chromephp_Admin_Main::_getParams
     */
    public function testGetParamsDebagAxActivSqlError()
    {
        modConfig::setParameter( "editval",array(
          'debugActive' => '1',
          'sendData' => '2',
          'sAuthorizationText' => '',
          'sqlCheck' => '4',
          'info' => '1',
        ) );
        modConfig::setParameter( "filter", array(
          'usermodel' => '0',
          'backtrace' => '0',
          'search' => '0',
          'sSearchText' => '',
        ) );
        modConfig::setParameter( "sSerchMore", null);

        $oTestClass = $this->getProxyClass('Chromephp_Admin_Main');

        $aReturn = array(
          'debugActive' => '1',
          'sendData' => '2',
          'sAuthorizationText' => '',
          'sqlCheck' => '4',
          'info' => '1',
          'filter' =>
          array (
            'usermodel' => 0,
            'backtrace' => 1,
            'search' => 0,
            'sSearchText' => false,
            'moreFilter' => 0,
          ),
        );

        $this->assertSame($oTestClass->UNITgetParams(), $aReturn);
    }



    /**
     * @covers Chromephp_Admin_Main::_getParams
     */
    public function testGetParamsActivDebagAxFilter()
    {
        modConfig::setParameter( "editval",array(
          'debugActive' => '1',
          'sendData' => '2',
          'sAuthorizationText' => '',
          'sqlCheck' => '2',
          'info' => '1',
        ));
        modConfig::setParameter( "filter", array(
          'usermodel' => '0',
          'backtrace' => '0',
          'search' => '1',
          'sSearchText' => 'test1',
        ));
        modConfig::setParameter( "sSerchMore", array(
          0 => 'test2',
          1 => 'test3',
        ));

        $oTestClass = $this->getProxyClass('Chromephp_Admin_Main');

        $aReturn = array(
          'debugActive' => '1',
          'sendData' => '2',
          'sAuthorizationText' => '',
          'sqlCheck' => '2',
          'info' => '1',
          'filter' =>
          array (
            'usermodel' => '0',
            'backtrace' => '0',
            'search' => '1',
            'sSearchText' => 'test1#test2#test3',
            'moreFilter' => 1,
          ),
        );
        $this->assertSame($oTestClass->UNITgetParams(), $aReturn);
    }
}