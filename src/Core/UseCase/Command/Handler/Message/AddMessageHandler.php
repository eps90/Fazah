<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Message\AddMessage;

class AddMessageHandler
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    /**
     * AddMessageHandler constructor.
     * @param MessageRepository $messageRepo
     * @param CatalogueRepository $catalogueRepo
     * @param ProjectRepository $projectRepo
     */
    public function __construct(
        MessageRepository $messageRepo,
        CatalogueRepository $catalogueRepo,
        ProjectRepository $projectRepo
    ) {
        $this->messageRepo = $messageRepo;
        $this->catalogueRepo = $catalogueRepo;
        $this->projectRepo = $projectRepo;
    }

    public function handle(AddMessage $command)
    {
        $catalogueId = $command->getCatalogueId();
        $catalogue = $this->catalogueRepo->find($catalogueId);
        $project = $this->projectRepo->find($catalogue->getProjectId());
        $languages = $project->getConfig()->getAvailableLanguages();

        $messageKey = $command->getMessageKey();
        $messages = array_map(function (string $language) use ($messageKey, $catalogueId) {
            return Message::create(
                Translation::untranslated($messageKey, $language),
                $catalogueId
            );
        }, $languages);

        $this->messageRepo->save(...$messages);
    }
}
