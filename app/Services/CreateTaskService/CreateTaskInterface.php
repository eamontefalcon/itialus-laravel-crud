<?php

namespace App\Services\CreateTaskService;

interface CreateTaskInterface
{
    public function getTitle(): string;

    public function getDescription(): ?string;

    public function getStatus(): string;

    public function getUserId(): string;
}
