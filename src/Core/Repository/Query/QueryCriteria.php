<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query;

use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\Pagination\Pagination;
use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
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
     * @var Pagination
     */
    private $pagination;

    /**
     * FilterCriteria constructor.
     * @param string $modelClass
     * @param FilterSet $filterSet
     * @param SortSet $sortSet
     */
    public function __construct(
        string $modelClass,
        FilterSet $filterSet = null,
        SortSet $sortSet = null,
        Pagination $pagination = null
    ) {
        $this->modelClass = $modelClass;
        $this->filters = $filterSet ?? FilterSet::none();
        $this->sorting = $sortSet ?? SortSet::none();
        $this->pagination = $pagination ?? Pagination::none();
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

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function addFilter(array $filterToAdd): void
    {
        $this->filters = $this->filters->addFilter($filterToAdd);
    }

    public function addSorting(Sorting $sortingToAdd): void
    {
        $this->sorting = $this->sorting->addSorting($sortingToAdd);
    }

    public function setPagination($pagination): void
    {
        $this->pagination = $pagination;
    }
}
