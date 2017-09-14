<?php
declare(strict_types=1);

namespace SnakesAndLadders;

final class DeterminePlayOrder
{
    /**
     * @var Input
     */
    private $input;

    public function __construct(Input $input)
    {
        $this->input = $input;
    }

    public function determine(int $numberOfPlayers): PlayOrder
    {
        $allPlayers = range(0, $numberOfPlayers - 1);

        return new PlayOrder($this->determineInLoop($allPlayers, []));
    }

    private function determineInLoop(array $remainingPlayers, array $determinedSoFar): array
    {
        if (count($remainingPlayers) === 1) {
            return array_merge($determinedSoFar, $remainingPlayers);
        }

        $rolls = array_map(function(int $player) {
            return $this->input->rollDie($player);
        }, $remainingPlayers);

        $eyes = array_map(function(Roll $roll) {
            return $roll->numberOfEyes();
        }, $rolls);

        arsort($eyes);
        $highestRoll = reset($eyes);
        $nextHighestRoll = next($eyes);

        if ($highestRoll === $nextHighestRoll) {
            // try again
            return $this->determineInLoop($remainingPlayers, $determinedSoFar);
        }

        reset($eyes);
        $highestRollingPlayer = key($eyes);

        $remainingPlayers = array_filter($remainingPlayers, function(int $player) use ($highestRollingPlayer) {
            return $player !== $highestRollingPlayer;
        });

        return $this->determineInLoop($remainingPlayers, array_merge($determinedSoFar, [$highestRollingPlayer]));
    }
}
