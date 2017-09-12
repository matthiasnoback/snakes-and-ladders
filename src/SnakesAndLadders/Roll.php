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

    public static function fromInt(int $numberOfEyes): Roll
    {
        return new self($numberOfEyes);
    }

    public function numberOfEyes(): int
    {
        return $this->numberOfEyes;
    }
}
