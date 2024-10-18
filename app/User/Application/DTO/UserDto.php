<?php

namespace App\User\Application\DTO;

readonly class UserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password = ''
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
