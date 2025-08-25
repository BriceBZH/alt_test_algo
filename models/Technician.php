<?php

class Technician {

    public function __construct(public string $id, public ?string $name, public string $speciality, public Datetime $startTime, public DateTime $endTime, public ?DateTime $availableFrom) {
        $this->id = $id;
        $this->name = $name;
        $this->speciality = $speciality;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->availableFrom = $startTime;
    }

}