<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Serializer\SerializerInterface;

final class ExtractCommandFromRequestListener
{
    public const API_RESPONDER_CONTROLLER = 'fazah.action.api_responder';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        $commandClass = $request->attributes->get('_command_class');
        if ($commandClass === null) {
            return;
        }

        $format = $request->getRequestFormat();

        $command = $this->serializer->deserialize($request->getContent(), $commandClass, $format);

        $request->attributes->set('_command', $command);
        $request->attributes->set('_controller', self::API_RESPONDER_CONTROLLER);
    }
}
