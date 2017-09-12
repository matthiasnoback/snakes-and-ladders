<?php

namespace Acceptance;

use Behat\Behat\Context\Context;
use SnakesAndLadders\Game;
use SnakesAndLadders\Token;
use Webmozart\Assert\Assert;

class FeatureContext implements Context
{
    /**
     * @var Game
     */
    private $game;

    /**
     * @var Token
     */
    private $token;

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
        $this->game->move($this->token, (int)$numberOfSpaces);
    }
}
