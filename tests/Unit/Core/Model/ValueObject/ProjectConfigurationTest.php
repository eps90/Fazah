<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use PHPUnit\Framework\TestCase;

class ProjectConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldInitializeConfigWithEmptySettings(): void
    {
        $config = ProjectConfiguration::initialize();

        static::assertEmpty($config->getAvailableLanguages());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreConfig(): void
    {
        $availableLanguages = ['en', 'fr', 'pl'];
        $config = ProjectConfiguration::restoreFrom($availableLanguages);

        static::assertEquals($availableLanguages, $config->getAvailableLanguages());
    }
}
