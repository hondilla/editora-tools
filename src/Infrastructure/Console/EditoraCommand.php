<?php

namespace Omatech\EditoraTools\Infrastructure\Console;

use Omatech\EditoraTools\Application\TransferDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditoraCommand extends Command
{
    protected function configure()
    {
        $this->setName('editora:transfer-database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (new TransferDatabase())->make();
        return 0;
    }
}
