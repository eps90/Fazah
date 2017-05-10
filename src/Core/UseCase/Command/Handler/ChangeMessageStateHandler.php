<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\ChangeMessageState;

class ChangeMessageStateHandler
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function handle(ChangeMessageState $command): void
    {
        $message = $this->messageRepo->find($command->getMessageId());
        $command->shouldBeEnabled() ? $message->enable() : $message->disable();

        $this->messageRepo->save($message);
    }
}
