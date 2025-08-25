<?php

class Equipment {

    public function __construct(public string $id, private string $name, private string $type, private string $availableFrom) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->availableFrom = $availableFrom;
    }

}