<?php
declare(strict_types=1);

namespace SnakesAndLadders;

use Webmozart\Assert\Assert;

final class Roll
{
    /**
     * @var int
     */
    private $numberOfEyes;

    private function __construct(int $numberOfEyes)
    {
        Assert::range($numberOfEyes, 1, 6);

        $this->numberOfEyes = $numberOfEyes;
    }

    public static function withNumberOfEyes(int $numberOfEyes): Roll
    {
        return new self($numberOfEyes);
    }

    public static function roll(): Roll
    {
        return Roll::withNumberOfEyes(random_int(1, 6));
    }

    public function numberOfEyes(): int
    {
        return $this->numberOfEyes;
    }

    public function isHigherThan(Roll $compareWith): bool
    {
        return $this->numberOfEyes() > $compareWith->numberOfEyes();
    }
}
