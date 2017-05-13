<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Assert\AssertionFailedException;
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

    /**
     * @test
     */
    public function itShouldBeAbleToSetTranslationMessage(): void
    {
        $messageKey = 'my_message';
        $language = 'en';
        $emptyTranslation = Translation::untranslated($messageKey, $language);

        $translatedMessage = 'This is my message';
        $newTranslation = $emptyTranslation->translateTo($translatedMessage);

        $expectedTranslated = Translation::create($messageKey, $translatedMessage, $language);

        static::assertEquals($expectedTranslated, $newTranslation);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToChangeMessageKey(): void
    {
        $messageKey = 'message_key';
        $language = 'fr';
        $translatedMessage = "C'est mon message";
        $translation = Translation::create($messageKey, $translatedMessage, $language);

        $newMessageKey = 'say_hello';
        $withNewKey = $translation->changeMessageKey($newMessageKey);

        $expectedTranslation = Translation::create($newMessageKey, $translatedMessage, $language);

        static::assertEquals($expectedTranslation, $withNewKey);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenNewMessageKeyIsBlank(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Message key cannot be blank/');

        $invalidMessageKey = '';
        $translation = Translation::untranslated('old.message_key', 'fr');
        $translation->changeMessageKey($invalidMessageKey);
    }
}
