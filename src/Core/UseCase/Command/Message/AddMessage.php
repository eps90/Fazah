<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddMessage implements DeserializableCommandInterface
{
    /**
     * @var string
     */
    private $messageKey;

    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * AddMessage constructor.
     * @param string $messageKey
     * @param CatalogueId $catalogueId
     */
    public function __construct($messageKey, CatalogueId $catalogueId)
    {
        $this->messageKey = $messageKey;
        $this->catalogueId = $catalogueId;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['message_key', 'catalogue_id']);
        $props = $resolver->resolve($commandProps);

        return new self(
            (string)$props['message_key'],
            new CatalogueId((string)$props['catalogue_id'])
        );
    }
}
