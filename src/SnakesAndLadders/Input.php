<?php
declare(strict_types=1);

namespace SnakesAndLadders;

interface Input
{
    public function rollDie(int $player): Roll;
}
