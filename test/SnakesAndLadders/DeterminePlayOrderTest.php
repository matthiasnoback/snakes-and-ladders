<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class DeterminePlayOrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_determines_play_order_by_letting_the_player_who_rolls_highest_play_first(): void
    {
        $numberOfPlayers = 2;
        $rolls = [6, 1];
        $determinePlayOrder = new DeterminePlayOrder(new InputStub($numberOfPlayers, $rolls));

        $playOrder = $determinePlayOrder->determine();

        $this->assertEquals(new PlayOrder([0, 1]), $playOrder);
    }

    /**
     * @test
     */
    public function if_players_roll_the_same_eyes_the_process_starts_all_over(): void
    {
        $numberOfPlayers = 2;
        $rolls = [
            6,
            6,
            4,
            2,
        ];
        $determinePlayOrder = new DeterminePlayOrder(new InputStub($numberOfPlayers, $rolls));

        $playOrder = $determinePlayOrder->determine();

        $this->assertEquals(new PlayOrder([0, 1]), $playOrder);
    }

    /**
     * @test
     */
    public function it_only_asks_remaining_players_to_roll_again_if_the_order_is_ambiguous(): void
    {
        $numberOfPlayers = 3;
        $rolls = [
            4, // roll for player 1
            6, // roll for player 2
            4, // roll for player 3
            2, // roll for player 1
            3, // roll for player 3
        ];
        $determinePlayOrder = new DeterminePlayOrder(new InputStub($numberOfPlayers, $rolls));

        $playOrder = $determinePlayOrder->determine();

        $this->assertEquals(new PlayOrder([1, 2, 0]), $playOrder);
    }

    /**
     * @test
     */
    public function determinePlayOrderForSomeRandomInputs()
    {
        for ($i = 1; $i < 1000; $i++) {
            $determinePlayOrder = new DeterminePlayOrder(new RandomInput());

            $determinePlayOrder->determine();
        }

        $this->addToAssertionCount(1);
    }
}
