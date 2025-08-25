<?php

class Technician {

    public function __construct(public string $id, public string $name, public string $speciality, public datetime $startTime, public datetime $endTime, public ?datetime $availableFrom) {
        $this->id = $id;
        $this->name = $name;
        $this->speciality = $speciality;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->availableFrom = $startTime;
    }

}