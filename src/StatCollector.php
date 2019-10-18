<?php

namespace Hs;

class StatCollector
{
    public static $host = "127.0.0.1";
    public static $port = 2777;
    public static $lastError = null;
    public static $appName = 'bad_app';
    const SumTag = "P";
    const SetTag = "S";
    const MaxTag = "M";
    const MinTag = "I";
    const AvgTag = "A";

    const StrSumTag = "T";
    const StrSetTag = "E";
    const StrMinTag = "N";
    const StrMaxTag = "X";
    const StrAvgTag = "G";

    /**
     * @param string $paramName
     * @param string $paramType
     * @param int $value
     * @return string
     */
    public static function write(string $paramName, string $paramType, int $value)
    {
        if (strpos(static::$appName, '/') === false) {
            static::$appName .= '/0';
        }
        try {
            $msg = "RL:" . static::$appName . ":$paramName:$paramType:$value";
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            $len = strlen($msg);
            socket_sendto($sock, $msg, $len, 0, static::$host, static::$port);
            socket_close($sock);
            return true;
        } catch (\Exception $e) {
            self::$lastError = $e;
            return $e;
        }
    }

    /**
     * @param string $paramName
     * @param string $paramType
     * @param string $pattern
     * @param int $value
     * @return string
     */
    public static function writeEx(string $paramName, string $paramType, string $pattern, int $value)
    {
        if (strpos(static::$appName, '/') === false) {
            static::$appName .= '/0';
        }
        try {
            $msg = "RL:" . static::$appName . ":$paramName:$paramType:$value:$pattern";
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            $len = strlen($msg);
            socket_sendto($sock, $msg, $len, 0, static::$host, static::$port);
            socket_close($sock);
            return true;
        } catch (\Exception $e) {
            self::$lastError = $e;
            return $e;
        }
    }

    public static function sum(string $paramName, int $value)
    {
        return self::write($paramName, self::SumTag, $value);
    }

    public static function set(string $paramName, int $value)
    {
        return self::write($paramName, self::SetTag, $value);
    }

    public static function min(string $paramName, int $value)
    {
        return self::write($paramName, self::MinTag, $value);
    }

    public static function max(string $paramName, int $value)
    {
        return self::write($paramName, self::MaxTag, $value);
    }

    public static function avg(string $paramName, int $value)
    {
        return self::write($paramName, self::AvgTag, $value);
    }

    /**
     * @param string $paramName
     * @param string $pattern
     * @param int $value
     * @return string
     * @deprecated use strSum
     */
    public static function str(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrSumTag, $pattern, $value);
    }

    public static function strSum(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrSumTag, $pattern, $value);
    }

    public static function strSet(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrSetTag, $pattern, $value);
    }

    public static function strMin(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrMinTag, $pattern, $value);
    }

    public static function strMax(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrMaxTag, $pattern, $value);
    }

    public static function strAvg(string $paramName, string $pattern, int $value)
    {
        return self::writeEx($paramName, self::StrAvgTag, $pattern, $value);
    }

    public static function getStatName()
    {
        return static::$appName;
    }

}