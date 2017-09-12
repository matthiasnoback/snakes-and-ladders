<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_started(): void
    {
        $game = Game::start();

        $this->assertInstanceOf(Game::class, $game);
    }

    /**
     * @test
     */
    public function the_initial_square_of_a_token_is_1(): void
    {
        $game = Game::start();
        $token = new Token();

        $game->placeOnBoard($token);

        $this->assertEquals(1, $game->currentSquareOfToken($token));
    }

    /**
     * @test
     */
    public function you_can_move_the_token_by_a_number_of_spaces(): void
    {
        $game = Game::start();
        $token = new Token();
        $game->placeOnBoard($token);

        $game->move($token, Roll::fromInt(3));

        $this->assertEquals(4, $game->currentSquareOfToken($token));
    }
}
