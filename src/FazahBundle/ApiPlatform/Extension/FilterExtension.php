<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterExtension implements ExtensionInterface
{
    /**
     * @var ArrayCollection|FilterInterface[]
     */
    private $modelFilters;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * FiltersExtension constructor.
     * @param RequestStack $requestStack
     * @param ArrayCollection|null $modelFilters
     */
    public function __construct(RequestStack $requestStack, ArrayCollection $modelFilters = null)
    {
        $this->requestStack = $requestStack;
        $this->modelFilters = $modelFilters ?? new ArrayCollection();
    }

    public function applyFilters(string $resourceClass, QueryCriteria $criteria): void
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $requestedFilters = $currentRequest->query->all();

        foreach ($this->modelFilters as $filter) {
            if (!$filter->supportsResource($resourceClass)) {
                continue;
            }

            $availableFilters = array_keys($filter->getDescription($resourceClass));
            $filters = array_filter(
                $requestedFilters,
                function ($filterName) use ($availableFilters) {
                    return in_array($filterName, $availableFilters, true);
                },
                ARRAY_FILTER_USE_KEY
            );
            $criteria->addFilter($filters);
        }
    }
}
