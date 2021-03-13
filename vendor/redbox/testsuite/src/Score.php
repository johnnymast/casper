<?php

/**
 * Score.php
 *
 * This file will maintain the Test scores.
 *
 * PHP version 7.4
 *
 * @category Core
 * @package  RedboxTestSuite
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-testsuite
 * @since    1.0
 */

namespace Redbox\Testsuite;

/**
 * Class Score
 *
 * @package Redbox\Testsuite
 */
class Score
{
    /**
     * The current score.
     *
     * @var mixed
     */
    protected $score = 0;
    
    /**
     * The number of increments this score went over.
     *
     * @var int
     */
    private int $increments = 0;
    
    /**
     * Reference to the test the score belongs to.
     *
     * @var TestCase
     */
    private TestCase $test;
    
    /**
     * Array containing score information.
     *
     * @var array
     */
    private array $results = [];
    
    /**
     * Score constructor.
     *
     * @param TestCase $test The Test this score belongs to.
     */
    public function __construct(TestCase $test)
    {
        $this->test = $test;
        
        $this->reset();
    }
    
    /**
     * Reset the values to default.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->score = $this->minScore();
        $this->increments = 0;
        $this->results = [];
    }
    
    /**
     * Increment the score by $score amount.
     *
     * @param mixed  $value      The value to increment the score with (float/double or int).
     * @param string $motivation A motivation for this score.
     * @param string $answer     Option to provide the given answer.
     *
     * @return void
     */
    public function increment($value, $motivation = '', $answer = ''): void
    {
        $this->score += $value;
        $this->results[$this->increments] = [
          'score' => $value,
          'increment' => $this->increments,
          'motivation' => $motivation,
          'answer' => $answer,
        ];
        $this->increments++;
    }
    
    /**
     * Return the percentage the score is
     * compared to the maximal score.
     *
     * @return float|int
     */
    public function percentage()
    {
        return round(($this->getScore() / $this->maxScore()) * 100, 2);
    }
    
    /**
     * Calculate the average for this
     * score.
     *
     * @return float|int
     */
    public function average()
    {
        return ($this->increments > 0) ? ($this->score / $this->increments) : false;
    }
    
    /**
     * Return the number of increments the
     * score went over.
     *
     * @return int
     */
    public function getIncrements(): int
    {
        return $this->increments;
    }
    
    /**
     * Return information about the scores.
     *
     * @return array
     */
    public function getScoreInfo(): array
    {
        return $this->results;
    }
    
    /**
     * Return the minimal score.
     *
     * @return mixed
     */
    public function minScore()
    {
        return $this->test->minScore();
    }
    
    /**
     * Return the maximal score.
     *
     * @return mixed
     */
    public function maxScore()
    {
        return $this->test->maxScore();
    }
    
    /**
     * Return the current score.
     *
     * @return mixed
     */
    public function getScore(): int
    {
        return $this->score;
    }
    
    /**
     * Return the parent class instance.
     *
     * @return TestCase
     */
    public function getTest(): TestCase
    {
        return $this->test;
    }
    
    /**
     * Set to score to a given value.
     *
     * @param mixed $value The value to set as the score.
     *
     * @return void
     */
    public function setScore($value): void
    {
        $this->score = $value;
    }
}
