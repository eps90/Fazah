<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\Project\EditProject;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class EditProjectTest extends SerializableCommandTest
{
    /**
     * @test
     */
    public function itShouldAssignProjectDataToProperty(): void
    {
        $projectData = [
            'name' => 'This name will change',
            'available_languages' => ['en', 'fr', 'pl']
        ];
        $command = new EditProject(ProjectId::generate(), $projectData);

        static::assertEquals($projectData, $command->getProjectData());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenPropertyIsNotDefined(): void
    {
        $this->expectException(UndefinedOptionsException::class);

        $projectData = [
            'name' => 'this name will change',
            'redundant_property' => 'this should throw'
        ];
        new EditProject(ProjectId::generate(), $projectData);
    }

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'project_id' => '421772af-9294-48bf-a003-17d9e484ba2a',
                    'project_data' => [
                        'name' => 'This name will change',
                        'available_languages' => ['en', 'fr', 'pl']
                    ]
                ],
                'expected' => new EditProject(
                    new ProjectId('421772af-9294-48bf-a003-17d9e484ba2a'),
                    [
                        'name' => 'This name will change',
                        'available_languages' => ['en', 'fr', 'pl']
                    ]
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'project_id' => '421772af-9294-48bf-a003-17d9e484ba2a',
                    'project_data' => [
                        'name' => 'this name will change',
                        'redundant_property' => 'this should throw'
                    ]
                ],
                'exception' => UndefinedOptionsException::class
            ],
            [
                'props' => [
                    'project_data' => [
                        'name' => 'This name will change',
                        'available_languages' => ['en', 'fr', 'pl']
                    ]
                ],
                'exception' => MissingOptionsException::class
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return EditProject::class;
    }
}
