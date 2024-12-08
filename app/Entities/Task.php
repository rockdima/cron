<?php

namespace App\Entities;

class Task {

    private string $id;

    public function __construct(private \DateTime $executeAt, private string $message)
    {
        $this->id = uniqid();
    }

    public function id() {
        return $this->id;
    }

    public function executeAt() {
        return $this->executeAt;
    }

    public function message() {
        return $this->message;
    }
}