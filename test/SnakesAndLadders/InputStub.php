<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use Webmozart\Assert\Assert;

final class InputStub implements Input
{
    private $rolls;

    public function __construct(array $rolls)
    {
        Assert::allInteger($rolls);
        $this->rolls = $rolls;
    }

    public function rollDie(int $player): Roll
    {
        $nextRoll = array_shift($this->rolls);

        return Roll::withNumberOfEyes($nextRoll);
    }
}
