<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Pagination;

final class Pagination
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_SIZE = 0;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $elementsPerPage;

    public function __construct($page, $elementsPerPage)
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

    public function getElementsPerPage(): int
    {
        return $this->elementsPerPage;
    }
}
