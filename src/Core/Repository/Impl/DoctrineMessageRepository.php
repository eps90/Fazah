<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\MessageRepository;

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
    public function save(Message ...$messages): void
    {
        foreach ($messages as $message) {
            $this->entityManager->persist($message);
        }

        $this->entityManager->flush();
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

    /**
     * @param CatalogueId $catalogueId
     * @return Message[]
     */
    public function findByCatalogueId(CatalogueId $catalogueId): array
    {
        return $this->entityManager->createQuery(
                'SELECT m FROM Fazah:Message m 
                WHERE m.catalogueId = :catalogueId
                ORDER BY m.metadata.createdAt DESC, m.metadata.updatedAt DESC'
            )
            ->setParameter('catalogueId', $catalogueId)
            ->getResult();
    }
}
