<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Sorting;

final class Sorting
{
    public const ASCENDING = 'ASC';
    public const DESCENDING = 'DESC';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $direction;

    public function __construct(string $field, string $direction = self::ASCENDING)
    {
        if (strpos($field, '+') === 0) {
            $this->direction = self::ASCENDING;
            $this->field = ltrim($field, '+');
        } elseif (strpos($field, '-') === 0) {
            $this->direction = self::DESCENDING;
            $this->field = ltrim($field, '-');
        } else {
            $this->field = $field;
            $this->direction = $direction;
        }
    }

    public static function asc(string $field): Sorting
    {
        return new self($field, self::ASCENDING);
    }

    public static function desc(string $field): Sorting
    {
        return new self($field, self::DESCENDING);
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
