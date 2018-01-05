<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Porpaginas\Result;

interface MessageRepository extends RepositoryInterface
{
    /**
     * @param Message[] ...$messages
     */
    public function save(Message ...$messages): void;

    /**
     * @param MessageId $messageId
     * @return Message
     * @throws MessageRepositoryException
     */
    public function find(MessageId $messageId): Message;

    /**
     * @param QueryCriteria|null $criteria
     * @return Result|Message[]
     */
    public function findAll(QueryCriteria $criteria = null): Result;

    public function remove(MessageId $messageId): void;

    public function removeMultiple(MessageId ...$messageIds): void;
}
