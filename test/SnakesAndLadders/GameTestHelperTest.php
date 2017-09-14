<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class GameTestHelperTest extends TestCase
{
    /**
     * @test
     * @dataProvider squareProvider
     */
    public function you_can_fast_forward_a_token_to_a_given_square(int $square): void
    {
        $game = Game::start();
        $token = new Token();
        $game->placeOnBoard($token);
        $gameTestHelper = new GameTestHelper($game);

        $gameTestHelper->fastForwardToSquare($token, $square);

        $this->assertEquals($square, $game->currentSquareOfToken($token));
    }

    public function squareProvider(): array
    {
        return array_map(function ($value) {
            return [$value];
        }, range(1, 100));
    }
}
