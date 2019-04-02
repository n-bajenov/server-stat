<?php


namespace Bajenov\ServerStatAgent;


class LoadAvg
{
    private $la;

    public function __construct()
    {
        $this->collect();
    }

    private function collect()
    {
        $this->la = sys_getloadavg();
    }

    public function perMinute(): string
    {
        return $this->la[0];
    }

    public function perFiveMinutes(): string
    {
        return $this->la[1];
    }

    public function perFifteenMinutes(): string
    {
        return $this->la[2];
    }

}