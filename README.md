# StatCollector

Библиотека для отпавки метрик в графану через https://github.com/HappySanta/logs-collector

https://packagist.org/packages/happysanta/php-stat-collector

```bash
composer require happysanta/php-stat-collector
```


Пример для Laravel
```php
<?php


namespace App;


class Metric extends \Hs\StatCollector
{
    public static function isWriteEnable():bool {
        return !!config("app.enabled_grafana", "1");
    }
    
    public static function getAppName():string
    {
        return mb_strtolower(config("app.name", "bad_app"));
    }

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