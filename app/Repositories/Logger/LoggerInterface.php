<?php

namespace App\Repositories\Logger;

interface LoggerInterface {
    public function log(string $msg);
}