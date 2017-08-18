<?php
namespace SD\Csrf\DependencyInjection;

use SD\Csrf\Manager;

trait CsrfAwareTrait {
    private $csrf;

    public function setCsrf(Manager $csrf) {
        $this->csrf = $csrf;
    }
}
