<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\EditProject;
use PHPUnit\Framework\TestCase;

class EditProjectTest extends TestCase
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
        $this->expectException(\InvalidArgumentException::class);

        $projectData = [
            'name' => 'this name will change',
            'redundant_property' => 'this should throw'
        ];
        new EditProject(ProjectId::generate(), $projectData);
    }
}
