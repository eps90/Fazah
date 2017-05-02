<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;

final class DoctrineMessageRepository implements MessageRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Message $message): void
    {
        try {
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw MessageRepositoryException::alreadyExists($message->getMessageId(), $exception);
        }
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
}
