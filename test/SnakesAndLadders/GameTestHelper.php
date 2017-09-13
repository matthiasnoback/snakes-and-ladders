<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use Webmozart\Assert\Assert;

final class GameTestHelper
{
    /**
     * @var Game
     */
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function fastForwardToSquare(Token $token, int $square): void
    {
        $this->game->placeOnBoard($token);

        $stepsToTake = $square - 1;
        $moveSixSteps = floor($stepsToTake / 6);
        $thenMove = $stepsToTake % 6;

        for ($i = 1; $i <= $moveSixSteps; $i++) {
            $this->game->move($token, Roll::withNumberOfEyes(6));
        }

        if ($thenMove > 0) {
            $this->game->move($token, Roll::withNumberOfEyes($thenMove));
        }
    }
}
