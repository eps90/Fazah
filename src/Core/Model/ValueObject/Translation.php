<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

use Assert\Assert;

final class Translation
{
    /**
     * @var string
     */
    private $messageKey;

    /**
     * @var string|null
     */
    private $translatedMessage;

    /**
     * @var string
     */
    private $language;

    public static function create(string $messageKey, ?string $translatedMessage, string $language): Translation
    {
        $translation = new self();

        $translation->setMessageKey($messageKey);
        $translation->setLanguage($language);
        $translation->translatedMessage = $translatedMessage;

        return $translation;
    }

    public static function untranslated(string $messageKey, string $language): Translation
    {
        $translation = new self();
        $translation->setMessageKey($messageKey);
        $translation->setLanguage($language);

        return $translation;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    /**
     * @return string|null
     */
    public function getTranslatedMessage(): ?string
    {
        return $this->translatedMessage;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function translateTo(string $translatedMessage): Translation
    {
        $translation = clone $this;
        $translation->translatedMessage = $translatedMessage;
        return $translation;
    }

    public function changeMessageKey(string $newMessageKey): Translation
    {
        $translation = clone $this;
        $translation->setMessageKey($newMessageKey);
        return $translation;
    }

    private function setMessageKey(string $messageKey): void
    {
        Assert::that($messageKey)
            ->notBlank('Message key cannot be blank')
            ->maxLength(255, 'Message key cannot be longer than 255 characters');

        $this->messageKey = $messageKey;
    }

    private function setLanguage(string $language): void
    {
        Assert::that($language)
            ->notBlank('Language code cannot be blank')
            ->maxLength(32, 'Language code cannot be longer than 32 characters');

        $this->language = strtolower($language);
    }
}
