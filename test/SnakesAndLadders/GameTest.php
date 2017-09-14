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

        $game->move($token, Roll::withNumberOfEyes(3));

        $this->assertEquals(4, $game->currentSquareOfToken($token));
    }

    /**
     * @test
     */
    public function the_game_is_won_when_the_token_reaches_square_100(): void
    {
        $game = Game::start();
        $token = new Token();
        $someOtherToken = new Token();
        $game->placeOnBoard($token);
        $game->placeOnBoard($someOtherToken);

        // TODO deduplicate this logic
        for ($i = 1; $i <= 16; $i++) {
            // 16 * 6 = square 97
            $game->move($token, Roll::withNumberOfEyes(6));
        }

        $game->move($token, Roll::withNumberOfEyes(3));

        $this->assertTrue($game->wasWonBy($token));
        $this->assertFalse($game->wasWonBy($someOtherToken));
    }

    /**
     * @test
     */
    public function when_the_token_lands_on_a_snake_the_token_moves_back_to_the_connected_square()
    {
        $game = Game::start();
        $token = new Token();
        $game->placeOnBoard($token);

        $game->addSnake(4, 2);

        // the token moves to square 4
        $game->move($token, Roll::withNumberOfEyes(3));

        $this->assertEquals(2, $game->currentSquareOfToken($token));
    }

    /**
     * @test
     */
    public function when_the_token_lands_on_a_ladder_the_token_moves_forward_to_the_connected_square()
    {
        $game = Game::start();
        $token = new Token();
        $game->placeOnBoard($token);

        $game->addLadder(2, 12);

        // the token moves to square 2
        $game->move($token, Roll::withNumberOfEyes(1));

        $this->assertEquals(12, $game->currentSquareOfToken($token));
    }
}
