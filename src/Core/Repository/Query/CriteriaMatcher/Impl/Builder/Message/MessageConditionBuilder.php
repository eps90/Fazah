<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

abstract class MessageConditionBuilder implements DoctrineConditionBuilder
{
    abstract protected function supportsMessage(QueryCriteria $criteria): bool;

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getModelClass() === Message::class && $this->supportsMessage($criteria);
    }
}
