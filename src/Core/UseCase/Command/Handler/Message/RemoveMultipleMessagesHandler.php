<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMultipleMessages;

class RemoveMultipleMessagesHandler
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function handle(RemoveMultipleMessages $command): void
    {
        $this->messageRepo->removeMultiple(...$command->getMessagesIds());
    }
}
