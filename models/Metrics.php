<?php

class Metrics {
    
    public function __construct(public int $totalTime = 0, public float $efficiency = 0, public int $conflicts = 0) {
        $this->totalTime = $totalTime;
        $this->efficiency = $efficiency;
        $this->conflicts = $conflicts;
    }

}