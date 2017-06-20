<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\EventListener\CommandExtractor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class SerializerCommandExtractor implements CommandExtractorInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function extractFromRequest(Request $request, string $cmdClassName)
    {
        return $this->serializer->deserialize($request->getContent(), $cmdClassName, $request->getRequestFormat());
    }
}
