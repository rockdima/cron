<?php

namespace App\utils;

/**
 *  Parses date, time
 */

trait ParseTimeTrait {

    /**
     * Changes the offset to \Datetime format
     * 
     * @param string $offset given offset
     * @return string
     */
    public function setOffset(string $offset): string {
        
        $units = [
            'm' => 'minutes',
            'h' => 'hours',
            'd' => 'days',
        ];

        if (!preg_match('/^([+-])(\d+)(['.implode('', array_keys($units)).'])$/', $offset, $matches)) {
            throw new \Exception('Incorrect offset format');
        }

        return $matches[1].$matches[2].' '.$units[$matches[3]];
    }
}
