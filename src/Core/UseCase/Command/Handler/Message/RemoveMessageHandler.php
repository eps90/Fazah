<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMessage;

class RemoveMessageHandler
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function handle(RemoveMessage $command): void
    {
        $this->messageRepo->remove($command->getMessageId());
    }
}
