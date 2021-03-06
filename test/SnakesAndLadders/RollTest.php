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

        $roll = Roll::withNumberOfEyes($numberOfEyes);

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

    /**
     * @test
     */
    public function you_can_roll_a_random_roll(): void
    {
        for ($i = 1; $i < 1000; $i++) {
            Roll::roll();
        }

        $this->addToAssertionCount(1);
    }

    /**
     * @test
     */
    public function it_can_determine_if_the_number_of_eyes_in_a_roll_is_higher_than_in_another_one(): void
    {
        $origin = Roll::withNumberOfEyes(3);
        $higher = Roll::withNumberOfEyes(4);
        $equal = Roll::withNumberOfEyes(3);
        $lower = Roll::withNumberOfEyes(2);

        $this->assertTrue($higher->isHigherThan($origin));
        $this->assertFalse($lower->isHigherThan($higher));
        $this->assertFalse($origin->isHigherThan($equal));
    }
}
