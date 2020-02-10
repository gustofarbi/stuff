<?php

namespace App\Command;

use App\Document\BlogPost;
use App\Document\Comment;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FooCommand extends Command
{
    protected static $defaultName = 'foo';

    /**
     * @var DocumentManager
     */
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        parent::__construct(self::$defaultName);

        $this->dm = $dm;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $blog = new BlogPost('first one');
        $comment = new Comment();
        $comment->

        $user = $this->dm->getRepository(User::class)->findBy(
            [
                'username' => 'foo',
            ]
        );

        $blog->setUser($user[0]);

        $this->dm->persist($blog);
        $this->dm->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
