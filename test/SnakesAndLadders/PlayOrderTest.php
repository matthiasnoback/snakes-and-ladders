<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class PlayOrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_knows_which_player_is_first()
    {
        $playOrder = new PlayOrder([1, 0, 2]);
        $this->assertEquals(1, $playOrder->firstPlayer());
    }

    /**
     * @test
     */
    public function it_knows_which_player_is_next()
    {
        $playOrder = new PlayOrder([1, 0, 2]);

        $this->assertEquals(0, $playOrder->nextPlayer(1));
    }

    /**
     * @test
     */
    public function it_will_keep_rotating_over_the_array_of_players()
    {
        $players = [1, 0, 2];
        $playOrder = new PlayOrder($players);

        $currentPlayer = $playOrder->firstPlayer();

        for ($i = 1; $i < 1000; $i++) {
            $nextPlayer = $playOrder->nextPlayer($currentPlayer);
            $this->assertEquals($nextPlayer, $players[$i % count($players)]);
            $currentPlayer = $nextPlayer;
        }
    }
}
