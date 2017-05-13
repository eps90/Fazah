<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @var Carbon
     */
    private $now;

    /**
     * @var Message
     */
    private $newMessage;

    protected function setUp()
    {
        parent::setUp();

        $this->now = Carbon::create(
            2017,
            05,
            01,
            16,
            14,
            02,
            new \DateTimeZone('UTC')
        );
        Carbon::setTestNow($this->now);
        $this->newMessage = $this->createNewMessage();
    }

    protected function tearDown()
    {
        parent::tearDown();

        Carbon::setTestNow();
    }

    /**
     * @test
     */
    public function itShouldConstructBasicMessage(): void
    {
        $translation = Translation::create(
            'my.message.to.translate',
            'Bonjour !',
            'fr'
        );
        $catalogueId = CatalogueId::generate();

        $message = Message::create($translation, $catalogueId);

        static::assertEquals($translation, $message->getTranslation());
    }

    /**
     * @test
     */
    public function itShouldGenerateMessageId(): void
    {
        static::assertNotNull($this->newMessage->getId());
    }

    /**
     * @test
     */
    public function itShouldBeEnabledByDefault(): void
    {
        static::assertTrue($this->newMessage->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldKeepCreationDateOnCreation(): void
    {
        static::assertEquals($this->now, $this->newMessage->getMetadata()->getCreationTime());
    }

    /**
     * @test
     */
    public function itShouldHaveInitiallyEmptyUpdateDate(): void
    {
        static::assertNull($this->newMessage->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldHaveAReferenceToCatalogue(): void
    {
        static::assertNotNull($this->newMessage->getCatalogueId());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreModelFromValues(): void
    {
        $messageId = MessageId::generate();
        $translation = Translation::create(
            'my.message',
            'Hello!',
            'en'
        );
        $catalogueId = CatalogueId::generate();
        $metadata = Metadata::restoreFrom(
            Carbon::parse('2015-01-01 12:00:00'),
            Carbon::now(),
            true
        );

        $message = Message::restoreFrom(
            $messageId,
            $translation,
            $catalogueId,
            $metadata
        );

        static::assertEquals($messageId, $message->getId());
        static::assertEquals($translation, $message->getTranslation());
        static::assertEquals($metadata, $message->getMetadata());
        static::assertEquals($catalogueId, $message->getCatalogueId());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDisableAMessage(): void
    {
        $message = Message::create(
            Translation::create(
                'my.message',
                null,
                'en'
            ),
            CatalogueId::generate()
        );
        $message->disable();

        static::assertFalse($message->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToEnabledAMessage(): void
    {
        $message = Message::restoreFrom(
            MessageId::generate(),
            Translation::create(
                'my.message',
                null,
                'en'
            ),
            CatalogueId::generate(),
            Metadata::restoreFrom(
                Carbon::now(),
                Carbon::now(),
                false
            )
        );
        $message->enable();

        static::assertTrue($message->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToChangeMessageKey(): void
    {
        $newMessageKey = 'my.new.message.key';
        $this->newMessage->changeMessageKey($newMessageKey);

        static::assertEquals($newMessageKey, $this->newMessage->getTranslation()->getMessageKey());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeWhenMessageKeyChanges(): void
    {
        $this->newMessage->changeMessageKey('some.message');
        static::assertEquals($this->now, $this->newMessage->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToChangeTranslatedMessage(): void
    {
        $newTranslation = 'Salut !';
        $this->newMessage->changeTranslatedMessage($newTranslation);

        static::assertEquals($newTranslation, $this->newMessage->getTranslation()->getTranslatedMessage());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeWhenTranslatedMessageChanges(): void
    {
        $this->newMessage->changeTranslatedMessage('My new translation');
        static::assertEquals($this->now, $this->newMessage->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToUpdateMessageFromArray(): void
    {
        $messageKey = 'new.message_key';
        $translatedMessage = 'Ça va?';
        $updateMap = [
            'message_key' => $messageKey,
            'translated_message' => $translatedMessage
        ];

        $this->newMessage->updateFromArray($updateMap);

        static::assertEquals($messageKey, $this->newMessage->getTranslation()->getMessageKey());
        static::assertEquals($translatedMessage, $this->newMessage->getTranslation()->getTranslatedMessage());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeWhenUpdatingFromArray(): void
    {
        $messageKey = 'new.message_key';
        $translatedMessage = 'Ça va?';
        $updateMap = [
            'message_key' => $messageKey,
            'translated_message' => $translatedMessage
        ];

        $this->newMessage->updateFromArray($updateMap);

        static::assertEquals($this->now, $this->newMessage->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldNotChangeUpdateTimeWhenNothingChanges(): void
    {
        $updateMap = [];
        $this->newMessage->updateFromArray($updateMap);

        static::assertNull($this->newMessage->getMetadata()->getUpdateTime());
    }

    private function createNewMessage(): Message
    {
        $translation = Translation::create(
            'my.message.to.translate',
            'Bonjour !',
            'fr'
        );
        $catalogueId = CatalogueId::generate();

        return Message::create($translation, $catalogueId);
    }
}
