<?php

use PHPUnit\Framework\TestCase;

class MyMetric extends \Hs\StatCollector {
    public static function getAppName():string
    {
        return "test_app_555";
    }
}


class StatTest extends TestCase
{
    public function testUsersGet()
    {
          MyMetric::sum("test_run", 1);
          $this->assertNull(MyMetric::$lastError);
    }

    public function testAppName() {
        $this->assertEquals( "test_app_555/0", MyMetric::getCorrectAppName() );
        MyMetric::sum("test_run", 1);
        $this->assertEquals( "test_app_555/0", MyMetric::getCorrectAppName() );
    }
}


