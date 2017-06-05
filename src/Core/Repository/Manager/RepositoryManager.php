<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Manager;

use Eps\Fazah\Core\Repository\Exception\RepositoryManagerException;
use Eps\Fazah\Core\Repository\RepositoryInterface;

final class RepositoryManager implements RepositoryManagerInterface
{
    private $repos;

    public function __construct(array $repos = [])
    {
        $this->repos = $repos;
    }

    public function addRepository(string $modelClass, RepositoryInterface $repositoryClass): void
    {
        $this->repos[$modelClass] = $repositoryClass;
    }

    public function getRepository(string $modelClass): RepositoryInterface
    {
        if (!array_key_exists($modelClass, $this->repos)) {
            throw RepositoryManagerException::repositoryInstanceNotFound($modelClass);
        }
        return $this->repos[$modelClass];
    }
}
