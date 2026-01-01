<?php

declare(strict_types=1);

namespace App;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                // Database
                AdapterInterface::class => function ($container) {
                    $config = $container->get('config')['db'] ?? [];
                    return new Adapter($config);
                },
                // Contact Handlers
                Model\ContactTable::class => Model\ContactTableFactory::class,
                Handler\Contact\ListHandler::class => Handler\Contact\ContactHandlerFactory::class,
                Handler\Contact\CreateHandler::class => Handler\Contact\ContactHandlerFactory::class,
                Handler\Contact\EditHandler::class => Handler\Contact\ContactHandlerFactory::class,
                Handler\Contact\DeleteHandler::class => Handler\Contact\ContactHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
