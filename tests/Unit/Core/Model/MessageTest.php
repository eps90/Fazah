<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
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
        $messageKey = 'my.message.to.translate';
        $language = 'fr';
        $translatedMessage = 'Bonjour !';
        $catalogueId = CatalogueId::generate();

        $message = Message::create($messageKey, $translatedMessage, $language, $catalogueId);

        static::assertEquals($messageKey, $message->getMessageKey());
        static::assertEquals($translatedMessage, $message->getTranslatedMessage());
        static::assertEquals($language, $message->getLanguage());
    }

    /**
     * @test
     */
    public function itShouldGenerateMessageId(): void
    {
        static::assertNotNull($this->newMessage->getMessageId());
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
        $messageKey = 'my.message';
        $translatedMessage = 'Hello!';
        $language = 'en';
        $catalogueId = CatalogueId::generate();
        $metadata = Metadata::restoreFrom(
            Carbon::instance(new \DateTime('2015-01-01 12:00:00')),
            Carbon::now(),
            true
        );

        $message = Message::restoreFrom(
            $messageId,
            $messageKey,
            $translatedMessage,
            $language,
            $catalogueId,
            $metadata
        );

        static::assertEquals($messageId, $message->getMessageId());
        static::assertEquals($messageKey, $message->getMessageKey());
        static::assertEquals($translatedMessage, $message->getTranslatedMessage());
        static::assertEquals($language, $message->getLanguage());
        static::assertEquals($metadata, $message->getMetadata());
        static::assertEquals($catalogueId, $message->getCatalogueId());
    }

    private function createNewMessage(): Message
    {
        $messageKey = 'my.message.to.translate';
        $language = 'fr';
        $translatedMessage = 'Bonjour !';
        $catalogueId = CatalogueId::generate();

        return Message::create($messageKey, $translatedMessage, $language, $catalogueId);
    }
}
