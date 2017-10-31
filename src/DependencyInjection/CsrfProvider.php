<?php
namespace SD\Csrf\DependencyInjection;

use SD\Csrf\Manager;
use SD\DependencyInjection\ProviderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CsrfProvider implements ProviderInterface {
    private $session;

    public function getServiceName(): string {
        return 'csrf';
    }

    public function provide() {
        return new Manager($this->getSession());
    }

    public function setSession(Session $session) {
        $this->session = $session;
    }

    private function getSession() {
        if (!$this->session) {
            $this->session = new Session();
        }
        return $this->session;
    }
}
