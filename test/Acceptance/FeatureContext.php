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
        $this->game->move($this->token, Roll::fromInt($numberOfSpaces));
    }

    /**
     * @Given the token has arrived on square 97
     */
    public function theTokenHasArrivedOnSquare97()
    {
        for ($i = 1; $i <= 16; $i++) {
            // 16 * 6 = square 97
            $this->game->move($this->token, Roll::fromInt(6));
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
}
