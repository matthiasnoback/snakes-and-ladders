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

    public function determine(): PlayOrder
    {
        $numberOfPlayers = $this->input->numberOfPlayers();

        $allPlayers = range(0, $numberOfPlayers - 1);
        $allPlayers = array_map(function(int $playerIndex) {
            return new Player($playerIndex);
        }, $allPlayers);

        return new PlayOrder($this->determineInLoop($allPlayers, []));
    }

    private function determineInLoop(array $remainingPlayers, array $determinedSoFar): array
    {
        if (count($remainingPlayers) === 1) {
            return array_merge($determinedSoFar, array_map(function(Player $player) { return $player->index(); }, $remainingPlayers));
        }

        $rolls = array_map(function(Player $player) {
            return $this->input->rollDie($player->index());
        }, $remainingPlayers);

        // TODO what follows might be better off in a first-class collection "Rolls"
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

        $remainingPlayers = array_filter($remainingPlayers, function(Player $player) use ($highestRollingPlayer) {
            return $player->index() !== $highestRollingPlayer;
        });

        return $this->determineInLoop($remainingPlayers, array_merge($determinedSoFar, [$highestRollingPlayer]));
    }
}
