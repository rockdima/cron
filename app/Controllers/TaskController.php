<?php

namespace App\Controllers;

use App\Services\TaskService;

class TaskController {

    public function __construct(private TaskService $taskService) {
    }

    /**
     * Add todo tasks to a list
     * 
     * @param string $offset time offset
     * @param string $message the task
     */
    public function add(string $offset, string $message) {
        $this->taskService->createTask($offset, $message);
    }

    /**
     * Execute tasks script
     */
    public function execute() {
        $this->taskService->runTasks();
    }

}