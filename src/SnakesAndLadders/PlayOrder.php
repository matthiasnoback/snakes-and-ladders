<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use Webmozart\Assert\Assert;

final class PlayOrder
{
    /**
     * @var array
     */
    private $playOrder;

    public function __construct(array $playOrder)
    {
        $this->playOrder = array_values($playOrder);
    }

    public function firstPlayer(): int
    {
        return $this->playOrder[0];
    }

    public function nextPlayer(int $player): int
    {
        $key = array_search($player, $this->playOrder, true);
        Assert::integer($key);

        if (isset($this->playOrder[$key + 1])) {
            return $this->playOrder[$key + 1];
        }

        return $this->playOrder[0];
    }
}
