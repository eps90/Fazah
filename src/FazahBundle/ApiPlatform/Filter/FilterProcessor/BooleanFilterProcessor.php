<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor;

final class BooleanFilterProcessor implements FilterProcessorInterface
{
    private const ALLOWED_TYPES = [
        'bool',
        'boolean',
        'Bool',
        'Boolean'
    ];

    private const KNOWN_VALUES = [
        'true' => true,
        'false' => false,
        '1' => true,
        '0' => false,
        null => false
    ];

    public function supportsType(string $filterType): bool
    {
        return \in_array($filterType, self::ALLOWED_TYPES, true);
    }

    public function processFiler($filterValue)
    {
        if (empty($filterValue)) {
            return false;
        }

        $newVal = strtolower($filterValue);
        if (array_key_exists($newVal, self::KNOWN_VALUES)) {
            return self::KNOWN_VALUES[$newVal];
        }

        return (bool) $filterValue;
    }
}
