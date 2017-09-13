<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class Game
{
    const LAST_SQUARE = 100;
    private $currentSquare = [];

    private const FIRST_SQUARE = 1;

    public static function start(): Game
    {
        return new self();
    }

    public function placeOnBoard(Token $token): void
    {
        $this->currentSquare[spl_object_hash($token)] = self::FIRST_SQUARE;
    }

    public function currentSquareOfToken($token): int
    {
        return $this->currentSquare[spl_object_hash($token)];
    }

    public function move(Token $token, Roll $roll): void
    {
        if ($this->currentSquareOfToken($token) + $roll->numberOfEyes() > 100) {
            return;
        }

        $this->currentSquare[spl_object_hash($token)] += $roll->numberOfEyes();
    }

    public function wasWonBy(Token $token): bool
    {
        return $this->currentSquareOfToken($token) === self::LAST_SQUARE;
    }
}
