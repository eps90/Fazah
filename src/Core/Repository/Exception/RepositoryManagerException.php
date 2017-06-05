<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

class RepositoryManagerException extends \LogicException
{
    public static function repositoryInstanceNotFound(string $modelClass, \Throwable $previous = null): self
    {
        $message = sprintf('Repository for class %s has not been found', $modelClass);
        $code = 999;

        return new self($message, $code, $previous);
    }
}
