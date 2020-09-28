<?php

namespace Hs;

class StatWriter
{
    protected $host = "127.0.0.1";
    protected $port = 2777;
    protected $lastError = null;
    protected $appName = 'bad_app';
    const SumTag = "P";
    const SetTag = "S";
    const MaxTag = "M";
    const MinTag = "I";
    const AvgTag = "A";
    const HllTag = "L";
    const HllDayTag = "D";

    const StrSumTag = "T";
    const StrSetTag = "E";
    const StrMinTag = "N";
    const StrMaxTag = "X";
    const StrAvgTag = "G";

    /**
     * StatWriter constructor.
     * @param string $appName [A-z-_0-9] название приложения
     * @param string $host
     * @param int $port
     */
    public function __construct(string $appName, string $host = '127.0.0.1', int $port = 2777)
    {
        $this->appName = $appName;
        $this->host = $host;
        $this->port = $port;
        $this->lastError = null;

        if (strpos($this->appName, '/') === false) {
            $this->appName .= '/0';
        }
    }


    /**
     * @param string $paramName
     * @param string $paramType
     * @param int $value
     * @return bool
     */
    public function writeInt(string $paramName, string $paramType, int $value)
    {
        $msg = "RL:" . $this->appName . ":$paramName:$paramType:$value";
        return $this->writeMessage($msg);
    }

    protected function writeMessage(string $msg)
    {
        try {
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            $len = strlen($msg);
            socket_sendto($sock, $msg, $len, 0, $this->host, $this->port);
            socket_close($sock);
            return true;
        } catch (\Exception $e) {
            $this->lastError = $e;
            return false;
        }
    }

    /**
     * @param string $paramName
     * @param string $paramType
     * @param string $pattern
     * @param int $value
     * @return bool
     */
    public function writeStrInt(string $paramName, string $paramType, string $pattern, int $value)
    {
        $msg = "RL:" . $this->appName . ":$paramName:$paramType:$value:$pattern";
        return $this->writeMessage($msg);
    }

    public function sum(string $paramName, int $value)
    {
        return $this->writeInt($paramName, self::SumTag, $value);
    }

    public function set(string $paramName, int $value)
    {
        return $this->writeInt($paramName, self::SetTag, $value);
    }

    public function min(string $paramName, int $value)
    {
        return $this->writeInt($paramName, self::MinTag, $value);
    }

    public function max(string $paramName, int $value)
    {
        return $this->writeInt($paramName, self::MaxTag, $value);
    }

    public function avg(string $paramName, int $value)
    {
        return $this->writeInt($paramName, self::AvgTag, $value);
    }

    public function strSum(string $paramName, string $pattern, int $value)
    {
        return $this->writeStrInt($paramName, self::StrSumTag, $pattern, $value);
    }

    public function strSet(string $paramName, string $pattern, int $value)
    {
        return $this->writeStrInt($paramName, self::StrSetTag, $pattern, $value);
    }

    public function strMin(string $paramName, string $pattern, int $value)
    {
        return $this->writeStrInt($paramName, self::StrMinTag, $pattern, $value);
    }

    public function strMax(string $paramName, string $pattern, int $value)
    {
        return $this->writeStrInt($paramName, self::StrMaxTag, $pattern, $value);
    }

    public function strAvg(string $paramName, string $pattern, int $value)
    {
        return $this->writeStrInt($paramName, self::StrAvgTag, $pattern, $value);
    }

    public function hll(string $paramName, string $pattern)
    {
        return $this->writeStrInt($paramName, self::HllTag, $pattern, 0);
    }

    public function hllDay(string $paramName, string $pattern)
    {
        return $this->writeStrInt($paramName, self::HllDayTag, $pattern, 0);
    }
}
