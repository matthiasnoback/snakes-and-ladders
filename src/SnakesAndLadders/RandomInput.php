<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class RandomInput implements Input
{
    public function rollDie(int $player): Roll
    {
        return Roll::roll();
    }

    public function numberOfPlayers(): int
    {
        return random_int(1, 4);
    }
}
