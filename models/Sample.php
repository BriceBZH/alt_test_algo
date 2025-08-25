<?php

class Sample {
    public function __construct(public string $id, public string $type, public string $priority, public int $analysisTime, public Datetime $arrivalTime, public string $patientId) {
        $this->id = $id;
        $this->type = $type;
        $this->priority = $priority;
        $this->analysisTime = $analysisTime;
        $this->arrivalTime = $arrivalTime;
        $this->patientId = $patientId;
    }

}