<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;

interface MessageRepository
{
    /**
     * @param Message $message
     * @throws \LogicException
     */
    public function add(Message $message): void;

    /**
     * @param MessageId $messageId
     * @return Message
     * @throws MessageRepositoryException
     */
    public function find(MessageId $messageId): Message;
}
