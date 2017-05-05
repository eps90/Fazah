<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface MessageRepository
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
     * @param CatalogueId $catalogueId
     * @return Message[]
     */
    public function findByCatalogueId(CatalogueId $catalogueId): array;

    /**
     * @param QueryCriteria|null $criteria
     * @return array|Message[]
     */
    public function findAll(QueryCriteria $criteria = null): array;
}
