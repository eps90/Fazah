<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\MessageRepository;

class DoctrineMessageRepository extends BaseDoctrineRepository implements MessageRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Message ...$messages): void
    {
        $this->saveAll($messages);
    }

    /**
     * {@inheritdoc}
     */
    public function find(MessageId $messageId): Message
    {
        $message = $this->entityManager->find(Message::class, $messageId);
        if ($message === null) {
            throw MessageRepositoryException::notFound($messageId);
        }

        return $message;
    }

    protected function getModelClass(): string
    {
        return Message::class;
    }
}
