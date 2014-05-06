<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_Admin_chromephp_fileTest extends OxidTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Article_Review test setup
     *
     * @return null
     */
    protected function setUp()
    {
        parent::setUp();
        oxDb::getDb()->Execute('CREATE TABLE IF NOT EXISTS `adodb_debugphp_logsql` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `created` datetime NOT NULL,
                              `sql0` varchar(250) COLLATE latin1_general_ci NULL,
                              `sql1` text COLLATE latin1_general_ci NOT NULL,
                              `params` text COLLATE latin1_general_ci NOT NULL,
                              `tracer` text COLLATE latin1_general_ci NULL,
                              `timer` decimal(16,6) NULL,
                              `type` char(50) COLLATE latin1_general_ci NOT NULL,
                              `ident` char(50) COLLATE latin1_general_ci NOT NULL,
                              `check` tinyint(1) DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              KEY `created` (`created`),
                              KEY `ident` (`ident`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci'
        );
    }

    /**
     * @covers chromephp_admin_file
     */
    public function testClass()
    {
        $this->assertTrue(oxNew('chromephp_admin_file') instanceof chromephp_admin_file);
    }

    /**
     * @covers chromephp_admin_file
     */
    public function testTemplateSetted()
    {
        $sTemplate = '../../../modules/debugax/Admin/chromephp/Templates/file.tpl';
        $oTestClass = oxNew('chromephp_admin_file');
        $this->assertSame( $sTemplate, $oTestClass->getTemplateName());
    }

    /**
     * @covers chromephp_admin_file::render
     */
    public function testRender()
    {
        $oTestClass = oxNew('chromephp_admin_file');
        $this->assertSame( $oTestClass->render(), $oTestClass->getTemplateName());

        $aViewData = $oTestClass->getViewData();

        $this->assertType('string', $aViewData['oxid']);
        $this->assertSame( 'chromephp', $aViewData['oxid']);
        $this->assertSame( '/modules/debugax/tmp/file/', $aViewData['sUrlDir']);
        $this->assertType('array', $aViewData['aFileInfo']);
        $this->assertType('int', $aViewData['iCountMysql']);
    }

    /**
     * @covers chromephp_admin_file::_getFileManger
     */
    public function testGetFileManger()
    {
        $oTestObj = $this->getProxyClass('chromephp_admin_file');
        $this->assertTrue( $oTestObj->UNITgetFileManger() instanceof fileManager );
    }

    /**
     * @covers chromephp_admin_file::_getMysqlManager
     */
    public function testGetMysqlManager()
    {
        $oTestObj = $this->getProxyClass('chromephp_admin_file');
        $this->assertTrue( $oTestObj->UNITgetMysqlManager() instanceof mysqlManager );
    }

    /**
     * @covers chromephp_admin_file::deleteMysql
     */
    public function testDeleteMysql()
    {
        $oView = new chromephp_admin_file();
        $this->assertNull($oView->deleteMysql());
    }

    /**
     * @covers chromephp_admin_file::save
     */
    public function testSave()
    {
        modConfig::setParameter( "editval", array( 'test' => 6, 'test2' => 6 ) );
        $oView = new chromephp_admin_file();
        $this->assertNull($oView->save());
    }
}

