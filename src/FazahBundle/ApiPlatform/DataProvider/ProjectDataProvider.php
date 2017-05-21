<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;

class ProjectDataProvider implements CollectionDataProviderInterface
{
    /**
     * @var ProjectRepository
     */
    private $projectsRepo;

    /**
     * @var ArrayCollection|ExtensionInterface[]
     */
    private $extensions;

    public function __construct(ProjectRepository $projectsRepo, ArrayCollection $extensions = null)
    {
        $this->projectsRepo = $projectsRepo;
        $this->extensions = $extensions ?? new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if ($resourceClass !== Project::class) {
            throw new ResourceClassNotSupportedException();
        }

        $criteria = new QueryCriteria(Project::class);
        foreach ($this->extensions as $extension) {
            $extension->applyFilters(Project::class, $criteria);
        }

        return $this->projectsRepo->findAll($criteria);
    }
}
