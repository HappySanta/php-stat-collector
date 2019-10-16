# StatCollector

```bash
composer require happysanta/php-stat-collector
```

```php
<?php


namespace App;


class Metric extends \Hs\StatCollector
{
    public static $appName = "bad_app";

    public static function fatalError() {
        self::sum("fatal_error", 1);
    }

    public static function snippetGenerationTime($time) {
        self::avg("snippet_generation", $time);
    }

    public static function test() {
        self::sum("test_metric", 1);
    }

    public static function sendNotifyError() {
        self::sum("send_notify_error", 1);
    }

    public static function sendNotifyDone() {
        self::sum("send_notify_done", 1);
    }
}
```