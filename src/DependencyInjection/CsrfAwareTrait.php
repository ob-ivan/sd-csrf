<?php
namespace SD\Csrf\DependencyInjection;

use SD\Csrf\Manager;

trait CsrfAwareTrait {
    protected $autoDeclareCsrf = 'csrf';
    private $csrf;

    public function setCsrf(Manager $csrf) {
        $this->csrf = $csrf;
    }

    protected function getCsrf(): Manager {
        return $this->csrf;
    }
}
