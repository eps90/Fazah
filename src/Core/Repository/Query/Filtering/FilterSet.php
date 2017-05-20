<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Filtering;

final class FilterSet
{
    /**
     * @var string[]
     */
    private $filters;

    public function __construct(array $conditions = [])
    {
        $this->filters = $conditions;
    }

    public static function none(): FilterSet
    {
        return new self([]);
    }

    public function contains(string $filterName): bool
    {
        return array_key_exists($filterName, $this->filters);
    }

    public function getFilter(string $propertyName)
    {
        return $this->filters[$propertyName] ?? null;
    }

    public function isEmpty(): bool
    {
        return empty($this->filters);
    }

    public function addFilter(array $filterToAdd): FilterSet
    {
        $filters = array_merge_recursive($this->filters, $filterToAdd);
        return new self($filters);
    }
}
