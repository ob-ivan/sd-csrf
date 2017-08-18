<?php
namespace SD\Csrf;

class Manager {
    const TOKEN_TTL_MINUTES = 60;
    const TOKEN_MAX_REUSE   = 5;

    public function __construct() {
        session_start();
    }

    public function verify(string $name, string $value): bool {
        $token = $this->get($name);
        $result = hash_equals($token->getValue(), $value);
        $reuseLeft = $token->getReuseLeft() - 1;
        $key = $this->key($name);
        if ($reuseLeft < 1) {
            unset($_SESSION[$key]);
        } else {
            $_SESSION[$key] = $token->decrement();
        }
        return $result;
    }

    public function get(string $name): Token {
        $key = $this->key($name);
        if (isset($_SESSION[$key])) {
            $token = $_SESSION[$key];
            if (!$token instanceof Token ||
                $token->getName() !== $name ||
                $token->getExpireUnix() < time()
            ) {
                unset($_SESSION[$key]);
            }
        }
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = $this->token($name);
        }
        return $_SESSION[$key];
    }

    private function key(string $name): string {
        return 'csrf_token_' . $name;
    }

    private function token(string $name): Token {
        return new Token(
            $name,
            bin2hex(random_bytes(32)),
            time() + self::TOKEN_TTL_MINUTES * 60,
            self::TOKEN_MAX_REUSE
        );
    }
}
