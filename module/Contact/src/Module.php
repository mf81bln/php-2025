<?php

declare(strict_types=1);

namespace Contact;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                Model\ContactTable::class => function ($container) {
                    $tableGateway = $container->get(Model\ContactTableGateway::class);
                    return new Model\ContactTable($tableGateway);
                },
                Model\ContactTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Contact());
                    return new TableGateway('contacts', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                Controller\ContactController::class => function ($container) {
                    return new Controller\ContactController(
                        $container->get(Model\ContactTable::class)
                    );
                },
            ],
        ];
    }
}
