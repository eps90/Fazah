<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Project;

use Eps\Fazah\Core\UseCase\Command\Project\CreateProject;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

class CreateProjectTest extends SerializableCommandTest
{
    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'name' => 'My command'
                ],
                'expected' => new CreateProject('My command')
            ],
            [
                'props' => [
                    'name' => 'My command',
                    'available_languages' => ['pl']
                ],
                'expected' => new CreateProject('My command', ['pl'])
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [],
                'exception' => MissingOptionsException::class
            ],
            [
                'props' => [
                    'name' => ['My command']
                ],
                'exception' => InvalidOptionsException::class
            ],
            [
                'props' => [
                    'name' => 'My command',
                    'available_languages' => null
                ],
                'exception' => InvalidOptionsException::class
            ],
            [
                'props' => [
                    'name' => 'My command',
                    'available_languages' => 'pl'
                ],
                'exception' => InvalidOptionsException::class
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return CreateProject::class;
    }
}
