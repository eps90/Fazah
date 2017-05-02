<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\ProjectId;

class ProjectRepositoryException extends \LogicException
{
    public static function notFound(ProjectId $projectId, \Throwable $previous = null): ProjectRepositoryException
    {
        $message = sprintf('Project with id %s cannot be found', $projectId);
        $code = 3;
        return new self($message, $code, $previous);
    }
}
