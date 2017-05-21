<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\DataProvider\MessageDataProvider;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;
use PHPUnit\Framework\TestCase;

class MessageDataProviderTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repo;

    /**
     * @var MessageDataProvider
     */
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->createMock(MessageRepository::class);
        $this->provider = new MessageDataProvider($this->repo);
    }

    /**
     * @test
     */
    public function itShouldNotSupportOtherModelsThanMessage(): void
    {
        $this->expectException(ResourceClassNotSupportedException::class);

        $invalidModel = Catalogue::class;
        $this->provider->getCollection($invalidModel);
    }

    /**
     * @test
     */
    public function itShouldCallRepositoryToFetchAllMessages(): void
    {
        $foundMessages = [
            Message::create(Translation::untranslated('a', 'fr'), CatalogueId::generate()),
            Message::create(Translation::untranslated('b', 'fr'), CatalogueId::generate()),
        ];
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with(new QueryCriteria(Message::class))
            ->willReturn($foundMessages);

        $expectedResult = $foundMessages;
        $actualResult = $this->provider->getCollection(Message::class);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldApplyExtensionsToCriteria(): void
    {
        $extensions = new ArrayCollection([$this->createFilterExtension()]);
        $this->provider = new MessageDataProvider($this->repo, $extensions);

        $foundMessages = [
            Message::create(Translation::untranslated('a', 'fr'), CatalogueId::generate()),
            Message::create(Translation::untranslated('b', 'fr'), CatalogueId::generate()),
        ];
        $expectedCriteria = new QueryCriteria(Message::class, new FilterSet(['my_filter' => 'filter_value']));
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with($expectedCriteria)
            ->willReturn($foundMessages);

        $expectedResult = $foundMessages;
        $actualResult = $this->provider->getCollection(Message::class);

        static::assertEquals($expectedResult, $actualResult);
    }

    private function createFilterExtension(): ExtensionInterface
    {
        return new class implements ExtensionInterface {
            public function applyFilters(string $resourceClass, QueryCriteria $criteria): void
            {
                $criteria->addFilter(['my_filter' => 'filter_value']);
            }
        };
    }
}
