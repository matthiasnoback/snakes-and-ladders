<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use PHPUnit\Framework\TestCase;

final class RollTest extends TestCase
{

    /**
     * @test
     * @dataProvider numberOfEyes
     */
    public function number_of_eyes_on_a_die_are_only_1_to_6(int $numberOfEyes, bool $expectedToSucceed): void
    {
        if (!$expectedToSucceed) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $roll = Roll::fromInt($numberOfEyes);

        $this->assertEquals($numberOfEyes, $roll->numberOfEyes());
    }

    public function numberOfEyes()
    {
        return [
            [0, false],
            [1, true],
            [2, true],
            [3, true],
            [4, true],
            [5, true],
            [6, true],
            [7, false]
        ];
    }
}
