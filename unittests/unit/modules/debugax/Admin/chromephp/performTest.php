<?php


require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_chromephp_performTest extends OxidTestCase
{

    /**
     * @covers chromephp_admin_perform
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('chromephp_admin_perform') instanceof chromephp_admin_perform );
    }

    /**
     * @covers chromephp_admin_perform
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/chromephp/Templates/perform.tpl';
        $oTestClass = oxNew('chromephp_admin_perform');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }

    /**
     * @covers chromephp_admin_perform::render
     */
    public function testRender()
    {
        $oTestClass = oxNew('chromephp_admin_perform');
        $this->assertSame( $oTestClass->render(), $oTestClass->getTemplateName());

        $aViewData = $oTestClass->getViewData();

        $this->assertType('string', $aViewData['oxid']);
        $this->assertSame( 'chromephp', $aViewData['oxid']);
    }

    /**
     * @covers chromephp_admin_perform::_getTestPerformance
     */
    public function testGetFileManger()
    {
        $oTestObj = $this->getProxyClass('chromephp_admin_perform');
        $this->assertTrue( $oTestObj->UNITgetTestPerformance() instanceof testPerformance );
    }


    /**
     * @covers chromephp_admin_perform::_getIframeUrl
     */
    public function testgetIframeUrl()
    {
        $oPerformTest = new testPerformance();
        $sStartUrlOne = 'http://www.test.com/index.php';
        $sStartUrlTwo = 'http://www.test.com/index.php?unittest';

        $oTestObj = $this->getProxyClass('chromephp_admin_perform');
        for ($iKey=1; $iKey < 4; $iKey++)
        {
            $sSufix = $oPerformTest->getUrlSufix($iKey);

            $sTestUrlOne = $sStartUrlOne . '?test=' .  $sSufix;
            $sClassTestUrlOne = $oTestObj->UNITgetIframeUrl($sStartUrlOne, $iKey);
            $this->assertSame( $sTestUrlOne, $sClassTestUrlOne);

            $sTestUrlTwo = $sStartUrlTwo . '&test=' .  $sSufix;
            $sClassTestUrlTwo = $oTestObj->UNITgetIframeUrl($sStartUrlTwo, $iKey);
            $this->assertSame( $sTestUrlTwo, $sClassTestUrlTwo);
        }
    }


    /**
     * @covers chromephp_admin_perform::deleteOne
     */
    public function testDeleteOne()
    {
        modConfig::setParameter( "deleteOne", 1 );
        $oTestAuth   = $this->getMock('testPerformance', array('deleteOneTestResult'));
        $oTestAuth->expects($this->once())
                 ->method('deleteOneTestResult')
                 ->with(1)
                 ->will($this->returnValue(true));


        $oTestObj = $this->getMock('chromephp_admin_perform', array('_getTestPerformance'));
        $oTestObj->expects($this->any())
                 ->method('_getTestPerformance')
                 ->will($this->returnValue($oTestAuth));
        $this->assertNull($oTestObj->deleteOne());
    }

    /**
     * @covers chromephp_admin_perform::deleteMore
     */
    public function testDeleteMoreNull()
    {
        $aTestArray = array(1,2);
        modConfig::setParameter( "deleteMore", $aTestArray );
        $oTestAuth   = $this->getMock('testPerformance', array('deleteMoreTestResult'));
        $oTestAuth->expects($this->once())
                 ->method('deleteMoreTestResult')
                 ->with($aTestArray)
                 ->will($this->returnValue(true));


        $oTestObj = $this->getMock('chromephp_admin_perform', array('_getTestPerformance'));
        $oTestObj->expects($this->any())
                 ->method('_getTestPerformance')
                 ->will($this->returnValue($oTestAuth));
        $this->assertNull($oTestObj->deleteMore());
    }

    /**
     * @covers chromephp_admin_perform::stopPerformTest
     */
    public function testStopPerformTest()
    {
        oxTestModules::addFunction('testPerformance', 'checkPerformance', '{ return true; }');
        $oTestClass = new chromephp_admin_perform();
        $this->assertNull($oTestClass->stopPerformTest());
        $aViewData = $oTestClass->getViewData();
        $this->assertTrue($aViewData['bPerformTestResult'], 'Result not success');
        $this->assertTrue($aViewData['bBackupResult'], 'backup not success');
    }

    /**
     * @covers chromephp_admin_perform::startPerformTest
     */
    public function testStartPerformTest()
    {
        oxTestModules::addFunction('testPerformance', 'changePerformFile', '{ return true; }');
        $aArrayTestSufix = array(1 => 'start', 2 => 'list', 3 => 'details');
        $sTestUrl = 'http://www.test.com/';
        $sTestComment = 'Test Comment';
        $iIterator = 3;
        $aArrayTest = array();
        for ($iTest=1; $iTest <= $iIterator; $iTest++)
        {
            $aArrayTest[$iTest] = $sTestUrl;
        }
        modConfig::setParameter( "aUrls", $aArrayTest );
        modConfig::setParameter( "comment", $sTestComment );
        $oTestClass = new chromephp_admin_perform();
        $this->assertNull($oTestClass->startPerformTest());
        $aViewData = $oTestClass->getViewData();
        $aResultLinks = $aViewData['aUrlsIframe'];
        for ($iTest=1; $iTest <= $iIterator; $iTest++)
        {
            $this->assertSame($aResultLinks[$iTest], $sTestUrl . '?test=' . $aArrayTestSufix[$iTest] ,
                            'Result Url is not a same');
        }
        $this->assertSame(3, count($aResultLinks), 'Only 3 Link are allowed');
        $this->assertTrue($aViewData['bPerform'], 'bPerform is not a True');
        $this->assertSame($aViewData['comment'], $sTestComment, 'Coment ist no a same');
    }

    /**
     * @covers chromephp_admin_perform::startPerformTest
     */
    public function testStartPerformTestFail()
    {
        $oTestAuth   = $this->getMock('testPerformance', array('changePerformFile'));
        $oTestAuth->expects($this->once())
                 ->method('changePerformFile')
                 ->will($this->throwException(new Exception('foo', 99945)));

        $oTestObj = $this->getMock('chromephp_admin_perform', array('_getTestPerformance', '_getIframeUrl', '_addErrorToDisplay'));
        $oTestObj->expects($this->once())
                 ->method('_getTestPerformance')
                 ->will($this->returnValue($oTestAuth));
        $oTestObj->expects($this->never())
                 ->method('_getIframeUrl');
        $oTestObj->expects($this->once())
                 ->method('_addErrorToDisplay')
                 ->with('foo')
                 ->will($this->returnValue(null));
        $this->assertNull($oTestObj->startPerformTest());
    }

    /**
     * @covers chromephp_admin_perform::_addErrorToDisplay
     */
    public function testAddErrorToDisplay()
    {
        $oTestClass = $this->getProxyClass('chromephp_admin_perform');
        $this->assertNull($oTestClass->UNITaddErrorToDisplay('testErrMessage'));
    }
}

