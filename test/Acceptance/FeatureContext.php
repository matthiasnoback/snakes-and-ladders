<?php

namespace Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use SnakesAndLadders\Game;
use SnakesAndLadders\Roll;
use SnakesAndLadders\Token;
use Webmozart\Assert\Assert;

class FeatureContext implements Context
{
    /**
     * @var Game|null
     */
    private $game;

    /**
     * @var Token|null
     */
    private $token;

    /**
     * @var Roll|null
     */
    private $roll;

    /**
     * @Given the game is started
     */
    public function theGameIsStarted()
    {
        $this->game = Game::start();
    }

    /**
     * @When the token is placed on the board
     */
    public function theTokenIsPlacedOnTheBoard()
    {
        $this->token = new Token();
        $this->game->placeOnBoard($this->token);
    }

    /**
     * @Then the token is on square :square
     */
    public function theTokenIsOnSquare($square)
    {
        Assert::same((int)$square, $this->game->currentSquareOfToken($this->token));
    }

    /**
     * @When the token is moved :numberOfSpaces spaces
     * @When then it is moved :numberOfSpaces spaces
     */
    public function theTokenIsMovedSpaces($numberOfSpaces)
    {
        $this->game->move($this->token, Roll::withNumberOfEyes($numberOfSpaces));
    }

    /**
     * @Given the token has arrived on square 97
     */
    public function theTokenHasArrivedOnSquare97()
    {
        for ($i = 1; $i <= 16; $i++) {
            // 16 * 6 = square 97
            $this->game->move($this->token, Roll::withNumberOfEyes(6));
        }

        Assert::same(97, $this->game->currentSquareOfToken($this->token));
    }

    /**
     * @Then the player has won the game
     */
    public function thePlayerHasWonTheGame()
    {
        Assert::true($this->game->wasWonBy($this->token));
    }

    /**
     * @Then the player has not won the game
     */
    public function thePlayerHasNotWonTheGame()
    {
        Assert::false($this->game->wasWonBy($this->token));
    }

    /**
     * @When the player rolls a die
     */
    public function thePlayerRollsADie()
    {
        $this->roll = Roll::roll();
    }

    /**
     * @Given /^the player rolls a (\d+)$/
     */
    public function thePlayerRollsA($numberOfEyes)
    {
        $this->roll = Roll::withNumberOfEyes($numberOfEyes);
    }

    /**
     * @When they move their token
     */
    public function theyMoveTheirToken()
    {
        $this->game->move($this->token, $this->roll);
    }

    /**
     * @Then the token should move :expected spaces
     */
    public function theTokenShouldMoveSpaces($expected)
    {
        $movedSpaces = $this->game->currentSquareOfToken($this->token) - 1;
        Assert::same((int)$expected, $movedSpaces);
    }

    /**
     * @Then the result should be between :min-:max inclusive
     */
    public function theResultShouldBeBetweenInclusive($min, $max)
    {
        Assert::range($this->roll->numberOfEyes(), $min, $max);
    }
}
