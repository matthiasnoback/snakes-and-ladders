<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class Game
{
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

    public function move(Token $token, int $numberOfSpaces): void
    {
        $this->currentSquare[spl_object_hash($token)] += $numberOfSpaces;
    }
}
