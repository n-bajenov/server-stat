<?php


namespace Bajenov\ServerStatAgent;


class DiskUsage
{

    private $total = 0;
    private $used = 0;

    public function __construct()
    {
        $this->collect();
    }

    private function collect()
    {
        $this->total = disk_total_space('/');
        $free = disk_free_space('/');
        $this->used = $this->total - $free;
    }

    public function getUsedInKb(): string
    {
        return $this->getInFormat('used', 'kb');
    }

    public function getUsedInMb(): string
    {
        return $this->getInFormat('used', 'mb');
    }

    public function getUsedInGb(): string
    {
        return $this->getInFormat('used', 'gb');
    }


    public function getTotalInKb(): string
    {
        return $this->getInFormat('total', 'kb');
    }

    public function getTotalInMb(): string
    {
        return $this->getInFormat('total', 'mb');
    }

    public function getTotalInGb(): string
    {
        return $this->getInFormat('total', 'gb');
    }

    private function getInFormat(string $type, string $format)
    {
        switch ($format) {
            case 'kb':
                return ($type == 'used') ? $this->used : $this->total / 1024;
                break;

            case 'mb':
                return ($type == 'used') ? round($this->used / 1024 / 1024) : round($this->total / 1024 / 1024);
                break;

            case 'gb':
                return ($type == 'used') ? round($this->used / 1024 / 1024 / 1024) : round($this->total / 1024 / 1024 / 1024);
                break;
        }

        return 0;
    }
}
