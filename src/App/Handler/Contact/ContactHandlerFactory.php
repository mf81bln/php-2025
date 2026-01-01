<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Model\ContactTable;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ContactHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): object
    {
        $template = $container->get(TemplateRendererInterface::class);
        $contactTable = $container->get(ContactTable::class);
        $urlHelper = $container->get(UrlHelper::class);

        return match ($requestedName) {
            ListHandler::class => new ListHandler($template, $contactTable),
            CreateHandler::class => new CreateHandler($template, $contactTable, $urlHelper),
            EditHandler::class => new EditHandler($template, $contactTable, $urlHelper),
            DeleteHandler::class => new DeleteHandler($template, $contactTable, $urlHelper),
        };
    }
}
