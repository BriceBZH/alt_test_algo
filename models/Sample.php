<?php

class Sample {
    public function __construct(public string $id, private string $type, private string $priority, private int $analysisTime, private datetime $arrivalTime, private string $patientId) {
        $this->id = $id;
        $this->type = $type;
        $this->priority = $priority;
        $this->analysisTime = $analysisTime;
        $this->arrivalTime = $arrivalTime;
        $this->patientId = $patientId;
    }
    
}