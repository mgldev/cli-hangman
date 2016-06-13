<?php

namespace Hangman;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GameCommand extends Command
{
    /**
     * @var Hangman
     */
    protected $hangman;

    /**
     * @var Word
     */
    protected $word;

    protected function configure()
    {
        $this
            ->setName('hangman:play')
            ->setDescription('Play hangman');

        $this->hangman = new Hangman();
        $this->word = new Word();
    }

    protected function getRandomWord() {

        $words = [];
        $content = file_get_contents(__DIR__ . '/words.txt', 'r');
        $lines = explode(PHP_EOL, $content);
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            if (count($parts) == 1 && !strstr($line, '-')) {
                $words[] = reset($parts);
            }
        }

        $index = mt_rand(0, count($words));
        $word = $words[$index];
        return $word;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->word->start($this->getRandomWord());

        $this->render($output);

        $won = false;

        while ($this->hangman->valid()) {

            $helper = $this->getHelper('question');
            $question = new Question('Guess character: ', null);
            $character = $helper->ask($input, $output, $question);
            $correct = $this->word->guess($character);

            if (!$correct) {
                $this->hangman->next();
            } else {
                if ($this->word->completed()) {
                    $this->render($output);
                    $won = true;
                    break;
                }
            }

            $this->render($output);
        }

        if ($won) {
            $output->writeln('<info>Congratulations! Winner ;)</info>');
        } else {
            $output->writeln(
                '<comment>You lose! The word was </comment> <info>"' . $this->word->reveal() . '"</info>'
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function render(OutputInterface $output) {

        $output->write(sprintf("\033\143"));
        $output->writeln($this->hangman->current());
        $output->writeln($this->word->getOutput());
        $output->writeln('');
    }
}



