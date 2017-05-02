<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;

interface MessageRepository
{
    /**
     * @param Message[] ...$messages
     */
    public function add(Message ...$messages): void;

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
}
