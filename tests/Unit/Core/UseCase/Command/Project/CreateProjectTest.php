<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Project;

use Eps\Fazah\Core\UseCase\Command\Project\CreateProject;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
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
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [],
                'exception' => MissingOptionsException::class
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return CreateProject::class;
    }
}
