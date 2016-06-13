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

        if (!(is_string($character) && strlen($character) == 1)) {
            throw new \InvalidArgumentException(
                'Character must be a single character'
            );
        }

        $matched = false;

        if (in_array($character, $this->correctCharacters)) {
            throw new \LogicException('Already guessed correctly guessed this one!');
        }

        if (in_array($character, $this->incorrectCharacters)) {
            throw new \LogicException('Already guessed incorrectly guessed this one!');
        }

        foreach (str_split($this->word) as $index => $wordCharacter) {
            if ($character == $wordCharacter) {
                $this->correctCharacters[] = $character;
                $this->guessedLength++;
                $matched = true;
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
