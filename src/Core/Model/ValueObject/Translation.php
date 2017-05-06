<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

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

        $translation->messageKey = $messageKey;
        $translation->translatedMessage = $translatedMessage;
        $translation->language = strtolower($language);

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
}
