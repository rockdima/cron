<?php

namespace App\Repositories\Task;

use App\Entities\Task;
use Exception;

/**
 * Add, delete Tasts to file with json format
 */

class TaskRepositoryFile implements TaskRepositoryInterface {

    public function __construct(private string $filepath) {
    }

    /**
     * Add a task into json
     * 
     * @param Task $task current task instance
     */
    public function add(Task $task) {
        $tasks = $this->getAllTasks();
        $tasks[$task->id()] = [
            'executeAt' =>  $task->executeAt()->format('Y/m/d H:i:00'),
            'message'   =>  $task->message()
        ];

        $this->save($tasks);
    }

    /**
     * Get all tasks
     * 
     * @return array
     */
    public function getAllTasks(): array {
        if(!file_exists($this->filepath))
            throw new Exception("Tasks file does not exist");

        return json_decode(file_get_contents($this->filepath), true)??[];
    }

    /**
     * Get tasks by timestamp
     * 
     * @param Datetime $datetime
     * @return array
     */
    public function findTasks(\DateTime $datetime): array {
        $tasks = $this->getAllTasks();
        return array_filter($tasks, fn($task) => $task['executeAt'] == $datetime->format('Y/m/d H:i:00'));
    }

    /**
     * Delete task from json
     * 
     * @param string $taskId
     */
    public function delete(string $taskId) {
        $tasks = $this->getAllTasks();
        unset($tasks[$taskId]);
        $this->save($tasks);
    }

    /**
     * Save updated list
     * 
     * @param array $tasks
     */
    private function save(array $tasks) {
        file_put_contents($this->filepath, json_encode($tasks, JSON_PRETTY_PRINT));
    } 
}