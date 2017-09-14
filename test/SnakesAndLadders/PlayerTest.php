<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class PlayerTest extends TestCase
{
    /**
     * @test
     */
    public function a_player_has_an_index(): void
    {
        $index = 0;
        $player = new Player($index);
        $this->assertEquals($index, $player->index());
    }
}
