<?php declare(strict_types=1);

namespace Classic\Secret\Core\Console\Command;


use Classic\Secret\Core\Domain\System\SystemManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateKeyPairCommand extends Command
{
    protected $name = 'app:key:generate';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        SystemManager::up()->generateKeyPair();
    }
}