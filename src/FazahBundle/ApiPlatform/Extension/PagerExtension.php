<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Extension;

use Eps\Fazah\Core\Repository\Query\Pagination\Pagination;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Symfony\Component\HttpFoundation\RequestStack;

class PagerExtension implements ExtensionInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function applyFilters(string $resourceClass, QueryCriteria $criteria): void
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $pageParam = $currentRequest->query->get('page', Pagination::DEFAULT_PAGE);
        $sizeParam = $currentRequest->query->get('limit', Pagination::DEFAULT_SIZE);

        $pagination = new Pagination(
            (int) $pageParam,
            $sizeParam === Pagination::DEFAULT_SIZE
                ? $sizeParam
                : (int) $sizeParam
        );

        $criteria->setPagination($pagination);
    }
}
