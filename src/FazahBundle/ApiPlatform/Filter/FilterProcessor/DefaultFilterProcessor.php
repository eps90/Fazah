<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor;

final class DefaultFilterProcessor implements FilterProcessorInterface
{

    public function supportsType(string $filterType): bool
    {
        return true;
    }

    public function processFiler($filterValue)
    {
        return $filterValue;
    }
}
