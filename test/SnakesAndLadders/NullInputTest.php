<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class NullInputTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_roll_a_die()
    {
        $input = new RandomInput();

        $roll = $input->rollDie(0);

        $this->assertInstanceOf(Roll::class, $roll);
    }
}
