<?php

namespace App\Services;

use App\Entities\Task;
use App\Repositories\Logger\LoggerInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use App\utils\ParseTimeTrait;

class TaskService {

    use ParseTimeTrait;

    public function __construct(private TaskRepositoryInterface $taskRepository, private LoggerInterface $logger) {
    }

    /**
     * Create new task
     * 
     * @param string $offset when to start
     * @param string $message the command
     */
    public function createTask(string $offset, string $message) {
        $offset = $this->setOffset($offset); // format the offset
        $execudeAt = (new \DateTime())->modify($offset); // create datetime with the offset
        $task = new Task($execudeAt, $message); //create task entity
        $this->taskRepository->add($task); // add to a list
    }

    /**
     * Run tasks for current datetime
     */
    public function runTasks() {
        $tasks = $this->taskRepository->findTasks(new \DateTime()); ///get the tasks

        foreach($tasks as $id => $task) {
            $this->logger->log("Task {$id} {$task['message']}"); // log
            $this->taskRepository->delete($id); // delete from a list
        }
    }
}