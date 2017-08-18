<?php
namespace SD\Csrf\DependencyInjection;

use SD\Csrf\Manager;

trait CsrfAwareTrait {
    private $autoDeclareCsrf = 'csrf';
    private $csrf;

    public function setCsrf(Manager $csrf) {
        $this->csrf = $csrf;
    }

    private function getCsrf(): Manager {
        return $this->csrf;
    }
}
