<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

final class DoctrineMessageRepository implements MessageRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CriteriaMatcher
     */
    private $matcher;

    public function __construct(EntityManagerInterface $entityManager, CriteriaMatcher $matcher)
    {
        $this->entityManager = $entityManager;
        $this->matcher = $matcher;
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
     * {@inheritdoc}
     */
    public function findAll(QueryCriteria $criteria = null): array
    {
        if ($criteria === null) {
            $criteria = new QueryCriteria(Message::class, new FilterSet(), new SortSet());
        }

        return $this->matcher->match($criteria);
    }
}
