<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\EditMessage;
use PHPUnit\Framework\TestCase;

class EditMessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSaveMessageProperties(): void
    {
        $messageProperties = [
            'message_key' => 'my.message',
            'translated_message' => 'Translated message'
        ];
        $command = new EditMessage(MessageId::generate(), $messageProperties);

        static::assertEquals($messageProperties, $command->getMessageData());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenThereAreRedundantDataInProperties(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $messageProperties = [
            'message_key' => 'my_message',
            'redundant_value' => 'this should throw'
        ];
        new EditMessage(MessageId::generate(), $messageProperties);
    }
}
