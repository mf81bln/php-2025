<?php

declare(strict_types=1);

namespace App\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class ContactTable
{
    public function __construct(
        private TableGatewayInterface $tableGateway
    ) {}

    public function fetchAll(): iterable
    {
        return $this->tableGateway->select();
    }

    public function getContact(int $id): Contact
    {
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if (!$row) {
            throw new RuntimeException(sprintf('Contact with id %d not found', $id));
        }

        return $row;
    }

    public function saveContact(Contact $contact): void
    {
        $data = [
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'notes' => $contact->notes,
        ];

        $id = $contact->id;

        if ($id === null || $id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteContact(int $id): void
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
