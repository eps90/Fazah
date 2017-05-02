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

    static protected function getModelAlias(): string
    {
        return 'Project';
    }

    static protected function getErrorCode(): int
    {
        return 3;
    }
}
