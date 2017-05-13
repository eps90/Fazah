<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

use Assert\Assertion;

final class ProjectConfiguration
{
    /**
     * @var string[]
     */
    private $availableLanguages;

    public static function initialize(): ProjectConfiguration
    {
        $instance = new self();
        $instance->availableLanguages = [];

        return $instance;
    }

    public static function restoreFrom(array $availableLanguages): ProjectConfiguration
    {
        $instance = new self();
        $instance = $instance->changeAvailableLanguages($availableLanguages);

        return $instance;
    }

    /**
     * @return string[]
     */
    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    /**
     * @param string[] $newLanguages
     * @return ProjectConfiguration
     */
    public function changeAvailableLanguages(array $newLanguages): ProjectConfiguration
    {
        Assertion::allString($newLanguages, 'Available languages must be a list of strings');

        $newConfig = clone $this;
        $newConfig->availableLanguages = array_values(array_unique($newLanguages));

        return $newConfig;
    }
}
