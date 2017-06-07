<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter;

use ApiPlatform\Core\Api\FilterInterface as BaseFilterInterface;

interface FilterInterface extends BaseFilterInterface
{
    public function supportsResource(string $resourceClass): bool;
}
