<?php

namespace App\Repositories\Task;

use App\Entities\Task;

interface TaskRepositoryInterface {
    public function add(Task $task);
    public function getAllTasks(): array;
    public function findTasks(\DateTime $dateTime): array;
    public function delete(string $taskId);
}