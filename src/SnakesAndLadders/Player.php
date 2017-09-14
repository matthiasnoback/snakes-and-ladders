<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class Player
{
    /**
     * @var int
     */
    private $index;

    public function __construct(int $index)
    {
        $this->index = $index;
    }

    public function index(): int
    {
        return $this->index;
    }
}
