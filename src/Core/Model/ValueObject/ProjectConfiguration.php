<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

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
        $instance->availableLanguages = $availableLanguages;

        return $instance;
    }

    /**
     * @return string[]
     */
    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }
}
