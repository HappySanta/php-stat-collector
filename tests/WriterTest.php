<?php

use PHPUnit\Framework\TestCase;

class WriterTest  extends TestCase
{
    public function testWrite() {
        $host = '127.0.0.1';
        $port = 2777;

        $appName = "test_app";

        $writer = new \Hs\StatWriter($appName, $host, $port);

        $socket = stream_socket_server("udp://$host:$port", $errno, $errstr, STREAM_SERVER_BIND);
        if (!$socket) {
            die("$errstr ($errno)");
        }

        $writer->sum("rps",1);
        $msg = stream_socket_recvfrom($socket, 200, 0, $peer);
        $this->assertEquals("RL:test_app/0:rps:P:1", $msg);


        $writer->avg("loading",155);
        $msg = stream_socket_recvfrom($socket, 200, 0, $peer);
        $this->assertEquals("RL:test_app/0:loading:A:155", $msg);

        $writer->strSum("call", "users.get", 10);
        $msg = stream_socket_recvfrom($socket, 200, 0, $peer);
        $this->assertEquals("RL:test_app/0:call:T:10:users.get", $msg);

    }
}
