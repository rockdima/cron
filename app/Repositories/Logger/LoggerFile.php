<?php

namespace App\Repositories\Logger;

/**
 * Save logs into a file
 */

class LoggerFile implements LoggerInterface {
    public function __construct(private string $filepath) {
    }

    /**
     * Append log message
     * 
     * @param string $msg log text
     */
    public function log(string $msg){
        $timestamp = (new \DateTime())->format('Y-m-d H:i:s');
        file_put_contents($this->filepath, "[$timestamp] $msg\n", FILE_APPEND);
    }
}