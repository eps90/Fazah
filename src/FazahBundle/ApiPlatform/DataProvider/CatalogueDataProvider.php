<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;

class CatalogueDataProvider implements CollectionDataProviderInterface
{
    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    /**
     * @var ArrayCollection|ExtensionInterface[]
     */
    private $extensions;

    public function __construct(CatalogueRepository $catalogueRepo, ArrayCollection $extensions = null)
    {
        $this->catalogueRepo = $catalogueRepo;
        $this->extensions = $extensions ?? new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if ($resourceClass !== Catalogue::class) {
            throw new ResourceClassNotSupportedException();
        }

        $criteria = new QueryCriteria(Catalogue::class);
        foreach ($this->extensions as $extension) {
            $extension->applyFilters($resourceClass, $criteria);
        }

        return $this->catalogueRepo->findAll($criteria);
    }
}
