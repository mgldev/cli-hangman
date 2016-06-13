<?php

namespace Hangman;

class Hangman implements \Iterator {

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $map;

    /**
     * @var string
     */
    protected $canvas;

    public function __construct() {

        $this->reset();
        $this->initialiseMap();
    }

    public function reset()
    {

        $this->canvas = "
            
            
            
            
            
";
    }

    public function current()
    {

        return $this->canvas;
    }

    public function next()
    {
        $this->position++;
        $parts = array_keys($this->map);
        $part = $parts[$this->position];
        $this->add($part);
        return $this;
    }

    public function valid()
    {
        return $this->position < count($this->map) - 1;
    }

    public function key() {

        $parts = array_keys($this->map);
        return $parts[$this->position];
    }

    public function rewind()
    {
        $this->reset();
    }

    public function add($part) {

        $positions = $this->map[$part];
        foreach ($positions as $position => $character) {
            $this->canvas[$position] = $character;
        }

        return $this;
    }

    protected function initialiseMap() {

        $this->map = [
            'initial' => [],
            'post' => [
                24 => '\\',
                25 => '|',
                38 => '|',
                51 => '|',
                64 => '|'
            ],
            'rope' => call_user_func(function() {
                $map = [];
                foreach (range(3, 12) as $index) {
                    $map[$index] = '-';
                }
                $map[16] = '|';
                return $map;
            }),
            'head' => [29 => 'O'],
            'body' => [42 => '|'],
            'leftArm' => [41 => '/'],
            'rightArm' => [43 => '\\'],
            'leftLeg' => [54 => '/'],
            'rightLeg' => [56 => '\\'],
        ];
    }

    public function __toString() {

        return $this->canvas;
    }
}
