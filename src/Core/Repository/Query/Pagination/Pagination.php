<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Pagination;

final class Pagination
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_SIZE = null;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $elementsPerPage;

    public function __construct(int $page, ?int $elementsPerPage)
    {
        $this->page = $page;
        $this->elementsPerPage = $elementsPerPage;
    }

    public static function none(): self
    {
        return new self(self::DEFAULT_PAGE, self::DEFAULT_SIZE);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getElementsPerPage(): ?int
    {
        return $this->elementsPerPage;
    }
}
