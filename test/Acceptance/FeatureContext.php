<?php

namespace Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use SnakesAndLadders\DeterminePlayOrder;
use SnakesAndLadders\Game;
use SnakesAndLadders\GameTestHelper;
use SnakesAndLadders\InputStub;
use SnakesAndLadders\PlayOrder;
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
     * @var Token|null
     */
    private $token;

    /**
     * @var Roll|null
     */
    private $roll;

    /**
     * @var int
     */
    private $numberOfPlayers = 1;

    /**
     * @var PlayOrder|null
     */
    private $playOrder;

    /**
     * @var int|null
     */
    private $currentPlayer;

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

    /**
     * @Given there is a snake connecting squares :to and :from
     */
    public function thereIsASnakeConnectingSquaresAnd($to, $from)
    {
        $this->game->addSnake($from, $to);
    }

    /**
     * @When the token lands on square :square
     */
    public function theTokenLandsOnSquare($square)
    {
        $helper = new GameTestHelper($this->game);
        $helper->fastForwardToSquare($this->token, $square);
    }

    /**
     * @Given there is a ladder connecting squares :from and :to
     */
    public function thereIsALadderConnectingSquaresAnd($from, $to)
    {
        $this->game->addLadder((int)$from, (int)$to);
    }

    /**
     * @Given :numberOfPlayers players are rolling to determine play order
     */
    public function playersAreRollingToDeterminePlayOrder($numberOfPlayers)
    {
        $this->numberOfPlayers = (int)$numberOfPlayers;
    }

    /**
     * @When Player 1 rolls higher than Player 2
     */
    public function player1RollsHigherThanPlayer2()
    {
        $numberOfPlayers = 2;
        $input = new InputStub($numberOfPlayers, [6, 4]);
        $this->playOrder = (new DeterminePlayOrder($input))->determine();
    }

    /**
     * @When Player 2 rolls higher than Player 1
     */
    public function player2RollsHigherThanPlayer1()
    {
        $numberOfPlayers = 2;
        $input = new InputStub($numberOfPlayers, [4, 6]);
        $this->playOrder = (new DeterminePlayOrder($input))->determine();
    }

    /**
     * @Then Player 1 rolls first
     */
    public function player1RollsFirst()
    {
        Assert::eq(new PlayOrder([0, 1]), $this->playOrder);
    }

    /**
     * @Then Player 2 rolls first
     */
    public function player2RollsFirst()
    {
        Assert::eq(new PlayOrder([1, 0]), $this->playOrder);
    }

    /**
     * @When Player 1 rolls the same as Player 2
     */
    public function playerRollsTheSameAsPlayer()
    {
        $numberOfPlayers = 2;
        $input = new InputStub($numberOfPlayers, [4, 4, 6, 5]);
        $this->playOrder = (new DeterminePlayOrder($input))->determine();
    }

    /**
     * @Then the players must roll again
     */
    public function thePlayersMustRollAgain()
    {
        // nothing to verify here
    }

    /**
     * @Given there are :number players
     */
    public function thereArePlayers($number)
    {
        $this->numberOfPlayers = $number;
        $this->playOrder = (new DeterminePlayOrder(new InputStub($number, [6, 4])))->determine();
        $this->currentPlayer = $this->playOrder->firstPlayer();
    }

    /**
     * @When Player :arg1 has moved their token
     */
    public function playerHasMovedTheirToken()
    {
        $this->currentPlayer = $this->playOrder->nextPlayer($this->currentPlayer);
    }

    /**
     * @Then it is Player :expectedNextPlayer's turn
     */
    public function itIsPlayerSTurn($expectedNextPlayer)
    {
        Assert::eq($this->currentPlayer, (int)$expectedNextPlayer - 1);
    }
}
