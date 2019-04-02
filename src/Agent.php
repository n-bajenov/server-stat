<?php namespace Bajenov\ServerStatAgent;

use Bajenov\ServerStatAgent\DiskUsage;
use Bajenov\ServerStatAgent\LoadAvg;
use Bajenov\ServerStatAgent\MemoryUsage;

class Agent
{

    private $AlowesScope = ['disk', 'memory', 'load'];
    private $scope = [];

    public function __construct()
    {

        $this->scope = $this->AlowesScope;
    }

    public function setScope(array $scopes)
    {
        foreach ($scopes as $scope) {
            if (!in_array($scope, $this->AlowesScope)) {
                throw new \Exception('Invalid scope: ' . $scope);
            }
        }

        return $this;
    }

    public function execute()
    {
        $data = [];

        if (in_array('memory', $this->scope)) {
            $memory = new MemoryUsage();

            $data['memory'] = [
                'total' => [
                    'kb' => $memory->getTotalInKb(),
                    'mb' => $memory->getTotalInMb(),
                    'gb' => $memory->getTotalInGb(),
                ],
                'used' => [
                    'kb' => $memory->getUsedInKb(),
                    'mb' => $memory->getUsedInMb(),
                    'gb' => $memory->getUsedInGb(),
                ],
            ];

        }

        if (in_array('disk', $this->scope))
        {
            $disk = new DiskUsage();

            $data['disk'] = [

                'total' => [
                    'kb' => $disk->getTotalInKb(),
                    'mb' => $disk->getTotalInMb(),
                    'gb' => $disk->getTotalInGb()
                ],

                'used' => [
                    'kb' => $disk->getUsedInKb(),
                    'mb' => $disk->getUsedInMb(),
                    'gb' => $disk->getUsedInGb()
                ],
            ];
        }

        if (in_array('load', $this->scope))
        {
            $loadAvg = new LoadAvg();

            $data['load'] = [
                'minute' => $loadAvg->perMinute(),
                'five' => $loadAvg->perFiveMinutes(),
                'fivteen' => $loadAvg->perFifteenMinutes()
            ];
        }

        return $data;
    }


}