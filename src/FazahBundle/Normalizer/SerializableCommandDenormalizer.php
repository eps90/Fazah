<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Normalizer;

use Eps\Fazah\Core\UseCase\Command\SerializableCommand;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SerializableCommandDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return call_user_func($class . '::fromArray', $data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return is_subclass_of($type, SerializableCommand::class);
    }
}
