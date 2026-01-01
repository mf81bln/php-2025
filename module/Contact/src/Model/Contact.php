<?php

declare(strict_types=1);

namespace Contact\Model;

use DomainException;

class Contact
{
    public ?int $id = null;
    public string $name = '';
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $notes = null;
    public ?string $created_at = null;

    public function exchangeArray(array $data): void
    {
        $this->id = isset($data['id']) ? (int) $data['id'] : null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->notes = $data['notes'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}
