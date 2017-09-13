<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class Game
{
    const LAST_SQUARE = 100;

    private $currentSquare = [];

    private const FIRST_SQUARE = 1;

    private $snakes = [];

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

        if ($targetSquare > 100) {
            return;
        }

        $this->setNewSquare($token, $targetSquare);

        if (isset($this->snakes[$this->currentSquareOfToken($token)])) {
            $this->setNewSquare($token, $this->snakes[$this->currentSquareOfToken($token)]);
        }
    }

    public function wasWonBy(Token $token): bool
    {
        return $this->currentSquareOfToken($token) === self::LAST_SQUARE;
    }

    public function addSnake(int $from, int $to): void
    {
        // TODO move snake initialization to constructor
        $this->snakes[$from] = $to;
    }

    private function setNewSquare(Token $token, int $square): void
    {
        $this->currentSquare[spl_object_hash($token)] = $square;
    }
}
