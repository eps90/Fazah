<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\Identity;

use Eps\Fazah\Core\Model\Identity\ProjectId;

class ProjectIdTest extends BaseIdentityTest
{
    protected function getIdentityClass(): string
    {
        return ProjectId::class;
    }

    protected function getGenerateMethodName(): string
    {
        return 'generate';
    }
}
