<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Manager;

use Eps\Fazah\Core\Repository\RepositoryInterface;

interface RepositoryManagerInterface
{
    public function addRepository(string $modelClass, RepositoryInterface $repositoryClass): void;

    /**
     * @param string $modelClass
     * @return RepositoryInterface
     * @throws \Eps\Fazah\Core\Repository\Exception\RepositoryManagerException
     */
    public function getRepository(string $modelClass): RepositoryInterface;
}
