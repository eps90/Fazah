<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterInterface;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor\FilterProcessorInterface;
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
     * @var ArrayCollection|FilterProcessorInterface[]
     */
    private $filterProcessors;

    /**
     * FiltersExtension constructor.
     * @param RequestStack $requestStack
     * @param ArrayCollection|null $modelFilters
     * @param ArrayCollection $filterProcessors
     */
    public function __construct(
        RequestStack $requestStack,
        ArrayCollection $modelFilters = null,
        ArrayCollection $filterProcessors
    ) {
        $this->requestStack = $requestStack;
        $this->modelFilters = $modelFilters ?? new ArrayCollection();
        $this->filterProcessors = $filterProcessors;
    }

    public function applyFilters(string $resourceClass, QueryCriteria $criteria): void
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $requestedFilters = $currentRequest->query->all();

        foreach ($this->modelFilters as $filter) {
            if (!$filter->supportsResource($resourceClass)) {
                continue;
            }

            $availableFilters = $filter->getDescription($resourceClass);
            $availableFiltersNames = array_keys($availableFilters);
            $filters = array_filter(
                $requestedFilters,
                function ($filterName) use ($availableFiltersNames) {
                    return \in_array($filterName, $availableFiltersNames, true);
                },
                ARRAY_FILTER_USE_KEY
            );

            $processedFilters = $this->processFilters($filters, $availableFilters);
            $criteria->addFilter($processedFilters);
        }
    }

    private function processFilters(array $filters, array $filterDescription): array
    {
        foreach ($filters as $filterName => $filterValue) {
            $filterType = $filterDescription[$filterName]['type'];
            foreach ($this->filterProcessors as $processor) {
                if ($processor->supportsType($filterType)) {
                    $filters[$filterName] = $processor->processFiler($filters[$filterName]);
                }
            }
        }

        return $filters;
    }
}
