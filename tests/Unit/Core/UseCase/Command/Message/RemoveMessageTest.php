<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMessage;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class RemoveMessageTest extends SerializableCommandTest
{
    public function validInputProperties(): array
    {
        return [
            [
                'input' => [
                    'message_id' => '6915f1a9-64db-4c73-bbed-324c5c5b558e'
                ],
                'expected' => new RemoveMessage(new MessageId('6915f1a9-64db-4c73-bbed-324c5c5b558e'))
            ]
        ];
    }
    
    public function invalidInputProperties(): array
    {
        return [
            [
                'input' => []
            ]
        ];
    }
    
    public function getCommandClass(): string
    {
        return RemoveMessage::class;
    }
}
