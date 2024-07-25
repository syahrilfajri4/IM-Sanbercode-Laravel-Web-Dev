<?php

class Animal
{
    public $name;
    public $legs;
    public $cold_bloodes;

    public function __construct($name)
    {
        $this->name = $name;
        $this->legs = 4;
        $this->cold_bloodes = "no";
    }
}
