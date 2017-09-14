<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class RandomInput implements Input
{
    public function rollDie(int $player): Roll
    {
        return Roll::roll();
    }
}
