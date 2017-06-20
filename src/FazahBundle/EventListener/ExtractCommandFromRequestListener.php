<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\EventListener;

use Eps\Fazah\FazahBundle\EventListener\CommandExtractor\CommandExtractorInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

final class ExtractCommandFromRequestListener
{
    public const API_RESPONDER_CONTROLLER = 'fazah.action.api_responder';
    private const CMD_CLASS_PARAM = '_command_class';
    private const CMD_PARAM = '_command';
    private const CONTROLLER_PARAM = '_controller';

    /**
     * @var CommandExtractorInterface
     */
    private $extractor;

    /**
     * ExtractCommandFromRequestListener constructor.
     * @param CommandExtractorInterface $extractor
     */
    public function __construct(CommandExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        $commandClass = $request->attributes->get(self::CMD_CLASS_PARAM);
        if ($commandClass === null) {
            return;
        }

        $command = $this->extractor->extractFromRequest($request, $commandClass);

        $request->attributes->set(self::CMD_PARAM, $command);
        $request->attributes->set(self::CONTROLLER_PARAM, self::API_RESPONDER_CONTROLLER);
        $request->attributes->remove(self::CMD_CLASS_PARAM);
    }
}
