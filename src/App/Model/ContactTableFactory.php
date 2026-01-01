<?php

declare(strict_types=1);

namespace App\Model;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Psr\Container\ContainerInterface;

class ContactTableFactory
{
    public function __invoke(ContainerInterface $container): ContactTable
    {
        $dbAdapter = $container->get(AdapterInterface::class);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Contact());

        $tableGateway = new TableGateway('contacts', $dbAdapter, null, $resultSetPrototype);

        return new ContactTable($tableGateway);
    }
}
