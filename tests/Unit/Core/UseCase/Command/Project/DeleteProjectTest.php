<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\Project\DeleteProject;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class DeleteProjectTest extends SerializableCommandTest
{

    public function validInputProperties(): array
    {
        return [
            [
                'input' => [
                    'project_id' => 'b46bd83e-d902-49e5-a1fc-5c4440a45cc5'
                ],
                'expected' => new DeleteProject(new ProjectId('b46bd83e-d902-49e5-a1fc-5c4440a45cc5'))
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
        return DeleteProject::class;
    }
}
