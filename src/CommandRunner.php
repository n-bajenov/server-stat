<?php namespace Bajenov\ServerStatAgent;

use Symfony\Component\Process\Process;
class CommandRunner
{
    private $command;

    public function __construct(array $command)
    {
        $this->command = $command;
    }

    public function execute()
    {
        $process = new Process($this->command);
        $process->run();

        if (!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}