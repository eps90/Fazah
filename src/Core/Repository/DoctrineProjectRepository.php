<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;

final class DoctrineProjectRepository implements ProjectRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Project ...$projects): void
    {
        foreach ($projects as $project) {
            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function find(ProjectId $projectId): Project
    {
        $project = $this->entityManager->find(Project::class, $projectId);
        if ($project === null) {
            throw ProjectRepositoryException::notFound($projectId);
        }

        return $project;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->entityManager->createQuery('SELECT p FROM Fazah:Project p')->getResult();
    }
}
