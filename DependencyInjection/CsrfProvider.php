<?php
namespace SD\Csrf\DependencyInjection;

use SD\Csrf\Manager;
use SD\DependencyInjection\ProviderInterface;

class CsrfProvider implements ProviderInterface {
    public function getServiceName(): string {
        return 'csrf';
    }

    public function provide() {
        return new Manager();
    }
}
