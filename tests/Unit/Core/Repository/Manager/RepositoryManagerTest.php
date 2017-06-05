<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Manager;

use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Exception\RepositoryManagerException;
use Eps\Fazah\Core\Repository\Manager\RepositoryManager;
use Eps\Fazah\Core\Repository\MessageRepository;
use PHPUnit\Framework\TestCase;

class RepositoryManagerTest extends TestCase
{
    /**
     * @var RepositoryManager
     */
    private $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = new RepositoryManager();
    }

    /**
     * @test
     */
    public function itShouldReturnRepositoryForModel(): void
    {
        $repository = $this->createMock(MessageRepository::class);
        $this->manager->addRepository(Message::class, $repository);

        $modelClass = Message::class;
        $actualRepository = $this->manager->getRepository($modelClass);

        static::assertEquals($repository, $actualRepository);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenRepositoryHasNotBeenFound(): void
    {
        $this->expectException(RepositoryManagerException::class);

        $this->manager->getRepository(\stdClass::class);
    }

}
