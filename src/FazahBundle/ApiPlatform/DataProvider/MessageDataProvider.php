<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;

class MessageDataProvider implements CollectionDataProviderInterface
{
    /**
     * @var MessageRepository
     */
    private $messageRepo;

    /**
     * @var ArrayCollection|ExtensionInterface[]
     */
    private $extensions;

    public function __construct(MessageRepository $messageRepo, ArrayCollection $extensions = null)
    {
        $this->messageRepo = $messageRepo;
        $this->extensions = $extensions ?? new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if ($resourceClass !== Message::class) {
            throw new ResourceClassNotSupportedException();
        }

        $criteria = new QueryCriteria(Message::class);
        foreach ($this->extensions as $extension) {
            $extension->applyFilters($resourceClass, $criteria);
        }

        return $this->messageRepo->findAll($criteria);
    }
}
