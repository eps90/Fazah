<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Message\AddMessage;
use Eps\Fazah\Core\UseCase\Command\Handler\Message\AddMessageHandler;
use PHPUnit\Framework\TestCase;

class AddMessageHandlerTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageRepository;

    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogueRepository;

    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $projectRepository;

    /**
     * @var AddMessageHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->messageRepository = $this->createMock(MessageRepository::class);
        $this->catalogueRepository = $this->createMock(CatalogueRepository::class);
        $this->projectRepository = $this->createMock(ProjectRepository::class);

        $this->handler = new AddMessageHandler(
            $this->messageRepository,
            $this->catalogueRepository,
            $this->projectRepository
        );
    }

    /**
     * @test
     */
    public function itShouldAddUntranslatedMessagesForEachLanguage(): void
    {
        $catalogueId = CatalogueId::generate();
        $messageKey = 'message.key';
        $command = new AddMessage($messageKey, $catalogueId);

        $projectId = ProjectId::generate();
        $foundCatalogue = Catalogue::restoreFrom(
            $catalogueId,
            'my catalogue',
            $projectId,
            null,
            Metadata::initialize()
        );
        $this->catalogueRepository->expects($this->once())
            ->method('find')
            ->with($catalogueId)
            ->willReturn($foundCatalogue);

        $this->projectRepository->expects($this->once())
            ->method('find')
            ->with($projectId)
            ->willReturn(Project::restoreFrom(
                $projectId,
                'My project',
                Metadata::initialize(),
                ProjectConfiguration::restoreFrom(['fr', 'en'])
            ));

        $this->messageRepository->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Message $message) use ($catalogueId) {
                    return $message->getCatalogueId() === $catalogueId
                        && $message->getTranslation()->getLanguage() === 'fr'
                        && $message->getTranslation()->getTranslatedMessage() === null;
                }),
                $this->callback(function (Message $message) use ($catalogueId) {
                    return $message->getCatalogueId() === $catalogueId
                        && $message->getTranslation()->getLanguage() === 'en'
                        && $message->getTranslation()->getTranslatedMessage() === null;
                })
            );

        $this->handler->handle($command);
    }
}
