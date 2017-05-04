<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Filtering;

final class FilterSet implements \ArrayAccess
{
    /**
     * @var string[]
     */
    private $filters;

    /**
     * Filters constructor.
     * @param string[] $conditions
     */
    public function __construct(array $conditions = [])
    {
        $this->filters = $conditions;
    }

    public function contains(string $filterName): bool
    {
        return array_key_exists($filterName, $this->filters);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->contains($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->filters[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
    }
}
