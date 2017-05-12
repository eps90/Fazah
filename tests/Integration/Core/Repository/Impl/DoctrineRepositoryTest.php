<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Eps\Fazah\Core\Model\Identity\Identity;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class DoctrineRepositoryTest extends WebTestCase
{
    abstract public function getRepositoryInstance();
    abstract public function getRepositoryFixtures(): array;

    abstract public function modelIdProvider(): array;
    abstract public function saveProvider(): array;
    abstract public function missingModelProvider(): array;
    abstract public function findAllProvider(): array;
    abstract public function updateProvider(): array;
    abstract public function uniqueModelProvider(): array;

    protected function setUp()
    {
        parent::setUp();

        $this->loadFixtures($this->getRepositoryFixtures());
    }

    /**
     * @test
     * @dataProvider modelIdProvider
     */
    public function itShouldFindModelByModelId(Identity $modelId, $expected): void
    {
        $repository = $this->getRepositoryInstance();
        $actualCatalogue = $repository->find($modelId);

        static::assertEquals($expected, $actualCatalogue);
    }

    /**
     * @test
     * @dataProvider missingModelProvider
     */
    public function itShouldThrowWhenGivenModelIdDoesNotExist(Identity $modelId, string $exceptionClass): void
    {
        $repository = $this->getRepositoryInstance();
        $this->expectException($exceptionClass);
        $repository->find($modelId);
    }

    /**
     * @test
     * @dataProvider saveProvider
     */
    public function itShouldSaveNewModelInstance(array $models): void
    {
        $repository = $this->getRepositoryInstance();
        $repository->save(...$models);

        foreach ($models as $model) {
            $actualModel = $repository->find($model->getId());

            static::assertEquals($model, $actualModel);
        }
    }

    /**
     * @test
     * @dataProvider findAllProvider
     */
    public function itShouldReturnAllModels(QueryCriteria $criteria = null, array $expected = []): void
    {
        $repository = $this->getRepositoryInstance();
        $actualModels = $repository->findAll($criteria);
        static::assertEquals($expected, $actualModels);
    }

    /**
     * @test
     * @dataProvider updateProvider
     */
    public function itShouldUpdateModelChanges(
        $inputModel,
        callable $changeFunc,
        callable $expect
    ): void {
        $repository = $this->getRepositoryInstance();
        $repository->save($inputModel);

        $savedInstance = $repository->find($inputModel->getId());

        $changeFunc($savedInstance);
        $repository->save($savedInstance);

        $actualModel = $repository->find($inputModel->getId());

        static::assertTrue($expect($actualModel));
    }

    /**
     * @test
     * @dataProvider uniqueModelProvider
     */
    public function itShouldntBeAbleToAddDuplicatedModel(array $instances): void
    {
        $this->expectException(UniqueConstraintViolationException::class);
        $this->getRepositoryInstance()->save(...$instances);
    }
}
