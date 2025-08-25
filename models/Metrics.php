<?php

class Metrics {
    
    public function __construct(public int $totalTime = 0, private float $efficiency = 0, private int $conflicts = 0) {
        $this->totalTime = $totalTime;
        $this->efficiency = $efficiency;
        $this->conflicts = $conflicts;
    }

}