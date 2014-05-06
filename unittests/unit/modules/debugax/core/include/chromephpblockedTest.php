<?php

require_once realpath( "." ).'/unit/OxidTestCase.php';
require_once realpath( "." ).'/unit/test_config.inc.php';

class Unit_Modules_debugax_core_include_chromephpblockedTest extends OxidTestCase
{
    /**
     * @covers chromephpBlocked
     */
    public function testClass()
    {
        $oTest = new chromephpBlocked;
        $this->assertTrue( $oTest instanceof chromephpBlocked  );
    }

    /**
     * @covers chromephpBlocked::log
     */
    public function testLog()
    {
        $this->assertTrue( chromephpBlocked::log()  );
    }

    /**
     * @covers chromephpBlocked::warn
     */
    public function testWarn()
    {
        $this->assertTrue( chromephpBlocked::warn()  );
    }

    /**
     * @covers chromephpBlocked::error
     */
    public function testError()
    {
        $this->assertTrue( chromephpBlocked::error()  );
    }

    /**
     * @covers chromephpBlocked::group
     */
    public function testGroup()
    {
        $this->assertTrue( chromephpBlocked::group()  );
    }


    /**
     * @covers chromephpBlocked::info
     */
    public function testInfo()
    {
        $this->assertTrue( chromephpBlocked::info()  );
    }

    /**
     * @covers chromephpBlocked::groupCollapsed
     */
    public function testGroupCollapsed()
    {
        $this->assertTrue( chromephpBlocked::groupCollapsed()  );
    }

    /**
     * @covers chromephpBlocked::groupEnd
     */
    public function testGroupEnd()
    {
        $this->assertTrue( chromephpBlocked::groupEnd()  );
    }
}