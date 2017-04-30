<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Message
{
    /**
     * @var UuidInterface
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

    public static function create(string $messageKey, string $translation, string $language): self
    {
        $message = new self();
        $message->messageId = Uuid::uuid4();
        $message->messageKey = $messageKey;
        $message->translatedMessage = $translation;
        $message->language = $language;
        $message->enabled = true;
        $message->createdAt = Carbon::now();

        return $message;
    }

    /**
     * @return UuidInterface
     */
    public function getMessageId(): UuidInterface
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
}
