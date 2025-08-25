<?php

class Equipment {

    public function __construct(public string $id, public ?string $name, public string $type, public string $availableFrom) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->availableFrom = $availableFrom;
    }

}