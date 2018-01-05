<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Repository\Exception\RepositoryManagerException;
use Eps\Fazah\Core\Repository\Manager\RepositoryManagerInterface;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;

class RepositoryDataProvider implements CollectionDataProviderInterface
{
    /**
     * @var RepositoryManagerInterface
     */
    private $repositoryManager;

    /**
     * @var ArrayCollection
     */
    private $extensions;

    public function __construct(RepositoryManagerInterface $repositoryManager, ArrayCollection $extensions)
    {
        $this->repositoryManager = $repositoryManager;
        $this->extensions = $extensions;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        try {
            $repository = $this->repositoryManager->getRepository($resourceClass);
            $criteria = new QueryCriteria($resourceClass);

            /** @var ExtensionInterface $extension */
            foreach ($this->extensions as $extension) {
                $extension->applyFilters($resourceClass, $criteria);
            }

            return $repository->findAll($criteria)->take(
                $criteria->getPagination()->getPage() - 1,
                $criteria->getPagination()->getElementsPerPage()
            );
        } catch (RepositoryManagerException $exception) {
            throw new ResourceClassNotSupportedException();
        }
    }
}
