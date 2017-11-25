<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RemoveCatalogue implements DeserializableCommandInterface
{
    /**
     * @var CatalogueId
     */
    private $catalogueId;
    
    public function __construct(CatalogueId $catalogueId)
    {
        $this->catalogueId = $catalogueId;
    }
    
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }
    
    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('catalogue_id');
        $resolver->resolve($commandProps);
        
        return new self(new CatalogueId($commandProps['catalogue_id']));
    }
}
