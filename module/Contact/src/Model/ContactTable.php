<?php

declare(strict_types=1);

namespace Contact\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class ContactTable
{
    private TableGatewayInterface $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

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

        if (!$this->getContact($id)) {
            throw new RuntimeException(sprintf('Cannot update contact with id %d; does not exist', $id));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteContact(int $id): void
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}
