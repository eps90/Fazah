<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Assert\AssertionFailedException;
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

    /**
     * @test
     */
    public function itShouldBeAbleToChangeAvailableLanguages(): void
    {
        $config = ProjectConfiguration::restoreFrom(['en', 'fr', 'pl']);
        $newLanguages = ['en', 'es', 'fr'];

        $newConfig = $config->changeAvailableLanguages($newLanguages);

        static::assertEquals($newLanguages, $newConfig->getAvailableLanguages());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenNewAvailableLanguagesAreNotArrayOfStrings(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Available languages must be a list of strings/');

        $invalidLanguages = ['en', 1, []];
        $config = ProjectConfiguration::initialize();

        $config->changeAvailableLanguages($invalidLanguages);
    }

    /**
     * @test
     */
    public function itShouldOmitRepeatedLanguagesWhenChangingAvailableLanguages(): void
    {
        $repetitiveLangs = ['en', 'en', 'pl', 'fr', 'fr', 'fr'];
        $config = ProjectConfiguration::initialize();

        $newConfig = $config->changeAvailableLanguages($repetitiveLangs);

        $expectedLangs = ['en', 'pl', 'fr'];
        $actualLangs = $newConfig->getAvailableLanguages();

        static::assertEquals($expectedLangs, $actualLangs);
    }
}
