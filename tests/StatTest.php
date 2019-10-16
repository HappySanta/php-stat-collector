<?php

class B extends \Hs\StatCollector {
    public static $appName = "goog";
}


class StatTest extends PHPUnit_Framework_TestCase
{
    public function testUsersGet()
    {
          \Hs\StatCollector::sum("test_run", 1);
          $this->assertNull(\Hs\StatCollector::$lastError);
    }

    public function testAppName() {
        $this->assertEquals( "goog", B::getStatName() );
        B::sum("test_run", 1);
        $this->assertEquals( "goog/0", B::getStatName() );
    }
}