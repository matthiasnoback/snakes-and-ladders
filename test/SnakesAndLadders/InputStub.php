<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use Webmozart\Assert\Assert;

final class InputStub implements Input
{
    /**
     * @var int
     */
    private $numberOfPlayers;

    /**
     * @var array
     */
    private $rolls;

    public function __construct(int $numberOfPlayers, array $rolls)
    {
        $this->numberOfPlayers = $numberOfPlayers;

        Assert::allInteger($rolls);
        $this->rolls = $rolls;
    }

    public function rollDie(int $player): Roll
    {
        $nextRoll = array_shift($this->rolls);

        return Roll::withNumberOfEyes($nextRoll);
    }

    public function numberOfPlayers(): int
    {
        return $this->numberOfPlayers;
    }
}
