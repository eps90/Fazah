<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\EditMessage;

class EditMessageHandler
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function handle(EditMessage $command): void
    {
        $messageId = $command->getMessageId();
        $messageData = $command->getMessageData();

        $message = $this->messageRepo->find($messageId);
        $message->updateFromArray($messageData);
        $this->messageRepo->save($message);
    }
}
