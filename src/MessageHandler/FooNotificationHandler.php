<?php


namespace App\MessageHandler;


use App\Document\Product;
use App\Message\FooNotification;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FooNotificationHandler implements MessageHandlerInterface
{
    private DocumentManager $dm;
    private LoggerInterface $logger;

    public function __construct(DocumentManager $dm, LoggerInterface $logger)
    {
        $this->dm     = $dm;
        $this->logger = $logger;
    }

    public function __invoke(FooNotification $fooNotification)
    {
        $product = new Product($fooNotification->getContent());

        try {
            $this->dm->persist($product);
            $this->dm->flush();
        } catch (\Throwable $t) {
            $this->logger->error($t->getMessage());
        }
    }
}