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

    public function contains(string $filterName): bool
    {
        return array_key_exists($filterName, $this->filters);
    }

    public function getFilter(string $propertyName)
    {
        return $this->filters[$propertyName] ?? null;
    }
}
