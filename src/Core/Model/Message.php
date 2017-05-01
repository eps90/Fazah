<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;

class Message
{
    /**
     * @var MessageId
     */
    private $messageId;

    /**
     * @var string
     */
    private $messageKey;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $translatedMessage;

    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon|null
     */
    private $updatedAt;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var CatalogueId
     */
    private $catalogueId;

    public static function create(
        string $messageKey,
        string $translation,
        string $language,
        CatalogueId $catalogueId
    ): self {
        $message = new self();
        $message->messageId = MessageId::generate();
        $message->messageKey = $messageKey;
        $message->translatedMessage = $translation;
        $message->language = $language;
        $message->catalogueId = $catalogueId;
        $message->enabled = true;
        $message->createdAt = Carbon::now();

        return $message;
    }

    /**
     * @return MessageId
     */
    public function getMessageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getTranslatedMessage(): string
    {
        return $this->translatedMessage;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }
}
