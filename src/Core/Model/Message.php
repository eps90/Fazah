<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

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
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var Metadata
     */
    private $metadata;

    public static function create(
        string $messageKey,
        string $translation,
        string $language,
        CatalogueId $catalogueId
    ): Message {
        $message = new self();
        $message->messageId = MessageId::generate();
        $message->messageKey = $messageKey;
        $message->translatedMessage = $translation;
        $message->language = $language;
        $message->catalogueId = $catalogueId;
        $message->metadata = Metadata::initialize();

        return $message;
    }

    public static function restoreFrom(
        MessageId $messageId,
        string $messageKey,
        string $translatedMessage,
        string $language,
        CatalogueId $catalogueId,
        Metadata $metadata
    ): Message {
        $message = new self();
        $message->messageId = $messageId;
        $message->messageKey = $messageKey;
        $message->translatedMessage = $translatedMessage;
        $message->language = $language;
        $message->metadata = $metadata;
        $message->catalogueId = $catalogueId;

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
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }
}
