<?php

/**
 * Results.php
 *
 * This file demonstrate how the getAnswers function can help you
 * interpret the answers given bij the test.
 *
 * PHP version 7.4
 *
 * @category Examples
 * @package  RedboxTestSuite
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-testsuite
 * @since    1.0
 */

require __DIR__.'/../vendor/autoload.php';

use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\TestCase;
use Redbox\Testsuite\TestSuite;

$questions = [
  [
    'text' => '5+5 =',
    'answer' => 10,
    'score_good' => 1,
    'score_wrong' => 0,
    'answer_wrong' => 'You are Wrong 5+5=10',
    'answer_correct' => 'You are right 5+5=10',
  ],
  [
    'text' => 'Is this script running on php?',
    'answer' => 'yes',
    'score_good' => 1,
    'score_wrong' => 0,
    'answer_wrong' => 'You are wrong this script is running on php.',
    'answer_correct' => 'You are right this script is created in php.',
  ],
];

/**
 * Create a table for cli output.
 *
 * @param array $answers The answers given in the test.
 *
 * @return string
 */
function formatOutput(array $answers): string
{
    $table_header = [];
    $table_rows = [];
    $longestLine = 0;
    
    foreach ($answers as $answer) {
        $row = sprintf(
            '| %s | %s | %s |',
            str_pad($answer['increment'], 10, " "),
            str_pad($answer['answer'], 10, " "),
            str_pad($answer['motivation'], 50, " "),
            str_pad($answer['score'], 5, " "),
        );
        
        if (strlen($row) > $longestLine) {
            $longestLine = strlen($row);
        }
        
        $table_rows[] = $row;
    }
    
    $table_header [] = str_repeat('_', $longestLine);
    $table_header[] = sprintf(
        '| %s | %s | %s |',
        str_pad('Increment', 10, " "),
        str_pad('Answer', 10, " "),
        str_pad('Motivation', 50, " "),
        str_pad('Score', 5, " ")
    );
    
    $table_header [] = str_repeat('-', $longestLine);
    $table_footer = [str_repeat('-', $longestLine), "\n"];
    
    $table = [
      ...$table_header,
      ...$table_rows,
      ...$table_footer,
    ];
    
    return implode("\n", $table);
}

/**
 * Class RealTest
 */
class RealTest extends TestCase
{

    /**
     * Tell the TestCase what the
     * min reachable score is.
     *
     * @var int
     */
    protected int $minscore = 0;

    /**
     * Tell the TestCase what the
     * max reachable score is.
     *
     * @var int
     */
    protected int $maxscore = 2;
    
    /**
     * Read commandline input.
     *
     * @param string $prompt The prompt to display to the user.
     * @param string $answer The suggested answer.
     *
     * @return false|string
     */
    private function readline($prompt = '', $answer = ''): string
    {
        return readline($prompt.' ('.$answer.'): ');
    }
    
    /**
     * As the user the question and process the result.
     *
     * @param array $question Array containing infromation about this question.
     *
     * @return void
     */
    private function askQuestion($question): void
    {
        $text = $question['text'];
        $answer = $question['answer'];
        
        $input = $this->readline($text, $answer);
        
        if ($input == $answer) {
            $this->score->increment($question['score_good'], $question['answer_correct'], $input);
        } else {
            $this->score->increment($question['score_wrong'], $question['answer_wrong'], $input);
        }
    }
    
    /**
     * Entry point for the test to start running.
     *
     * @param ContainerInterface $container The storage container holding the questions.
     *
     * @return void
     */
    public function run(ContainerInterface $container)
    {
        $questions = $container->get('questions');
        foreach ($questions as $question) {
            $this->askQuestion($question);
        }
    }
}

$test = new RealTest();
$suite = new TestSuite();
$suite->getContainer()->set('questions', $questions);
$suite->attach($test)
    ->run();

$answers = current($suite->getAnswers());

echo formatOutput($answers);

echo "Total suite score: ".$suite->getScore()."\n";
echo "Percentage complete: ".$test->score->percentage()."%\n";
