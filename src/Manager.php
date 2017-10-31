<?php
namespace SD\Csrf;

use Symfony\Component\HttpFoundation\Session\Session;

class Manager {
    const TOKEN_TTL_MINUTES = 60;
    const TOKEN_MAX_REUSE   = 5;

    private $session;

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function verify(string $name, string $value): bool {
        $token = $this->get($name);
        $result = hash_equals($token->getValue(), $value);
        $reuseLeft = $token->getReuseLeft() - 1;
        $key = $this->key($name);
        if ($reuseLeft < 1) {
            $this->session->remove($key);
        } else {
            $this->session->set($key, $token->decrement());
        }
        return $result;
    }

    public function get(string $name): Token {
        $key = $this->key($name);
        if ($this->session->has($key)) {
            $token = $this->session->get($key);
            if (!$token instanceof Token ||
                $token->getName() !== $name ||
                $token->getExpireUnix() < time()
            ) {
                $this->session->remove($key);
            }
        }
        if (!$this->session->has($key)) {
            $this->session->set($key, $this->token($name));
        }
        return $this->session->get($key);
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
