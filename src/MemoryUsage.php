<?php


namespace Bajenov\ServerStatAgent;

use Bajenov\ServerStatAgent\CommandRunner;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class MemoryUsage
 * @package Bajenov\ServerStatAgent
 */
class MemoryUsage
{

    /**
     * @var array
     */
    private $command = ['free'];
    /**
     * @var
     */
    private $total;
    /**
     * @var
     */
    private $used;

    /**
     * MemoryUsage constructor.
     */
    public function __construct()
    {
        $this->collect();
    }

    /**
     * @return MemoryUsage|float|int
     */
    public function getTotalInKb()
    {
        return $this->getInFormat('total', 'kb');
    }

    /**
     * @return MemoryUsage|float|int
     */
    public function getTotalInMb()
    {
        return $this->getInFormat('total', 'mb');
    }

    /**
     * @return MemoryUsage|float|int
     */
    public function getTotalInGb()
    {
        return $this->getInFormat('total', 'gb');
    }

    /**
     *
     */
    public function getUsedInKb()
    {
        return $this->getInFormat('used', 'kb');
    }

    /**
     *
     */
    public function getUsedInMb()
    {
        return $this->getInFormat('used', 'mb');
    }

    /**
     *
     */
    public function getUsedInGb()
    {
        return $this->getInFormat('used', 'gb');
    }

    /**
     * @param string $type
     * @param string $format
     * @return float|int
     */
    private function getInFormat(string $type, string $format)
    {
        switch ($format)
        {
            case 'kb':
                return ($type == 'total') ? $this->total: $this->used;
                break;

            case 'mb':
                return ($type == 'total') ? round($this->total / 1024) : round($this->used / 1024);
                break;

            case 'gb':
                return ($type == 'total') ? round($this->total / 1024 / 1024) : round($this->used / 1024 / 1024);
                break;
        }

        return 0;
    }

    /**
     * @return bool
     */
    private function collect()
    {
        try {

            $result = new CommandRunner($this->command);

            $resultArray = $this->parseResult($result->execute());

            return true;

        } catch (ProcessFailedException $exception) {
            return false;
        }


    }

    /**
     * @param string $result
     */
    private function parseResult(string $result)
    {

        $free = (string)trim($result);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2] / $mem[1] * 100;


        $this->total = $mem[1];
        $this->used = $mem[2];

    }
}