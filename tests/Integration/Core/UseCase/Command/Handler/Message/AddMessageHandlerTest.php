<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\UseCase\Command\Message\AddMessage;
use Eps\Fazah\Core\Utils\DateTimeFactory;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AddMessageHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var \DateTimeImmutable
     */
    private $now;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('test.tactician.commandbus');
        $this->loadFixtures([
            AddProjects::class,
            AddCatalogues::class
        ]);
        $this->now = new \DateTimeImmutable('2015-01-01 12:22:00');
        DateTimeFactory::freezeDate($this->now);
    }

    protected function tearDown()
    {
        parent::tearDown();

        DateTimeFactory::unfreezeDate();
    }

    /**
     * @test
     */
    public function itShouldAddUntranslatedMessages(): void
    {
        $messageKey = 'my.message';
        $catalogueId = new CatalogueId('a853f467-403d-416b-8269-36369c34d723');
        $command = new AddMessage($messageKey, $catalogueId);

        $this->commandBus->handle($command);

        $messagesRepo = $this->getContainer()->get('test.fazah.repository.message');
        $criteria = new QueryCriteria(Message::class, new FilterSet(['phrase' => $messageKey]));
        $messages = $messagesRepo->findAll($criteria);

        $expectedResult = [null, null, null];
        $actualResult = array_map(function (Message $message) {
            return $message->getTranslation()->getTranslatedMessage();
        }, $messages);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldAddMessageForAllConfiguredLanguages(): void
    {
        $messageKey = 'my.message';
        $catalogueId = new CatalogueId('a853f467-403d-416b-8269-36369c34d723');
        $command = new AddMessage($messageKey, $catalogueId);

        $this->commandBus->handle($command);

        $messagesRepo = $this->getContainer()->get('test.fazah.repository.message');
        $criteria = new QueryCriteria(Message::class, new FilterSet(['phrase' => $messageKey]));
        $messages = $messagesRepo->findAll($criteria);
        $expectedLanguages = ['en', 'fr', 'pl'];
        $actualLanguages = array_map(function (Message $message) {
            return $message->getTranslation()->getLanguage();
        }, $messages);

        static::assertEquals($expectedLanguages, $actualLanguages);
    }
}
