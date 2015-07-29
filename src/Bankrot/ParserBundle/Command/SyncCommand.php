<?php

namespace Bankrot\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bankrot:sync')
            ->setDescription('Синхронизация списка с fedresurs.ru.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = $this->getContainer()->get('bankrot_parser.parser');

        $parser->sync(
            function ($remoteId) use ($output) {
                $output->writeln(sprintf('Создан лот #%d', $remoteId));
            }
        );

        $output->writeln('<info>Синхронизация завершена</info>');
    }
}