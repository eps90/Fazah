<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;

class Message
{
    /**
     * @var MessageId
     */
    private $id;

    /**
     * @var Translation
     */
    private $translation;

    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var Metadata
     */
    private $metadata;

    public static function create(
        Translation $translation,
        CatalogueId $catalogueId
    ): Message {
        $message = new self();
        $message->id = MessageId::generate();
        $message->translation = $translation;
        $message->catalogueId = $catalogueId;
        $message->metadata = Metadata::initialize();

        return $message;
    }

    public static function restoreFrom(
        MessageId $messageId,
        Translation $translation,
        CatalogueId $catalogueId,
        Metadata $metadata
    ): Message {
        $message = new self();
        $message->id = $messageId;
        $message->translation = $translation;
        $message->metadata = $metadata;
        $message->catalogueId = $catalogueId;

        return $message;
    }

    /**
     * @return MessageId
     */
    public function getId(): MessageId
    {
        return $this->id;
    }

    /**
     * @return Translation
     */
    public function getTranslation(): Translation
    {
        return $this->translation;
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

    public function disable(): void
    {
        $this->metadata = $this->metadata->markAsDisabled();
    }

    public function enable(): void
    {
        $this->metadata = $this->metadata->markAsEnabled();
    }
}
