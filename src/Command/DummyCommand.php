<?php

namespace App\Command;

use App\Message\FooNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class DummyCommand extends Command
{
    protected static $defaultName = 'dummy';
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct(self::$defaultName);

        $this->bus = $bus;
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->bus->dispatch(new FooNotification('foobar: ' . uniqid()));

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
