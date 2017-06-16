<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\Project\ChangeProjectState;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class ChangeProjectStateTest extends SerializableCommandTest
{

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'project_id' => '03c28981-205c-4c45-b039-1b11e08ad502',
                    'enabled' => true
                ],
                'expected' => new ChangeProjectState(
                    new ProjectId('03c28981-205c-4c45-b039-1b11e08ad502'),
                    true
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'project_id' => '03c28981-205c-4c45-b039-1b11e08ad502'
                ]
            ],
            [
                'props' => [
                    'enabled' => true
                ]
            ],
            [
                'props' => [
                    'project_id' => '03c28981-205c-4c45-b039-1b11e08ad502',
                    'enabled' => 'non_boolean_value'
                ],
                'exception' => InvalidOptionsException::class
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return ChangeProjectState::class;
    }
}
