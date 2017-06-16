<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\Message\AddMessage;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class AddMessageTest extends SerializableCommandTest
{
    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_key' => 'messasge.key',
                    'catalogue_id' => 'a55b8a36-f767-4e85-aed4-23d0983ab6fe'
                ],
                'expected' => new AddMessage(
                    'messasge.key',
                    new CatalogueId('a55b8a36-f767-4e85-aed4-23d0983ab6fe')
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_key' => 'message.key'
                ]
            ],
            [
                'props' => [
                    'catalogue_id' => 'a55b8a36-f767-4e85-aed4-23d0983ab6fe'
                ]
            ],
            [
                'props' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return AddMessage::class;
    }
}
