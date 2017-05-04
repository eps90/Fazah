<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\Identity;

abstract class RepositoryException extends \LogicException
{
    abstract protected static function getModelAlias(): string;

    abstract protected static function getErrorCode(): int;

    protected static function generateNotFoundException(Identity $modelId, \Throwable $previous = null)
    {
        $modelAlias = static::getModelAlias();
        $message = sprintf('%s with id %s has not been found', $modelAlias, $modelId);
        $code = static::getErrorCode();
        return new static($message, $code, $previous);
    }
}
