<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query;

use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

final class QueryCriteria
{
    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var FilterSet
     */
    private $filters;

    /**
     * @var SortSet
     */
    private $sorting;

    /**
     * FilterCriteria constructor.
     * @param string $modelClass
     * @param FilterSet $filterSet
     * @param SortSet $sortSet
     */
    public function __construct(string $modelClass, FilterSet $filterSet, SortSet $sortSet)
    {
        $this->modelClass = $modelClass;
        $this->filters = $filterSet;
        $this->sorting = $sortSet;
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @return FilterSet
     */
    public function getFilters(): FilterSet
    {
        return $this->filters;
    }

    /**
     * @return SortSet
     */
    public function getSorting(): SortSet
    {
        return $this->sorting;
    }
}
