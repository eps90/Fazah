<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\ProjectId;

class ProjectRepositoryException extends RepositoryException
{
    public static function notFound(ProjectId $projectId, \Throwable $previous = null): ProjectRepositoryException
    {
        return self::generateNotFoundException($projectId, $previous);
    }

    protected static function getModelAlias(): string
    {
        return 'Project';
    }

    protected static function getErrorCode(): int
    {
        return 3;
    }
}
