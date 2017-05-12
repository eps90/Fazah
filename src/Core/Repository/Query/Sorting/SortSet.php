<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Sorting;

final class SortSet
{
    /**
     * @var Sorting[]
     */
    private $sorting;

    public function __construct(Sorting ...$sorting)
    {
        $this->sorting = $sorting;
    }

    public static function none(): SortSet
    {
        return new self();
    }

    /**
     * @return Sorting[]
     */
    public function getFieldsSorting(): array
    {
        return $this->sorting;
    }

    public function isEmpty(): bool
    {
        return empty($this->sorting);
    }

    public function contains(string $field): bool
    {
        foreach ($this->sorting as $sorting) {
            if ($sorting->getField() === $field) {
                return true;
            }
        }

        return false;
    }

    public function findField(string $fieldName): ?Sorting
    {
        foreach ($this->sorting as $sorting) {
            if ($sorting->getField() === $fieldName) {
                return $sorting;
            }
        }

        return null;
    }
}
