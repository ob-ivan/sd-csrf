<?php
namespace SD\Csrf;

class Token {
    private $name;
    private $value;
    private $expireUnix;
    private $reuseLeft;

    public function __construct(string $name, string $value, int $expireUnix, int $reuseLeft) {
        $this->name = $name;
        $this->value = $value;
        $this->expireUnix = $expireUnix;
        $this->reuseLeft = $reuseLeft;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function getExpireUnix(): int {
        return $this->expireUnix;
    }

    public function getReuseLeft(): int {
        return $this->reuseLeft;
    }

    public function decrement(): self {
        return new self(
            $this->name,
            $this->value,
            $this->expireUnix,
            $this->reuseLeft - 1
        );
    }
}
