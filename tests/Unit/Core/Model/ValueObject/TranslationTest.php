<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Eps\Fazah\Core\Model\ValueObject\Translation;
use PHPUnit\Framework\TestCase;

class TranslationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateATranslation(): void
    {
        $messageKey = 'my.message';
        $translatedMessage = 'My translated message';
        $language = 'en';

        $translation = Translation::create($messageKey, $translatedMessage, $language);

        static::assertEquals($messageKey, $translation->getMessageKey());
        static::assertEquals($translatedMessage, $translation->getTranslatedMessage());
        static::assertEquals($language, $translation->getLanguage());
    }

    /**
     * @test
     */
    public function itShouldAlwaysLowerCaseLanguage(): void
    {
        $language = 'EN';

        $translation = Translation::create('my.message', 'Translated', $language);

        $expectedLanguage = 'en';
        static::assertEquals($expectedLanguage, $translation->getLanguage());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToCreateUntranslatedTranslation(): void
    {
        $messageKey = 'my_message';
        $language = 'fr';
        $emptyTranslation = Translation::untranslated($messageKey, $language);

        static::assertEquals($messageKey, $emptyTranslation->getMessageKey());
        static::assertEquals($language, $emptyTranslation->getLanguage());
        static::assertNull($emptyTranslation->getTranslatedMessage());
    }
}
