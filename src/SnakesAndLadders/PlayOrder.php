<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class PlayOrder
{
    /**
     * @var array
     */
    private $playOrder;

    public function __construct(array $playOrder)
    {
        $this->playOrder = $playOrder;
    }
}
