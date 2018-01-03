<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor;

interface FilterProcessorInterface
{
    public function supportsType(string $filterType): bool;
    public function processFiler($filterValue);
}
