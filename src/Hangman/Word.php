<?php

namespace Hangman;

class Word {

    protected $word;

    protected $correctCharacters = [];

    protected $incorrectCharacters = [];

    protected $guessedLength = 0;

    public function start($word) {

        $this->word = $word;
        return $this;
    }

    public function reveal() {

        return $this->word;
    }

    public function completed() {

        return $this->guessedLength == strlen($this->word);
    }

    public function guess($character) {

        $matched = false;

        foreach (str_split($this->word) as $index => $wordCharacter) {
            if ($character == $wordCharacter) {
                if (!in_array($character, $this->correctCharacters)) {
                    $this->correctCharacters[] = $character;
                }
                $matched = true;
                $this->guessedLength++;
            }
        }

        if (!$matched && !in_array($character, $this->incorrectCharacters)) {
            $this->incorrectCharacters[] = $character;
        }

        return $matched;
    }

    public function getOutput() {

        $output = '';

        foreach (str_split($this->word) as $char) {
            $char = in_array($char, $this->correctCharacters) ? ' ' . $char . ' ' : ' _ ';
            $output .= $char;
        }

        $incorrectCharsDisplay = 'Incorrect character used: [' . implode(', ', $this->incorrectCharacters) . ']';

        $output .= "\n" . $incorrectCharsDisplay;
        
        return $output;
    }

    public function __toString() {

        return $this->getOutput();
    }
}
