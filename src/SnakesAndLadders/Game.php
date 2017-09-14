<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class Game
{
    // TODO tease out the concept of a "Board"

    const LAST_SQUARE = 100;

    private $currentSquare = [];

    private const FIRST_SQUARE = 1;

    private $snakes = [];
    private $ladders = [];

    public static function start(): Game
    {
        return new self();
    }

    public function placeOnBoard(Token $token): void
    {
        // TODO prevent double placing

        $this->currentSquare[spl_object_hash($token)] = self::FIRST_SQUARE;
    }

    public function currentSquareOfToken($token): int
    {
        // TODO prevent requests for unknown tokens

        return $this->currentSquare[spl_object_hash($token)];
    }

    public function move(Token $token, Roll $roll): void
    {
        $targetSquare = $this->currentSquareOfToken($token) + $roll->numberOfEyes();

        if ($targetSquare > self::LAST_SQUARE) {
            // TODO cover this code with a unit test
            return;
        }

        $this->setNewSquare($token, $targetSquare);

        if (isset($this->snakes[$this->currentSquareOfToken($token)])) {
            $this->setNewSquare($token, $this->snakes[$this->currentSquareOfToken($token)]);
        }

        if (isset($this->ladders[$this->currentSquareOfToken($token)])) {
            $this->setNewSquare($token, $this->ladders[$this->currentSquareOfToken($token)]);
        }
    }

    public function wasWonBy(Token $token): bool
    {
        return $this->currentSquareOfToken($token) === self::LAST_SQUARE;
    }

    public function addSnake(int $from, int $to): void
    {
        // TODO move snake initialization to constructor
        // TODO prevent snakes going forward
        // TODO prevent overwriting existing snakes or ladders
        $this->snakes[$from] = $to;
    }

    private function setNewSquare(Token $token, int $square): void
    {
        $this->currentSquare[spl_object_hash($token)] = $square;
    }

    public function addLadder(int $from, int $to): void
    {
        // TODO move ladders initialization to constructor
        // TODO prevent ladders going backward
        // TODO prevent overwriting existing snakes or ladders
        $this->ladders[$from] = $to;
    }
}
